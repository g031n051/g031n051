<?php
$db_user = 'root';     // ユーザー名
$db_pass = ',Ia+iBips3'; // パスワード
$db_name = 'WebApp';     // データベース名

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
// データベース接続におけるエラー処理
if ($mysqli->connect_errno) {
  printf("%s\n", $mysqli->connect_errno);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if(isset($_POST["signUp"])){
    if(empty($_POST['userid'])){
      print '<script>
      alert("ユーザIDを入力してください。");
      location.href = "javascript:history.back();"
      </script>';
    } else if(empty($_POST['password'])){
      print '<script>
      alert("パスワードを入力してください。");
      location.href = "javascript:history.back();"
      </script>';
    }

    // 登録文
    if (!empty($_POST['userid']) && !empty($_POST['password'])) {
      // XSSの対策
      $userid = $mysqli->real_escape_string($_POST['userid']);
      $password = $mysqli->real_escape_string($_POST['password']);
      $password_hash =  password_hash($password, PASSWORD_DEFAULT);

      $insert = $mysqli->query("INSERT IGNORE INTO `account` (`account`, `password`) VALUES ('{$userid}', '{$password_hash}')");

      $insert_count = $mysqli->affected_rows; // sql文によってinsertされた件数を取得する
      if($insert_count == 1){
        print '<script>
        alert("アカウントを登録しました！ログインしてください。");
        location.href = "./login_form.php";
        </script>';
      }else if($insert_count == 0){
        print '<script>
        alert("同一の名前が存在します。\n別の名前を入力してください。");
        location.href = "javascript:history.back();";
        </script>';
      }else{
        // insert文におけるエラー処理
        printf("%s\n", $mysqli->error);
        exit();
      }
    }
  }
}
?>


<html>
<head>
  <title>アカウント登録</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container"><br>
    <?php
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボGO"/>';
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボ"/>';
    ?><br><br>

<h3>アカウント登録</h3><br><br>

    <form action="" method="post">
      <p>ユーザID：<input type="text" name="userid" size="50"　class="form-control" /></p>
      <p>パスワード：<input type="password" name="password" size="20"　class="form-control" /></p><br><br>
      <input type="submit" name="signUp"value="アカウント登録"  class="btn btn-primary" onclick="check()"/>
    </form><br>

    <p><a class="btn btn-primary" href="http://153.126.145.101/WebApp/top.php">トップに戻る</a></p>

  </div>
</body>
</html>
