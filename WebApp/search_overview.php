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

// データベースからツボの詳細を取得
$id = $mysqli->real_escape_string($_GET['id']);
$result = $mysqli->query("SELECT * FROM `tubo` WHERE `id` = {$id}");
// SELECT文におけるエラー処理
if (!$result) {
  printf("%s\n", $mysqli->error);
  exit();
}

$thread_name = $mysqli->query("SELECT `name` FROM `tubo` WHERE `id` = {$id} LIMIT 1");
// SELECT文におけるエラー処理
if (!$result) {
  printf("%s\n", $mysqli->error);
  exit();
}else{
  $thread_name = $thread_name->fetch_assoc()['name'];
}
?>


<html>
<head>
  <title>
    <?php
    echo htmlspecialchars($thread_name);
    ?>
  </title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container"><br>
    <?php
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボGO"/>';
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボ"/>';
    ?><br><br>

    <h1>[ <?php echo htmlspecialchars($thread_name); ?> ]</h1><br>
    <h4>(
      <?php foreach ($result as $row){ ?>
        <?php $hiragana = htmlspecialchars($row['hiragana']); ?>
        <span><?php echo $hiragana; ?>
          )</h4><br>

          <table class="table table-bordered table-striped" border=1>
            <tr>
              <th>効能</th>
              <th>ツボの押し方</th>
              <th>場所</th>
              <th>図解</th>
            </tr>

            <tr>
              <td>
                <?php $description = htmlspecialchars($row['description']); ?>
                <span><?php echo $description; ?></span>
              </td>
              <td>
                <?php $howpush = htmlspecialchars($row['howpush']); ?>
                <span><?php echo $howpush; ?></span>
              </td>
              <td>
                <?php $place = htmlspecialchars($row['place']); ?>
                <span><?php echo $place; ?></span>
              </td>
              <td>
                <?php
                echo '<img src="http://153.126.145.101/WebApp/get_img.php?name='.$thread_name.'"/>';
                ?>
              </td>
            </tr>
            <?php } ?>
          </table>

          <br>
          <p><a class="btn btn-primary" href="javascript:history.back()">ツボ一覧に戻る</a></p>
          <p><a class="btn btn-primary" href="http://153.126.145.101/WebApp/search_efficacy.php">効力一覧に戻る</a></p>
          <p><a class="btn btn-primary" href="http://153.126.145.101/WebApp/MainMenu.php">メインメニューに戻る</a></p>

        </div>
      </body>
      </html>
