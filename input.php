<?php
  require 'connect.php';

 try {
  $sql = 'INSERT INTO events (event_name, details, event_date, user_id) VALUES (:event_name, :details, :event_date, :user_id)';

  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':event_name', $_POST['event_name'], PDO::PARAM_STR);
  $stmt->bindValue(':details', $_POST['details'], PDO::PARAM_STR);
  $stmt->bindValue(':event_date', $_POST['event_date'], PDO::PARAM_STR);
  $stmt->bindValue(':user_id', $_POST['user_id'], PDO::PARAM_INT);
  $stmt->execute();

  header('Location:index.php');
  exit();

} catch(Exception $e) {
  echo 'DB挿入エラー: ' . $e->getMessage();
  var_dump($e);
}
