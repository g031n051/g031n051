<!-- bbs\threads.php -->

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

  // 登録文
  if (!empty($_POST['name']) && !empty($_POST['password'])) {
    // XSSの対策
    $name = $mysqli->real_escape_string($_POST['name']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $insert = $mysqli->query("INSERT INTO `threads` (`name`, `password`) VALUES ('{$name}', '{$password}')");
    print '<script>
    alert("スレッドを登録しました！");
    </script>';

    if (!$insert) {    // insert文におけるエラー処理
      printf("%s\n", $mysqli->error);
      exit();
    }
  }

  // 削除文
  else if (!empty($_POST['del'])) {
    // データベースに登録されているパスワードと入力されているパスワードが等しくなければアラート表示
    $checkpass = $mysqli->real_escape_string($_POST['checkpass']);
    $delete = $mysqli->query("DELETE FROM `threads` WHERE `id` = {$_POST['del']} AND `password` = '{$checkpass}'");

    $delete_count = $mysqli->affected_rows; // sql文によってdeleteされた件数を取得する
    if($delete_count >= 1){ // 1件以上の場合
      print '<script>
      alert("スレッドを削除しました！");
      location.href = "./threads.php";
      </script>';
    }else if ($delete_count == 0){ // 0件の場合
      print '<script>
      alert("パスワードが違います...");
      location.href = "./threads.php";
      </script>';
    }else{
      // delete文におけるエラー処理
      printf("%s\n", $mysqli->error);
      exit();
    }
  }


  // データベースに登録する際に名前・パスワードが入力されていなければアラートを表示
  else if(empty($_POST['name'])){
    print '<script>
    alert("名前を入力してください...");
    </script>';
  } else if(empty($_POST['password'])){
    print '<script>
    alert("パスワードを入力してください...");
    </script>';
  }
}

// データベースからメッセージを降順で取得
$result = $mysqli->query("SELECT * FROM `threads` ORDER BY `id` DESC");
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
    <h2>スレッド一覧</h2>

    <br>
    <form action="threads.php" method="post">
      <p>名前 : <input type="text" name="name" style="width:400px;" class="form-control"/></p>
      <p>パスワード :　<input type="password" name="password" style="width:100px;" class="form-control" /></p>
      <input type="submit" value="投稿"  class="btn btn-primary" onclick="check()"/>
    </form>
    <br><br>

    <table class="table" border=1>
      <tr><th style="width:200px;">名前</th><th style="width:80px;">更新日時</th>
        <th style="width:130px;">パスワード</th><th style="width:50px;"></th></tr>

        <?php foreach ($result as $row){ ?>
          <tr>
            <td><?php $name = htmlspecialchars($row['name']);
            $thread_name= htmlspecialchars($row['name']);
            $id= htmlspecialchars($row['id']);?>
            <span><a href="messages.php?id=<?php echo $id; ?>&thread_name=<?php echo $thread_name; ?>"><?php echo $name; ?></a></span></td>
            <td><?php $timestamp = htmlspecialchars($row['timestamp']); ?>
              <span><?php echo $timestamp; ?></span></td>
              <form action="threads.php" method="post">
                <td><input type="password" name="checkpass" style="width:100px;" class="form-control" /></td>
                <td>
                  <input type="hidden" name="del" value="<?php echo $id; ?>" />
                  <input type="submit" value="削除" class="btn btn-primary" />
                </form></td>
              </tr>
              <?php } ?>
            </table>
          </div>
        </body>
        </html>
