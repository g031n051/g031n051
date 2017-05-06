<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>一問一答式クイズ</title>
</head>
<body>
  <h2>”情報システム演習ⅠのTAは誰ですか？”</h2>
  <form action="quiz1-1.php" method="post">
    <input type="text" name="answer" />
    <input type="submit" />
  </form>
</body>
</html>

<?php

if (isset($_POST['answer'] ) and
($_POST['answer'] === 'てつか' or $_POST['answer'] === 'ひらの' or
$_POST['answer'] === '手塚' or $_POST['answer'] === '平野' or
$_POST['answer'] === 'tetsuka' or $_POST['answer'] === 'hirano' or
$_POST['answer'] === 'Tetsuka' or  $_POST['answer'] === 'Hirano') ) {
  echo "<h4><br>\n正解!!</h4>";
}
elseif (isset($_POST['answer'] )){
  echo "<h4><br>\n不正解・・・</h4>";
}
?>
