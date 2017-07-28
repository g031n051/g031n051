<!-- http://153.126.145.101/WebApp/top.php -->

<html>
<head>
  <title>トップメニュー</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
</head>

<body>
  <div class="container"><br>
    <?php
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボGO"/>';
    echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボ"/>';
    ?><br><br>

    <h3>トップ</h3><br><br>

    <form action="login_form.php" method="post">
      <input type="submit" value="ログイン"  class="btn btn-primary" onclick="check()"/>
    </form><br>

    <form action="create_account.php" method="post">
      <input type="submit" value="アカウント登録"  class="btn btn-primary" onclick="check()"/>
    </form>

  </div>
</body>
</html>
