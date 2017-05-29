<!-- bbs\messages.php -->

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

  if(!empty($_GET['checkpass'])){
    print '<script>
    alert("パスワードが違います");
    </script>';
  }

  // データベースに登録文
  if (!empty($_POST['name']) && !empty($_POST['body']) && !empty($_POST['password'])) {
    // XSSの対策
    $name = $mysqli->real_escape_string($_POST['name']);
    $body = $mysqli->real_escape_string($_POST['body']);
    $id = $mysqli->real_escape_string($_GET['id']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $insert = $mysqli->query("INSERT INTO messages (name, body, thread_id, password) VALUES ('{$name}', '{$body}', '{$id}', '{$password}')");
    print '<script>
    alert("コメントを登録しました！");
    </script>';

    if (!$insert) {    // insert文におけるエラー処理
      printf("%s\n", $mysqli->error);
      exit();
    }
  }

  // コメントの削除文
  else if (!empty($_POST['del'])) {
    $delete = $mysqli->query("DELETE FROM messages WHERE id = {$_POST['del']}");
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
    if (!empty($_POST['upd_body'])){
      // XSSの対策
      $upd_body = $mysqli->real_escape_string($_POST['upd_body']);

      $update = $mysqli->query("UPDATE  messages SET body='{$upd_body}' WHERE id = {$_POST['upd']}");
      // update文におけるエラー処理
      if (!$update) {
        printf("%s\n", $mysqli->error);
        exit();
      }
      print '<script>
      alert("コメントを編集しました！");
      </script>';
    }
    else{
      print '<script>
      alert("コメントを入力してください...");
      </script>';
    }
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
$id = $_GET['id'];
$result = $mysqli->query("SELECT * FROM `threads` INNER JOIN `messages` ON `threads`.`id` = `messages`.`thread_id` WHERE `threads`.`id` = {$id} ORDER BY `messages`.`id` DESC");
// SELECT文におけるエラー処理
if (!$result) {
  printf("%s\n", $mysqli->error);
  exit();
}
?>


<html>
<head>
  <title> <?php echo $_GET['thread_name']; ?></title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
    <br>
    <h1>[<?php echo $_GET['thread_name']; ?>]</h1>
    <br><br>
    <h2>入力フォーム</h2>

    <br>
    <form action="messages.php?id=<?php echo $_GET['id']; ?>&thread_name=<?php echo $_GET['thread_name']; ?>" method="post">
      <p>名前 : <input type="text" name="name" style="width:400px;" class="form-control"/></p>
      <p>コメント : <input type="text" name="body" style="width:400px;" class="form-control" /></p>
      <p>パスワード :　<input type="password" name="password" style="width:100px;" class="form-control" /></p>
      <input type="submit" value="投稿"  class="btn btn-primary" onclick="check()"/>
    </form>
    <br><br>

    <table class="table" border=1>
      <tr><th style="width:200px;">名前</th><th style="width:500px;">コメント</th><th style="width:80px;">更新日時</th>
        <th style="width:130px;">パスワード</th><th style="width:50px;"></th></tr>

        <?php foreach ($result as $row){ ?>
          <tr>
            <td><?php $name = htmlspecialchars($row['name']); ?>
              <span><?php echo $name; ?></span></td>
              <td><?php $body = htmlspecialchars($row['body']); ?>
                <span><?php echo $body; ?></span></td>
                <td><?php $timestamp = htmlspecialchars($row['timestamp']); ?>
                  <span><?php echo $timestamp; ?></span></td>
                  <form action="edit_delete_message.php?id=<?php echo $_GET['id']; ?>&thread_name=<?php echo $_GET['thread_name']; ?>" method="post">
                    <td><input type="password" name="checkpass" style="width:100px;" class="form-control" /></td>
                    <td>
                      <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                      <input type="hidden" name="name" value="<?php echo $row['name']; ?>" />
                      <input type="hidden" name="body" value="<?php echo $row['body']; ?>" />
                      <input type="hidden" name="password" value="<?php echo $row['password']; ?>" />
                      <input type="submit" value="編集" class="btn btn-primary" />
                    </form></td>
                  </tr>
                  <?php } ?>
                </table>

                <p><a href="threads.php">ホームに戻る</a></p>

              </div>
            </body>
            </html>
