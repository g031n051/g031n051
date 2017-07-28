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
$result = $mysqli->query("SELECT `tubo`.`id`,`tubo`.`name`,`tubo`.`efficacy` FROM `tubo` INNER JOIN `favorite` ON `tubo`.`id` = `favorite`.`tubo_id` WHERE `favorite`.`account` = '{$account}' ORDER BY `favorite`.`id` DESC");
// SELECT文におけるエラー処理
if (!$result) {
  printf("%s\n", $mysqli->error);
  exit();
}
?>


<html>
<head>
  <title> お気に入りリスト</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container"><br>
    <?php
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボGO"/>';
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボ"/>';
    ?><br><br>

<h3>お気に入りリスト</h3><br><br>

    <table class="table table-bordered table-striped" border=1>
      <tr>
        <th>名前</th>
        <th>効力</th>
      </tr>

      <?php foreach ($result as $row){ ?>
        <tr>
          <td>
            <?php
            $name = htmlspecialchars($row['name']);
            $id = htmlspecialchars($row['id']);
            ?>
            <span><a href="favorite_tubo.php?id=<?php echo $id; ?>"><?php echo $name; ?></a></span>
          </td>
          <td>
            <?php
            $efficacy = htmlspecialchars($row['efficacy']);
            echo $efficacy;
            ?>
            <br>
          </td>
        </tr>
        <?php } ?>
      </table>

      <br>
      <p><a class="btn btn-primary" href="http://153.126.145.101/WebApp/MainMenu.php">メインメニューに戻る</a></p>

    </div>
  </body>
  </html>
