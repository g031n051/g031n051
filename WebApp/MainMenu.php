<?php
session_start();

// // ログイン状態のチェック
// if (!isset($_SESSION["USERID"])) {
//   header("Location: logout.php");
//   exit;
// }

?>

<html>
<head>
  <title>メインメニュー</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container"><br>
    <h1>ツボツボGO</h1><br><br>

    <p>ようこそ<?=htmlspecialchars($_SESSION["USERID"], ENT_QUOTES); ?>さん</p>
    <ul>
      <li><a href="logout.php">ログアウト</a></li>
    </ul>


    <form action="search_efficacy.php" method="post">
      <input type="submit" value="ツボを探す"  class="btn btn-primary" onclick="check()"/>
    </form>

    <form action="favorite.php" method="post">
      <input type="submit" value="お気に入りリスト"  class="btn btn-primary" onclick="check()"/>
    </form>

  </div>
</body>
</html>
