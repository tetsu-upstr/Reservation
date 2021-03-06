<?php
session_start();
require('connect.php');

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

if ($_COOKIE['email'] !== '') {
  $email = $_COOKIE['email'];
} 

// ログインチェック
if (!empty($_POST)) {
  // 基本はクッキーの値で、POSTされている場合はPOSTされた値を表示
  $email = $_POST['email'];

  if ($_POST['email'] !== '' && $_POST['password'] !== '') {
    
      $login = $pdo->prepare('SELECT * FROM users WHERE email=? AND password=?');
      $login->execute(array(
        $_POST['email'],
        sha1($_POST['password'])
      ));

      // データが返ってきていればログインが成功していることになる
      $user = $login->fetch();

      // $userの値が入っている（=ture）ならログイン処理
      if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['time'] = time();
      
        // メールアドレスをクッキーに14日間、保存
        if ($_POST['save'] === 'on') {
          setcookie('email', $_POST['email'], time()+60*60*24*14);
        }

        header('Location: index.php');
        exit();

      } else {
        $error['login'] = 'failed';
      } 
      
  } else {
    $error['login'] = 'blank';
  } 
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<title>ログイン</title>
</head>

<body>
<div class="l-wrap">
  <h2 class="login-title">ログイン</h2>
  <p class="login-test">テストユーザー：test@test.com パスワード：12345678</p>
    <div class="form">
      <form action="" method="post">
          <p>メールアドレス</p>
          <input type="text" name="email" size="35" maxlength="255" value="<?php print h($email); ?>" />
          <?php if($error['login'] == 'blank'): ?>
            <p class="error">メールアドレスとパスワードを入力してください。</p>
          <?php endif; ?>

          <?php if($error['login'] == 'failed'): ?>
            <p class="error">ログインに失敗しました。正しくご記入ください。</p>
            <?php endif; ?>

          <p>パスワード</p>
            <input type="password" name="password" size="35" maxlength="255" value="<?php print h($_POST['password']); ?>" />

          <p>ログイン情報の記録</p>
            <input id="save" type="checkbox" name="save" value="on">
            <label for="save">自動ログイン</label>
          <div class="login-btn">
            <input type="submit" value="ログイン" />
          </div>
      </form>
    </div>
    <div class="register">
      <p>会員登録はコチラ</p>
      <p>&raquo;<a href="register.php">会員登録する</a></p>
    </div>

</div>
</body>
</html>