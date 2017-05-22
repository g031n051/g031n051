<!-- Bulletin_board\password.php -->

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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // データベースに登録されているパスワードと入力されているパスワードが等しくなければアラート表示
  if ($_POST['password'] !== $_POST['checkpass']){
    print '<script>
                alert("パスワードが違います");
                location.href = "./bbs.php";
              </script>';
        exit();
}
}

?>

<html>
<head>
  <title> パスワード確認フォーム</title>
  <meta charset="UTF-8">
</head>

<body>
<table class="table" border=1>
  <tr><th>名前</th><th>コメント</th><th>編集or削除</th>

    <tr>
      <form action="bbs.php" method="post">
      <td><input type="text" name="upd_name" value="<?php echo $_POST['name']; ?>" /></td>
      <td><input type="text" name="upd_body" value="<?php echo $_POST['body']; ?>" /></td>
      <td><input type="hidden" name="upd" value="<?php echo $_POST['id']; ?>" />
      <input type="submit" value="編集" /></form>
      <form action="bbs.php" method="post">
      <input type="hidden" name="del" value="<?php echo $_POST['id']; ?>" />
      <input type="submit" value="削除" /></td>
    </form>
    </tr>
</table>
</body>

</html>
