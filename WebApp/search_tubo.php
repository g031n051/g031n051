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

// データベースからツボ一覧を取得
$efficacy = $mysqli->real_escape_string($_GET['efficacy']);
$result = $mysqli->query("SELECT `name`,`category`,`id` FROM `tubo` WHERE `efficacy` = '{$efficacy}'");
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
    <?php
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボGO"/>';
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボ"/>';
    ?><br><br>

    <table class="table table-bordered table-striped" border=1>
      <tr>
        <th><?php echo $efficacy; ?>に効くツボ一覧</th>
        <th>カテゴリー</th>
      </tr>

      <?php foreach ($result as $row){ ?>
        <tr>
          <td>
            <?php
            $name = htmlspecialchars($row['name']);
            $thread_name= htmlspecialchars($row['name']);
            $id= htmlspecialchars($row['id']);
            ?>
            <span><a href="search_overview.php?id=<?php echo $id; ?>"><?php echo $name; ?></a></span>
          </td>
          <td>
            <?php
            $category = htmlspecialchars($row['category']);
            echo $category;
            ?>
            <br>
          </td>
        </tr>
        <?php } ?>
      </table>

      <br>
      <p><a class="btn btn-primary" href="http://153.126.145.101/WebApp/search_efficacy.php">効力一覧に戻る</a></p>
      <p><a class="btn btn-primary" href="http://153.126.145.101/WebApp/MainMenu.php">メインメニューに戻る</a></p>

    </div>
  </body>
  </html>
