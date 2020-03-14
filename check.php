<?php
session_start();
require('connect.php');

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

if (!isset($_SESSION['join'])) {
  // ログインせずに確認画面に来たらログイン画面にリダイレクト
  header('Location: top.php');
  exit();
}

// $_POSTの値があれば、データベースに登録内容を保存する
if(!empty($_POST)) {
  $stmt = $pdo->prepare('INSERT INTO users SET name=?, email=?, password=?, created=NOW()');
  $stmt->execute(array(
    $_SESSION['join']['name'],
    $_SESSION['join']['email'],
    // パスワードは暗号化する
    sha1($_SESSION['join']['password']),
  ));
  
  // 処理後にセッションを空にする
  unset($_SESSION['join']);
  header('Location: thanks.php');
  exit();

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
<div class="l-wrap">
  <div id="head">
    <h2>会員登録</h2>
  </div>

  <p>記入した内容を確認して、<br>「登録する」ボタンをクリックしてください</p>
  <form action="" method="post">
	  <input type="hidden" name="action" value="submit" />
		<p>名前</p>
    <?php print(h($_SESSION['join']['name'])); ?>
		<p>メールアドレス</p>
    <?php print(h($_SESSION['join']['email'])); ?>
		<p>パスワード</p>
    【表示されません】
    <div class="submit-btn"><<a href="register.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する" /></div>
  </form>

</div>
</body>
</html>
