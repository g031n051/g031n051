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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (!empty($_POST['name'])) {
    $name = $mysqli->real_escape_string($_POST['name']);

    $result = $mysqli->query("SELECT `name`,`category` FROM `tubo` WHERE `efficacy` = '{$name}'");
    // SELECT文におけるエラー処理
    if (!$result) {
      printf("%s\n", $mysqli->error);
      exit();
    }
  }
  else{
    print '<script>
    alert("そのような場所は存在しません");
    location.href = history.back();
    </script>';
  }
}
?>


<html>
<head>
  <title></title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container"><br>
    <h1>ツボツボGO</h1><br><br>

    <form action="search_efficacy.php" method="post">
      <input type="submit" value="ツボを探す"  class="btn btn-primary" onclick="check()"/>
    </form>

    <form action="favorite.php" method="post">
      <input type="submit" value="お気に入りリスト"  class="btn btn-primary" onclick="check()"/>
    </form>

  </div>
</body>
</html>
