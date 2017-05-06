<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>アンケートフォーム</title>
</head>
<body>
  <h2>”りゅうさんの好きなところはなんですか？”</h2>
  <form action="result.php" method="post">
    <input name="goodpoint[]" type="checkbox" value="優しい">優しい
    <input name="goodpoint[]" type="checkbox" value="かっこいい">かっこいい
    <input name="goodpoint[]" type="checkbox" value="お金持ち">お金持ち
    <input name="goodpoint[]" type="checkbox" value="怖い">怖い
    <input type="submit" />

    <?php
    foreach ($_POST['language'] as $value) {
      echo '<input type="hidden" name="language[]" value="' . $value . '">';
    }

    foreach ($_POST['study'] as $value) {
      echo '<input type="hidden" name="study[]" value="' . $value . '">';
    }
    ?>

  </form>
</body>
</html>
