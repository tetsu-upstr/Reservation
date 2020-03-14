<?php
session_start();
require('connect.php');
require('function.php');

// フォームを送信した時にだけエラーチェックを走らせる
if(!empty($_POST)) {
  // エラーメッセージのトリガー
  if ($_POST['name'] === '') {
    $error['name'] = 'blank';
  }
  if ($_POST['email'] === '') {
    $error['email'] = 'blank';
  }
  if (strlen($_POST['password']) < 8) {
    $error['password'] = 'length';
  }
  if ($_POST['password'] === '') {
    $error['password'] = 'blank';
  }

  // アカウント重複チェック
  if (empty($error)) {
    $users = $pdo->prepare('SELECT COUNT(*) AS cnt FROM users WHERE email=?');
    $users->execute(array($_POST['email']));
    $record = $users->fetch();
    if ($record['cnt'] > 0 ) {
      $error['email'] = 'duplication';
    }
  }

  if (empty($error)) {
    // エラーがない場合にセッションを渡す（呼び出す場合は二次元配列で表記）
    $_SESSION['join'] = $_POST;
    header('Location: check.php');
    exit();
  }
}

// chech.php書き直すボタン
if ($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
    $_POST = $_SESSION['join'];
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>会員登録</title>
	<link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <div>
    <div>
      <h1>会員登録</h1>
    </div>
  <div id="content">
    <p>次のフォームに必要事項をご記入ください。</p>
    <form action="" method="post">
      <dl>
        <dt>名前<span class="required">必須</span></dt>
        <dd>
              <input type="text" name="name" size="35" maxlength="255" value="<?php print h($_POST['name']); ?>" />
              <?php if($error['name'] == 'blank'): ?>
              <p class="error">名前を入力してください。</p>
              <?php endif; ?>
        </dd>

        <dt>メールアドレス<span class="required">必須</span></dt>
        <dd>
              <input type="text" name="email" size="35" maxlength="255" value="<?php print h($_POST['email']); ?>" />
              <?php if($error['email'] == 'blank'): ?>
              <p class="error">メールアドレスを入力してください。</p>
              <?php elseif($error['email'] == 'duplication'): ?>
              <p class="error">メールアドレスは登録済みです。</p>
              <?php endif; ?>
        </dd>     

        <dt>パスワード<span class="required">必須</span></dt>
        <dd>
              <input type="password" name="password" size="10" maxlength="20" value="<?php print h($_POST['password']); ?>" />
              <?php if($error['password'] == 'blank'): ?>
              <p class="error">パスワードを入力してください。</p>
              <?php endif; ?>
        </dd>
      </dl>

      <div><input type="submit" value="入力内容を確認する" /></div>
    </form>
  </div>
</body>
</html>
