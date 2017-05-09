<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>アンケート結果</title>
</head>
<body>
  <h2>”アンケート結果”</h2>

  <?php
  echo "「あなたの好きな言語はなんですか？」 -> [回答] ";
  foreach ($_POST['language'] as $value) {
    echo ' ・' . $value;
  }

  echo '<br>';

  echo "「興味のある研究分野はなんですか？」 -> [回答] ";
  foreach ($_POST['study'] as $value) {
    echo ' ・' . $value;
  }

  echo '<br>';

  echo "「りゅうさんの好きなところはなんですか？」 -> [回答] ";
  foreach ($_POST['goodpoint'] as $value) {
    echo ' ・' . $value;
  }
  ?>

</body>
</html>
