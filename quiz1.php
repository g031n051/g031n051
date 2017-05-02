<?php
// パスワードにhogehogeと入力されたらユーザー名を出力する
if (isset($_POST['password'])  and $_POST['password'] === 'hogehoge') {
  echo "Hello, {$_POST['username']}! :D";
}
?>

<html>
<head>
</head>
<body>
  <form action="quiz1.php" method="get">
    <input type="text"     name="username" />
    <input type="password" name="password" />
    <input type="submit" />
  </form>
</body>
</html>
