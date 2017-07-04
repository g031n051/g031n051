<?php
$db_user = 'root';     // ユーザー名
$db_pass = ',Ia+iBips3'; // パスワード
$db_name = 'WebApp';     // データベース名

// セッション開始
session_start();

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
// データベース接続におけるエラー処理
if ($mysqli->connect_errno) {
  printf("%s\n", $mysqli->connect_errno);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if(isset($_POST["login"])){
    if(empty($_POST['userid'])){
      print '<script>
      alert("名前を入力してください。");
      location.href = "javascript:history.back();"
      </script>';
    } else if(empty($_POST['password'])){
      print '<script>
      alert("パスワードを入力してください。");
      location.href = "javascript:history.back();"
      </script>';
    }

    if(!empty($_POST["userid"]) && !empty($_POST["password"])){

      $userid = $mysqli->real_escape_string($_POST['userid']);
      $password = $mysqli->real_escape_string($_POST['password']);
      //ユーザ名が一致する行を探す
      $stmt = $mysqli->query("SELECT password FROM account WHERE userID = ?");
      $stmt->bind_param('s', $userid);
      $stmt->execute();

      //結果を保存
      $stmt->store_result();a
      //結果の行数が1だったら成功
      if($stmt->num_rows == 1){
        $stmt->bind_result($pass);
        while ($stmt->fetch()) {
          if(password_verify($password, $pass)){
            //セッションにユーザ名を保存
            $_SESSION["userid"] = $userid;
            print '<script>
            alert("○○でログインしました");
            location.href = "./MainMenu.php";
            </script>';
          }else{
            print '<script>
            alert("名前またはパスワードが違います。");
            location.href = "javascript:history.back();"
            </script>';
          }
        }
      }else
      print '<script>
      alert("名前またはパスワードが違います。");
      location.href = "javascript:history.back();"
      </script>';
    }
  }
}
?>


<html>
<head>
  <title>ログイン</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container"><br>
    <h1>ツボツボGO</h1><br><br>

    <form action="" method="post">
      <p>ユーザID : <input type="text" name="userid" style="width:400px;" class="form-control"/></p>
      <p>PASSWORD :　<input type="password" name="password" style="width:100px;" class="form-control" /></p>
      <input type="submit" name="login" value="ログイン"  class="btn btn-primary" onclick="check()"/>
    </form><br><br>

  </div>
</body>
</html>
