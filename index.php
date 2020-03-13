<?php
date_default_timezone_set('Asia/Tokyo');

// date関数：date ( string $format [, int $timestamp = time() ] ) : string

// 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
if (isset($_GET['ym'])) {
  $ym = $_GET{'ym'};
} else {
  // 今月の年月を表示
  $date = date('y-m');
}

// フォーマットチェック
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
  $ym = date('Y-m');
  $timestamp = strtotime($ym . '-01');
}

// 今日の日付
$today = date('Y-m-j');

// カレンダーのタイトル
$calendar_title = date('Y年n月', $timestamp);

// 前月・次月の年月を取得
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));

// 該当月の日数を取得
$day_count = date('t', $timestamp);

// 1日が何曜日か
$youbi = date('w', $timestamp);

$weeks = [];
$week = '';

// 第1週目に空のセルを追加
// str_repeat — 文字列を反復する
$week .= str_repeat('<td></td>', $youbi);

for ( $day = 1; $day <= $day_count; $day++, $youbi++) {

  // フォーマット
  $date = $ym . '-' . $day;

  if ($today == $date) {
      // 今日の日付にclass="today"を付与
      $week .= '<td class="today">' . $day;
  } else {
    $week .= '<td>' . $day;
  }
  $week .= '</td>';

  // 週終わり（土曜日→date関数の'w'が6）、月終わりの場合
  if ($youbi % 7 == 6 || $day == $day_count) {

    if ($day == $day_count) {
      // 最終日の場合、空セルを追加
      $week .= str_repeat('<td></td>', 6 - ($youbi % 7));
    }

    // week配列にtrと$weekを追加
    $weeks[] = '<tr>' . $week . '</tr>';

    // weekをリセット
    $week = '';
  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>カレンダー</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
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