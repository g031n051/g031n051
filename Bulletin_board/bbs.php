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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // データベースに登録文
  if (!empty($_POST['name']) && !empty($_POST['body']) && !empty($_POST['password'])) {
    $insert = $mysqli->query
    ("INSERT into messages (name, body, password) values ('{$_POST['name']}', '{$_POST['body']}', '{$_POST['password']}')");
    print '<script>
    alert("データベースに登録しました！");
    </script>';

    if (!$insert) {    // insert文におけるエラー処理
      printf("%s\n", $mysqli->error);
      exit();
    }
  }

  // コメントの削除文
  else if (!empty($_POST['del'])) {
    $delete = $mysqli->query("DELETE from messages where id = {$_POST['del']}");
    // delete文におけるエラー処理
    if (!$delete) {
      printf("%s\n", $mysqli->error);
      exit();
    }
    print '<script>
            alert("コメントを削除しました！");
          </script>';
  }

  // コメントの編集文
  else if (!empty($_POST['upd'])) {
    $update = $mysqli->query("UPDATE  messages SET name='{$_POST['upd_name']}', body='{$_POST['upd_body']}' where id = {$_POST['upd']}");
    // update文におけるエラー処理
    if (!$update) {
      printf("%s\n", $mysqli->error);
      exit();
    }
    print '<script>
            alert("コメントを編集しました！");
          </script>';
  }

  // データベースに登録する際に名前・コメント・パスワードが入力されていなければアラートを表示
  else if(empty($_POST['name'])){
    print '<script>
            alert("名前を入力してください...");
          </script>';
  } else if(empty($_POST['body'])){
    print '<script>
            alert("コメントを入力してください...");
          </script>';
  } else if(empty($_POST['password'])){
    print '<script>
            alert("パスワードを入力してください...");
          </script>';
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

  <table class="table" border=1>
    <tr><th>名前</th><th>コメント</th><th>更新日時</th><th>パスワード</th><th>編集</th>

      <?php foreach ($result as $row){ ?>
        <tr>
          <td><?php print($row['name']); ?></td>
          <td><?php print($row['body']); ?></td>
          <td><?php print($row['timestamp']); ?></td>
          <form action="password.php" method="post">
            <td><input type="password" name=checkpass /></td>
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
