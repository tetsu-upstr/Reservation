<?php
session_start();
require 'connect.php';

// ログインしているか確認（セッション時間＝１時間）
if (isset($_SESSION['user_id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();
  $users = $pdo->prepare('SELECT * FROM users WHERE user_id=?');
  $users->execute(array($_SESSION['user_id']));
  $user = $users->fetch();

} else {
  // ログインしていなけばログイン画面に飛ばす
  header('Location: login.php');
  exit();
}

// Ajaxリクエストに基づいて関数をロード
if(isset($_POST['func']) && !empty($_POST['func'])){ 
  switch($_POST['func']){ 
      case 'getCalender': 
          getCalender($_POST['year'],$_POST['month']); 
          break; 
      case 'getEvents': 
          getEvents($_POST['date']); 
          break; 
      default: 
          break; 
  } 
} 

// カレンダー表示
date_default_timezone_set('Asia/Tokyo');

// 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
if (isset($_GET['ym'])) {
  $ym = $_GET{'ym'};
} else {
  // 今月の年月を表示
  $date = date('y-m');
}

// タイムスタンプを作成し、フォーマットをチェック
// マイナスの数字や文字列が入っているか
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
  $ym = date('Y-m');
  $timestamp = strtotime($ym . '-01');
}

// 今日の日付 フォーマット
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

  // テスト
  // $sql = 'SELECT * FROM events';
  // $stmt = $pdo->query($sql);
  // $result = $stmt->fetchall(PDO::FETCH_ASSOC);
  // echo '<pre>';
  // var_dump($result[0][1]);
  // echo '</pre>';

  // SQLの日付とcalenderの日付が等しい場合にイベント名を取得する
  // $sql = 'SELECT * FROM events';
  // $stmt = $pdo->query($sql);
  // foreach($stmt as $row) {
  //   echo $row['event_name'] . $row['details'].'<br>';
  //   echo $row['event_date'].'<br>';
  // }
  // var_dump($date);
  // var_dump($today);
  // var_dump($row['event_date']);

  if ($today == $date) {
      // 今日の日付にclass="today"を付与
      $week .= '<td class="today">' .$day;
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

// $sql = 'SELECT event_name, event_date FROM events ';
//   foreach ($pdo->query($sql) as $row) {
//     print $row['event_name'] . "\t";
//     print $row['event_date'] . "\t";
//   }
