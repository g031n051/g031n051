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

      $insert = $mysqli->query("INSERT IGNORE INTO `account` (`userID`, `password`) VALUES ('{$userid}', '{$password}')");

      $insert_count = $mysqli->affected_rows; // sql文によってinsertされた件数を取得する
      if($insert_count >= 1){
        print '<script>
        alert("アカウントを登録しました！");
        location.href = "./MainMenu.php";
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
    <h1>ツボツボGO</h1><br><br>

    <form action="" method="post">
      <p>ユーザID : <input type="text" name="userid" style="width:400px;" class="form-control"/></p>
      <p>パスワード :　<input type="password" name="password" style="width:100px;" class="form-control" /></p>
      <input type="submit" name="signUp"value="アカウント登録"  class="btn btn-primary" onclick="check()"/>
    </form><br><br>

  </div>
</body>
</html>
