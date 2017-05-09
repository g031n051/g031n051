<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>多肢選択式クイズ</title>
</head>
<body>
  <h2>”情報システム演習ⅠのTAは誰ですか？”</h2>
  <form action="quiz2-1.php" method="post">
    <input name="radiobutton" type="radio" value="さとう">さとう
    <input name="radiobutton" type="radio" value="かんの">かんの
    <input name="radiobutton" type="radio" value="てつか">てつか
    <input name="radiobutton" type="radio" value="ふくさか">ふくさか
    <input type="submit" />
  </form>
</body>
</html>

<?php

if (isset($_POST['radiobutton'] ) and
$_POST['radiobutton'] === 'てつか') {
  echo "<h4><br>\n正解!!</h4>";
}
elseif (isset($_POST['radiobutton'] )){
  echo "<h4><br>\n不正解・・・</h4>";
}
?>
