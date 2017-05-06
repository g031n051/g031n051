<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>アンケートフォーム</title>
</head>
<body>
  <h2>”あなたの好きな言語はなんですか？”</h2>
  <form action="quiz3-2.php" method="post">
    <input name="language[]" type="checkbox" value="PHP">PHP
    <input name="language[]" type="checkbox" value="C言語">C言語
    <input name="language[]" type="checkbox" value="Ruby">Ruby
    <input name="language[]" type="checkbox" value="Java">Java
    <input type="submit" />
  </form>
</body>
</html>
