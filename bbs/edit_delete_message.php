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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // データベースに登録されているパスワードと入力されているパスワードが等しくなければアラート表示
  if ($_POST['password'] !== $_POST['checkpass']){
    print '<script>
    alert("パスワードが違います");
    location.href = "./messages.php";
    </script>';
    exit();
  }
}

?>

<html>
<head>
  <title> パスワード確認フォーム</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
      <br>
        <h1>掲示板</h1>
        <br><br>
        <h2>編集フォーム</h2>

        <br><br>
  <table class="table" border=1>
    <tr><th style="width:500px;">コメント</th><th style="width:100px;"></th></tr>

    <tr>
      <form action="messages.php" method="post">
        <td><input type="text" name="upd_body" style="width:1000px;" value="<?php echo $_POST['body']; ?>" /></td>
        <td><input type="hidden" name="upd" value="<?php echo $_POST['id']; ?>" />
          <input type="submit" value="編集" class="btn btn-primary" /></form>
          <form action="messages.php" method="post">
            <input type="hidden" name="del" value="<?php echo $_POST['id']; ?>" />
            <input type="submit" value="削除" class="btn btn-primary" /></td>
          </form>
        </tr>
      </table>
    </div>
    </body>
    </html>
