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

  // データベースに登録文
  if (!empty($_POST['name']) && !empty($_POST['body']) && !empty($_POST['password'])) {
    // XSSの対策
    $name = $mysqli->real_escape_string($_POST['name']);
    $body = $mysqli->real_escape_string($_POST['body']);
    $id = $mysqli->real_escape_string($_GET['id']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $insert = $mysqli->query("INSERT INTO `messages` (`name`, `body`, `thread_id`, `password`) VALUES ('{$name}', '{$body}', '{$id}', '{$password}')");
    print '<script>
    alert("コメントを登録しました！");
    </script>';

    if (!$insert) {    // insert文におけるエラー処理
      printf("%s\n", $mysqli->error);
      exit();
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
$thread_name = $mysqli->query("SELECT `name` FROM `threads` WHERE `id` = {$_GET['id']} LIMIT 1");
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
  <?php
  $id= htmlspecialchars($_GET['id']);
  ?>
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
    <h1>[ <?php echo htmlspecialchars($thread_name); ?> ]</h1><br><br>
    <h2>入力フォーム</h2><br>

    <form action="messages.php?id=<?php echo $id; ?>" method="post">
      <p>名前 : <input type="text" name="name" style="width:400px;" class="form-control"/></p>
      <p>コメント : <input type="text" name="body" style="width:400px;" class="form-control" /></p>
      <p>パスワード :　<input type="password" name="password" style="width:100px;" class="form-control" /></p>
      <input type="submit" value="投稿"  class="btn btn-primary" onclick="check()"/>
    </form><br><br>

    <table class="table table-bordered table-striped" border=1>
      <tr>
        <th style="width:200px;">名前</th>
        <th style="width:500px;">コメント</th>
        <th style="width:80px;">更新日時</th>
        <th style="width:130px;">パスワード</th>
        <th style="width:50px;"></th>
        <th style="width:50px;"></th>
      </tr>

      <?php foreach ($result as $row){ ?>
        <tr>
          <td>
            <?php $name = htmlspecialchars($row['name']); ?>
            <span><?php echo $name; ?></span>
          </td>
          <td>
            <?php $body = htmlspecialchars($row['body']); ?>
            <span><?php echo $body; ?></span>
          </td>
          <td>
            <?php $timestamp = htmlspecialchars($row['timestamp']); ?>
            <span><?php echo $timestamp; ?></span>
          </td>

          <form action="edit_delete_message.php?id=<?php echo $id; ?>" method="post">
            <td>
              <input type="password" name="checkpass" style="width:100px;" class="form-control" />
            </td>
            <td>
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
              <input type="submit" name="update" value="編集" class="btn btn-primary" />
            </td>
            <td>
            <input type="submit" name="del" value="削除" class="btn btn-danger" />
          </td>
          </form>
        </tr>
        <?php } ?>
      </table>

      <p><a href="threads.php">ホームに戻る</a></p>

    </div>
  </body>
  </html>
