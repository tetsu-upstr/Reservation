<?php
session_start();
require('connect.php');
require('function.php');

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

	<link rel="stylesheet" href="../style.css" />
</head>
<body>
<div id="wrap">
<div id="head">
<h1>会員登録</h1>
</div>

<div id="content">
<p>記入した内容を確認して、「登録する」ボタンをクリックしてください</p>
<form action="" method="post">
	<input type="hidden" name="action" value="submit" />
	<dl>
		<dt>ニックネーム</dt>
		<dd>
    <?php print(h($_SESSION['join']['name'])); ?>
    </dd>
		<dt>メールアドレス</dt>
		<dd>
    <?php print(h($_SESSION['join']['email'])); ?>
    </dd>
		<dt>パスワード</dt>
		<dd>
		【表示されません】
		</dd>
	</dl>
	<div><a href="top.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する" /></div>
</form>
</div>

</div>
</body>
</html>
