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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // データベースに登録文
  if (!empty($_POST['name']) && !empty($_POST['body']) && !empty($_POST['password'])) {
    // XSSの対策
    $name = $mysqli->real_escape_string($_POST['name']);
    $body = $mysqli->real_escape_string($_POST['body']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $insert = $mysqli->query("INSERT into messages (name, body, password) values ('{$name}', '{$body}', '{$password}')");
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
    if (!empty($_POST['upd_body'])){
      // XSSの対策
      $upd_body = $mysqli->real_escape_string($_POST['upd_body']);

      $update = $mysqli->query("UPDATE  messages SET body='{$upd_body}' where id = {$_POST['upd']}");
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
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
      <br>
        <h1>掲示板</h1>
        <br><br>
        <h2>入力フォーム</h2>

        <br>
        <form action="messages.php" method="post">
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
                      <form action="edit_delete_message.php" method="post">
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
                </div>
                </body>
                </html>
