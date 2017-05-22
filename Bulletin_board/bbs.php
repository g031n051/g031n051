<!-- Bulletin_board\bbs.php -->

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

$result_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  /* 名前欄かつメッセージ欄がnullでないとき名前とメッセージをデータベースに登録し、
  名前orメッセージがnullの時はエラー文を返す */
  if (!empty($_POST['name']) && !empty($_POST['body']) && !empty($_POST['password'])) {
    $insert = $mysqli->query
    ("INSERT into messages (name, body, password) values ('{$_POST['name']}', '{$_POST['body']}', '{$_POST['password']}')");
    $result_message = 'データベースに登録しました！';

    if (!$insert) {    // insert文におけるエラー処理
      printf("%s\n", $mysqli->error);
      exit();
    }
  } else if(empty($_POST['name'])){
    $result_message = '名前を入力してください...';
  } else if(empty($_POST['body'])){
    $result_message = 'コメントを入力してください...';
  } else{
    $result_message = 'パスワードを入力してください...';
  }

  // メッセージの編集
  if (!empty($_POST['upd'])) {
    $update = $mysqli->query("UPDATE  messages SET name={$_POST['upd_name']}, body={$_POST['upd_body']}, where id = {$_POST['upd']}");
    // update文におけるエラー処理
    if (!$update) {
      printf("%s\n", $mysqli->error);
      exit();
    }
    $result_message = 'メッセージを編集しました！';

    header("Location: bbs.php?$result_message");
    exit();
  }else {
    $result_message = 'パスワードが違います...';
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
    <p>コメント : <input type="text" name="body" /></p>
    <p>パスワード :　<input type="password" name="password" /></p>
    <input type="submit" value="投稿" />
  </form>

  <br>
  <?php echo $result_message; ?>

  <br>
  <table class="table" border=1>
    <tr><th>名前</th><th>コメント</th><th>更新日時</th><th>パスワード</th><th>編集</th>

    <?php foreach ($result as $row){ ?>
      <tr>
        <td><?php print($row['name']); ?></td>
        <td><?php print($row['body']); ?></td>
        <td><?php print($row['timestamp']); ?></td>
<form action="bbs.php" method="post">
        <td><input type="text" name=password /></td>
        <td>
          <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
          <input type="hidden" name="name" value="<?php echo $row['name']; ?>" />
          <input type="hidden" name="body" value="<?php echo $row['body']; ?>" />
          <input type="hidden" name="password" value="<?php echo $row['password']; ?>" />
          <input type="submit" value="編集" />
        </form></td>
      </tr>
    <?php } ?>
  </table>
</center>
</body>
</html>
