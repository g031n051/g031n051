<!-- bbs\edit_delete_message.php -->

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

  // 削除文
  if (!empty($_POST['del'])) {
    // データベースに登録されているパスワードと入力されているパスワードが等しくなければアラート表示
    $checkpass = $mysqli->real_escape_string($_POST['checkpass']);
    $delete = $mysqli->query("DELETE FROM `messages` WHERE `id` = {$_POST['id']} AND `password` = '{$checkpass}'");

    $delete_count = $mysqli->affected_rows; // sql文によってdeleteされた件数を取得する
    if($delete_count >= 1){ // 1件以上の場合
      print '<script>
      var a = decodeURIComponent(location.search);
      var URL = "http://153.126.145.101/bbs/messages.php"
      alert("コメントを削除しました！");
      location.href = URL + a;
      </script>';
    }else if ($delete_count == 0){ // 0件の場合
      print '<script>
      var a = decodeURIComponent(location.search);
      var URL = "http://153.126.145.101/bbs/messages.php"
      alert("パスワードが違います...");
      location.href = URL + a;
      </script>';
    }else{
      // delete文におけるエラー処理
      printf("%s\n", $mysqli->error);
      exit();
    }
  }

  // 編集ボタンが押された際のレコード読み込み
  else if (!empty($_POST['update'])) {
    $checkpass = $mysqli->real_escape_string($_POST['checkpass']);
    $result = $mysqli->query("SELECT * FROM `messages` WHERE `id` = {$_POST['id']} AND `password` = '{$checkpass}' LIMIT 1");

    $result_count = $mysqli->affected_rows; // sql文によってselectされた件数を取得する
    if ($result_count == 0) {   // 0件の場合
      print '<script>
      var a = decodeURIComponent(location.search);
      var URL = "http://153.126.145.101/bbs/messages.php"
      alert("パスワードが違います...");
      location.href = URL + a;
      </script>';
    }else if ($result_count == -1) {
      printf("%s\n", $mysqli->error);
      exit();
    }
  }

  else if (!empty($_POST['update_body'])){
    // XSSの対策
    $update_body = $mysqli->real_escape_string($_POST['update_body']);
    $id = $mysqli->real_escape_string($_POST['id']);

    $update = $mysqli->query("UPDATE  `messages` SET `body`='{$update_body}' WHERE `id` = {$id}");
    $update_count = $mysqli->affected_rows; // sql文によってupdateされた件数を取得する
    if ($update_count == 1){ // 1件の場合
      print '<script>
      var a = decodeURIComponent(location.search);
      var URL = "http://153.126.145.101/bbs/messages.php"
      alert("コメントを編集しました！");
      location.href = URL + a;
      </script>';
    }else{
      // update文におけるエラー処理
      printf("%s\n", $mysqli->error);
      exit();
    }
  }
  else{
    print '<script>
    alert("コメントを入力してください...！");
    location.href = history.back();
    </script>';
  }
}

?>

<html>
<head>
  <title> パスワード確認フォーム</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container"><br>
    <h1>掲示板</h1><br><br>
    <h2>編集フォーム</h2><br><br>

    <table class="table" border=1>
      <tr>
        <th style="width:500px;">コメント</th>
        <th style="width:100px;"></th>
      </tr>

      <?php $body= htmlspecialchars($result->fetch_assoc()['body']);?>
      <?php $id= htmlspecialchars($_GET['id']);?>
      <tr>
        <form action="edit_delete_message.php?id=<?php echo $id; ?>" method="post">
          <td>
            <input type="text" name="update_body" style="width:1000px;" value="<?php echo $body; ?>" />
          </td>
          <td>
            <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>" />
            <input type="submit" value="編集" class="btn btn-primary" />
          </td>
        </form>
      </tr>
    </table>
  </div>
</body>
</html>
