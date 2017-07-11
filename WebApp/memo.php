<?php
$db_user = 'root';     // ユーザー名
$db_pass = ',Ia+iBips3'; // パスワード
$db_name = 'WebApp';     // データベース名

// セッション開始
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // ログインボタンが押された場合
  if (isset($_POST["login"])) {
    // ユーザIDの入力チェック
    if (empty($_POST["userid"])) {
      print '<script>
      alert("ユーザIDを入力してください...");
      </script>';
    } else if (empty($_POST["checkpass"])) {
      print '<script>
      alert("パスワードを入力してください...");
      </script>';
    }

    // ユーザIDとパスワードが入力されていたら認証する
    if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
      // MySQLに接続
      $mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
      // データベース接続におけるエラー処理
      if ($mysqli->connect_errno) {
        printf("%s\n", $mysqli->connect_errno);
        exit();
      }

      $userid = $mysqli->real_escape_string($_POST['userid']);
      $checkpass = $mysqli->real_escape_string($_POST['checkpass']);

      // クエリの実行
      $select = $mysqli->query("SELECT * FROM `account` WHERE `userID` = '{$userid}' AND `password` = '{$checkpass}'");
      $select_count = $mysqli->affected_rows;
      if ($select_count == 0) {
        print '<script>
        var a = decodeURIComponent(location.search);
        var URL = "http://153.126.145.101/WebApp/login_account.php"
        alert("ユーザIDまたはパスワードが違います...");
        location.href = URL + a;
        </script>';
      }
      else if($select_count >= 1) {
        // 認証成功なら、セッションIDを新規に発行する
        session_regenerate_id(true);
        $_SESSION["USERID"] = $_POST["userid"];
        header("Location: http://153.126.145.101/WebApp/MainMenu.php");
        exit;
      }
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

    <form id="loginForm" name="loginForm" action="" method="POST">
      <fieldset>
        <legend>ログインフォーム</legend>
        <?php echo $select_count; ?>
        <label for="userid">ユーザID</label><input type="text" id="userid" style="width:400px;" name="userid" value="<?php echo htmlspecialchars($_POST["userid"], ENT_QUOTES); ?>" class="form-control">
        <br>
        <label for="password">パスワード</label><input type="password" id="password" style="width:100px;" name="checkpass" class="form-control">
        <br>
        <input type="submit" id="login" name="login" value="ログイン" class="btn btn-primary" onclick="check()"/>
      </fieldset>

    </div>
  </body>
  </html>
