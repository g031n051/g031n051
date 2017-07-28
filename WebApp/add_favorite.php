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
$result = $mysqli->query("SELECT * FROM `favorite` WHERE `account` = '{$account}' AND `tubo_id` = '{$tubo_id}'");
$result_count = $mysqli->affected_rows; // sql文によってresultされた件数を取得する
if($result_count == 1){
  print '<script>
  alert("既にお気に入りリストに登録されています。");
  location.href = "javascript:history.back();";
  </script>';
}else if($result_count == 0){
  $insert = $mysqli->query("INSERT INTO `favorite` (`account`, `tubo_id`) VALUES ('{$account}', '{$tubo_id}')");
  $insert_count = $mysqli->affected_rows; // sql文によってinsertされた件数を取得する
  if($insert_count == 1){
    print '<script>
    alert("お気に入りリストに追加しました！");
    location.href = "javascript:history.back();";
    </script>';
  }else{
    // insert文におけるエラー処理
    printf("%s\n", $mysqli->error);
    exit();
  }
}else{
  // insert文におけるエラー処理
  printf("%s\n", $mysqli->error);
  exit();
}

?>
