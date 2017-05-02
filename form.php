<!-- form.php -->

<?php
// パスワードにhogehogeと入力されたらユーザー名を出力する
if (isset($_GET['password'])  and $_GET['password'] === 'hogehoge') {
  echo "Hello, {$_GET['username']}! :D";
}
?>

<html>
<head>
</head>

<body>
  <form action="form.php" method="get">
    <input type="text"     name="username" />
    <input type="password" name="password" />
    <input type="submit" />
  </form>
</body>
</html>
