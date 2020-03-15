<?php require 'function.php';?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>カレンダー</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-3.4.1.min.js"></script>
</head>
<body>
  <div class="container">
    <!-- イベントの入力フォーム -->
    <!-- <form action="input.php" method="POST">
      <input type="text" name="event_name" placeholder="タイトルを入力" required>
      <input type="text" name="details" placeholder="コメントを入力" required>
      <input type="date" name="event_date" required>
      <input type="hidden" name="user_id" value="<?php print($_SESSION['user_id']) ?>">
      <input type="submit" value="予定を追加する">
    </form> -->
    
    <h3><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $calendar_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
    <table class="table table-borderd">
      <tr>
        <th>日</th>
        <th>月</th>
        <th>火</th>
        <th>水</th>
        <th>木</th>
        <th>金</th>
        <th>土</th>
      </tr>
      <?php
        foreach ($weeks as $week) {
          echo $week;
        }
      ?>
    </table>
  </div>
</body>
</html>