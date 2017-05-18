<?php
$db_user = 'root';     // ユーザー名
$db_pass = ',Ia+iBips3'; // パスワード
$db_name = 'bbs';     // データベース名

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
// データベース接続におけるエラー処理
if ($mysqli->connect_errno) {
  printf("%s\n", $mysqli->connect_errno);
  exit();
}

$result_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

// メッセージの削除
if (!empty($_POST['del'])) {
  $delete = $mysqli->query("DELETE from messages where id = {$_POST['del']}");
  // delete文におけるエラー処理
  if (!$delete) {
    printf("%s\n", $mysqli->error);
    exit();
  }
  $result_message = 'メッセージを削除しました！';

  header('Location: bbs.php');
  exit();
}

if (!empty($_POST['upd'])){
  header('Location: uda.php');
  exit();
}
}

?>

<html>
<head>
  <title> 掲示板</title>
  <meta charset="UTF-8">
</head>

<body>
  <?php echo $row['id']; ?>
<form action="password.php" method="post">
<input type="password" name="password" />
<input type="hidden" name="upd" value="<?php echo $row['id']; ?>" />
<input type="submit" value="編集" />
<input type="hidden" name="del" value="<?php echo $row['id']; ?>" />
<input type="submit" value="削除" />
</form>
</body>

</html>
