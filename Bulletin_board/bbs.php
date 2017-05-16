<!-- Bulletin_board\bbs.php -->

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

  /* 名前欄かつメッセージ欄がnullでないとき名前とメッセージをデータベースに登録し、
  名前orメッセージがnullの時はエラー文を返す */
  if (!empty($_POST['name']) && !empty($_POST['message']) && !empty($_POST['password'])) {
    $insert = $mysqli->query
    ("INSERT into messages (name, body, password) values ('{$_POST['name']}', '{$_POST['message']}', '{$_POST['password']}')");
    // insert文におけるエラー処理
    if (!$insert) {
      printf("%s\n", $mysqli->error);
      exit();
    }
    $result_message = 'データベースに登録しました！';
  } else {
    $result_message = '名前とコメントを入力してください...';
  }

  // メッセージの削除
  if (!empty($_POST['del'])) {
    $delete = $mysqli->query("DELETE from messages where id = {$_POST['del']}");
    // delete文におけるエラー処理
    if (!$delete) {
      printf("%s\n", $mysqli->error);
      exit();
    }
    $result_message = 'メッセージを削除しました！';
  }
}

// データベースからメッセージを降順で取得
$result = $mysqli->query('SELECT * from messages ORDER BY id DESC');
// SELECT文におけるエラー処理
if (!$result) {
  printf("%s\n", $mysqli->error);
  exit();
}
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
  <form action="bbs.php" method="post">
    <p>名前 : <input type="text" name="name" /></p>
    <p>コメント : <input type="text" name="message" /></p>
    <p>パスワード :　<input type="password" name="password" /></p>
    <input type="submit" value="投稿" />
  </form>

  <br>
  <?php
  echo $result_message;
  ?>

  <br>
  <table class="table" border=1>
    <tr><th>名前</th><th>コメント</th><th>投稿時間</th><th>パスワード</th><th>編集or削除</th></tr>

    <?php foreach ($result as $row){ ?>
      <tr>
        <td><?php print($row['name']); ?></td>
        <td><?php print($row['body']); ?></td>
        <td><?php print($row['timestamp']); ?></td>
        <td><form action="bbs.php" method="post">
          <input type="password" name="password" />
        </form></td>
        <td><form action="bbs.php" method="post">
          <input type="hidden" name="del" value="<?php echo $row['id']; ?>" />
          <input type="submit" value="編集" />
          <input type="hidden" name="upd" value="<?php echo $row['id']; ?>" />
          <input type="submit" value="削除" />
        </form></td>
      </tr>
    </center>
    <?php } ?>
  </table>

</body>
</html>
