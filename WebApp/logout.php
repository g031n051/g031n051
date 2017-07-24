<?php
session_start();

header("Content-type: text/html; charset=utf-8");

// ログイン状態のチェック
if (!isset($_SESSION["account"])) {
  header("Location: login_form.php");
  exit();
}

//セッション変数を全て解除
$_SESSION = array();

//セッションクッキーの削除
if (isset($_COOKIE["PHPSESSID"])) {
  setcookie("PHPSESSID", '', time() - 1800, '/');
}

//セッションを破棄する
session_destroy();

?>

<!DOCTYPE html>
<html>
<head>
  <title>ログイン確認</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container"><br>
    <?php
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボGO"/>';
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボ"/>';
    ?><br><br>

    <?php
    echo "<p>ログアウトしました。</p>";

    echo "<a href='login_form.php'>ログイン画面へ</a>";
    ?>

  </div>
</body>
</html>
