<?php
session_start();

header("Content-type: text/html; charset=utf-8");

// ログイン状態のチェック
if (!isset($_SESSION["account"])) {
  header("Location: login_form.php");
  exit();
}
$account = $_SESSION['account'];

?>

<html>
<head>
  <title>メインメニュー</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container"><br>
    <?php
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボGO"/>';
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボ"/>';
    ?><br><br>

    <h3>メインメニュー</h3><br><br>

    <h5><?="<p>".htmlspecialchars($account,ENT_QUOTES)."さん、こんにちは！</p>";?></h5><br>

    <form action="search_efficacy.php" method="post">
      <input type="submit" value="ツボを探す"  class="btn btn-primary" onclick="check()"/>
    </form><br>

    <form action="favorite.php" method="post">
      <input type="submit" value="お気に入りリスト"  class="btn btn-primary" onclick="check()"/>
    </form><br><br>

    <a href="logout.php">ログアウト</a>

  </div>
</body>
</html>
