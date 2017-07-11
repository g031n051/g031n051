<?php
$db_user = 'root';     // ユーザー名
$db_pass = ',Ia+iBips3'; // パスワード
$db_name = 'WebApp';     // データベース名

// セッション開始
session_start();

// エラーメッセージの初期化
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // ログインボタンが押された場合
  if (isset($_POST["login"])) {
    // １．ユーザIDの入力チェック
    if (empty($_POST["userid"])) {
      $errorMessage = "ユーザIDが未入力です。";
    } else if (empty($_POST["password"])) {
      $errorMessage = "パスワードが未入力です。";
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

      // クエリの実行
      $query = "SELECT * FROM `account` WHERE `userID` = {$userid}";
      $result = $mysqli->query($query);
      if (!$result) {
        print('クエリーが失敗しました。' . $mysqli->error);
        $mysqli->close();
        exit();
      }

      while ($row = $result->fetch_assoc()) {
        // パスワード(暗号化済み）の取り出し
        $db_hashed_pwd = $row['password'];
      }

      // データベースの切断
      $mysqli->close();

      // 画面から入力されたパスワードとデータベースから取得したパスワードのハッシュを比較
      //if ($_POST["password"] == $pw) {
      if (password_verify($_POST["password"], $db_hashed_pwd)) {
        // 認証成功なら、セッションIDを新規に発行する
        session_regenerate_id(true);
        $_SESSION["USERID"] = $_POST["userid"];
        header("Location: MainMenu.php");
        exit;
      }
      else {
        // 認証失敗
        $errorMessage = "ユーザIDあるいはパスワードに誤りがあります。";
      }
    } else {
      // 未入力なら何もしない
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
        <div><?php echo $errorMessage ?></div>
        <label for="userid">ユーザID</label><input type="text" id="userid" name="userid" value="<?php echo htmlspecialchars($_POST["userid"], ENT_QUOTES); ?>">
        <br>
        <label for="password">パスワード</label><input type="password" id="password" name="password" value="">
        <br>
        <input type="submit" id="login" name="login" value="ログイン">
      </fieldset>

    </div>
  </body>
  </html>
