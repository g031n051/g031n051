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
$id = $mysqli->real_escape_string($_GET['id']);
$result = $mysqli->query("SELECT `favorite` FROM `account` WHERE `account` = {$account}");
$update = $mysqli->query("UPDATE `account` SET `favorite` = {$result}+','+{$id} WHERE `account` = {$account}");
// SELECT文におけるエラー処理
if (!$result) {
  printf("%s\n", $mysqli->error);
  exit();
}
$update_count = $mysqli->affected_rows; // sql文によってinsertされた件数を取得する
if($insert_count == 1){
  print '<script>
  alert("お気に入りリストに追加しました！");
  location.href = "javascript:history.back();";
  </script>';
}else if($insert_count == 0){
  print '<script>
  alert("同一の名前が存在します。\n別の名前を入力してください。");
  location.href = "javascript:history.back();";
  </script>';
}else{
  // insert文におけるエラー処理
  printf("%s\n", $mysqli->error);
  exit();
}

?>
