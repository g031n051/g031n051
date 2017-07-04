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

// データベースからメッセージを降順で取得
$result = $mysqli->query("SELECT DISTINCT * FROM `tubo`");
// SELECT文におけるエラー処理
if (!$result) {
  printf("%s\n", $mysqli->error);
  exit();
}
?>


<html>
<head>
  <title> ツボを探す</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container"><br>
    <h1>ツボツボGO</h1><br><br>

    <table class="table table-bordered table-striped" border=1>
      <tr>
        <th>効力</th>
      </tr>

      <?php foreach ($result as $row){ ?>
        <tr>
          <td>
            <?php
            $name = htmlspecialchars($row['name']);
            $thread_name= htmlspecialchars($row['name']);
            $id= htmlspecialchars($row['id']);
            ?>
            <span><a href="messages.php?id=<?php echo $id; ?>"><?php echo $name; ?></a></span>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>
  </body>
  </html>
