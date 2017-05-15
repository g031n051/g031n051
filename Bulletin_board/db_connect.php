<!-- Bulletin_board\db_connect.php -->

<?php
$db_user = 'root';     // ユーザー名
$db_pass = ',Ia+iBips3'; // パスワード
$db_name = 'bbs';     // データベース名

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);

$result_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  /* 名前欄かつメッセージ欄がnullでないとき名前とメッセージをデータベースに登録し、
  名前orメッセージがnullの時はエラー文を返す */
  if (!empty($_POST['name']) && !empty($_POST['message'])) {
    $mysqli->query("insert into `messages` (`name`,`body`) values ('{$_POST['name']}', '{$_POST['message']}')");
    $result_message = 'データベースに登録しました！';
  } else {
    $result_message = '名前とコメントを入力してください...';
  }
}

// データベースからメッセージを降順で取得
$result = $mysqli->query('SELECT * from messages ORDER BY id DESC');
?>

<html>
<head>
  <title> 掲示板</title>
  <meta charset="UTF-8">
</head>

<center>
  <h1>掲示板</h1>
  <h2>入力フォーム</h2>

  <br>
  <form action="db_connect.php" method="post">
    <p>名前 : <input type="text" name="name" /></p>
    <p>コメント : <input type="text" name="message" /></p>
    <input type="submit" value="投稿" />
  </form>

  <br>
  <?php
  echo $result_message;
  ?>

  <br>
  <table class="table" border=1>
    <tr><th>名前</th><th>コメント</th><th>投稿時間</th></tr>

    <?php foreach ($result as $row){ ?>
      <tr>
        <td><?php print($row['name']); ?></td>
        <td><?php print($row['body']); ?></td>
        <td><?php print($row['timestamp']); ?></td>
      </tr>
    </center>
    <?php } ?>
  </table>

</body>
</html>
