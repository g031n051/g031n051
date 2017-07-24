<?php
$db_user = 'root';     // ユーザー名
$db_pass = ',Ia+iBips3'; // パスワード
$db_name = 'WebApp';     // データベース名

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
// データベース接続におけるエラー処理
if ($mysqli->connect_errno) {
  printf("%s\n", $mysqli->connect_errno);
  exit();
}

$thread_name = $mysqli->real_escape_string($_GET['name']);

header('Content-Type: image/png');
readfile('http://153.126.145.101/WebApp/img/'.$thread_name.'.gif');
?>
