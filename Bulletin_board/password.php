<!-- Bulletin_board\password.php -->

<?php
$db_user = 'root';     // ユーザー名
$db_pass = ''; // パスワード
$db_name = 'bbs';     // データベース名

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
// データベース接続におけるエラー処理
if ($mysqli->connect_errno) {
  printf("%s\n", $mysqli->connect_errno);
  exit();
}

// メッセージの編集
if (!empty($_POST['upd'])) {
  if ($_POST['password'] === $_POST['checkpass']){
  header("Location: upd.php?");
  exit();
}else {
  $result_message = 'パスワードが違います...';
}
}

$result_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

// メッセージの削除
if (!empty($_POST['del'])) {
  if ($_POST['password'] === $_POST['checkpass']){
  $delete = $mysqli->query("DELETE from messages where id = {$_POST['del']}");
  // delete文におけるエラー処理
  if (!$delete) {
    printf("%s\n", $mysqli->error);
    exit();
  }
  $result_message = 'メッセージを削除しました！';

  header("Location: bbs.php?$result_message");
  exit();
}else {
  $result_message = 'パスワードが違います...';
}
}


}

?>

<html>
<head>
  <title> パスワード確認フォーム</title>
  <meta charset="UTF-8">
</head>

<body>
  <?php echo $result_message; ?>
<form action="password.php" method="post">
<input type="password" name="checkpass" />
<input type="hidden" name="password" value="<?php echo $_POST['password']; ?>" />
<input type="hidden" name="name" value="<?php echo $_POST['name']; ?>" />
<input type="hidden" name="body" value="<?php echo $_POST['body']; ?>" />
<input type="hidden" name="upd" value="id" />
<input type="submit" value="編集" />
<input type="hidden" name="del" value="id" />
<input type="submit" value="削除" />
</form>
</body>

</html>
