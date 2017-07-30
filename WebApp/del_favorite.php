<?php
$db_user = 'root';     // ユーザー名
$db_pass = ',Ia+iBips3'; // パスワード
$db_name = 'WebApp';     // データベース名

session_start();

header("Content-type: text/html; charset=utf-8");

// ログイン状態のチェック
if (!isset($_SESSION["account"])) {
  header("Location: login_form.php");
  exit();
}
$account = $_SESSION['account'];


// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
// データベース接続におけるエラー処理
if ($mysqli->connect_errno) {
  printf("%s\n", $mysqli->connect_errno);
  exit();
}


// データベースからお気に入りリストを取得
$tubo_id = $mysqli->real_escape_string($_GET['id']);
$delete = $mysqli->query("DELETE FROM `favorite` WHERE `tubo_id` = '{$tubo_id}'");
$delete_count = $mysqli->affected_rows; // sql文によってdeleteされた件数を取得する
if($delete_count >= 1){ // 1件以上の場合
  print '<script>
  var a = decodeURIComponent(location.search);
  var URL = "http://153.126.145.101/WebApp/favorite.php"
  alert("お気に入りリストから削除しました！");
  location.href = URL + a;
  </script>';
}else{
  // delete文におけるエラー処理
  printf("%s\n", $mysqli->error);
  exit();
}

?>
