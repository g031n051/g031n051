<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>アンケートフォーム</title>
</head>
<body>
  <h2>”興味のある研究分野はなんですか？”</h2>
  <form action="quiz3-3.php" method="post">
    <input name="study[]" type="checkbox" value="教育">教育
    <input name="study[]" type="checkbox" value="観光">観光
    <input name="study[]" type="checkbox" value="農業">農業
    <input name="study[]" type="checkbox" value="LS">LS
    <input type="submit" />

    <?php
    foreach ($_POST['language'] as $value) {
      echo '<input type="hidden" name="language[]" value="' . $value . '">';
    }
    ?>

  </form>
</body>
</html>
