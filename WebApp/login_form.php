<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

?>

<!DOCTYPE html>
<html>
<head>
  <title>ログイン</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container"><br>
    <?php
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボGO"/>';
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボ"/>';
    ?><br><br>

    <h3>ログイン</h3><br><br>

    <form action="login_check.php" method="post">
      <p>ユーザID：<input type="text" name="account" size="50"　class="form-control" /></p>
      <p>パスワード：<input type="password" name="password" size="20"　class="form-control" /></p><br><br>
      <input type="hidden" name="token" value="<?=$token?>">
      <input type="submit" value="ログイン" class="btn btn-primary" onclick="check()" />
    </form><br>

    <p><a class="btn btn-primary" href="http://153.126.145.101/WebApp/top.php">トップに戻る</a></p>

  </div>
</body>
</html>
