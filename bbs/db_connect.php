<?php
$db_user = 'root';     // ユーザー名
$db_pass = ',Ia+iBips3'; // パスワード
$db_name = 'bbs';     // データベース名

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);

$result_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // フォームで受け取ったメッセージをデータベースに登録
  if (!empty($_POST['message'])) {
    $mysqli->query("insert into `messages` (`body`) values ('{$_POST['message']}')");
    $result_message = 'データベースに登録しました！XD';
  } else {
    $result_message = 'メッセージを入力してください...XO';
  }

  // メッセージの削除
  if (!empty($_POST['del'])) {
    $mysqli->query("delete from `messages` where `id` = {$_POST['del']}");
    $result_message = 'メッセージを削除しました;)';
  }
}

// データベースからレコード取得
$result = $mysqli->query('select * from `messages` order by `id` desc');
?>

<html>
<head>
  <meta charset="UTF-8">
</head>

<body>
  <p><?php echo $result_message; ?></p>
  <form action="" method="post">
    <input type="text" name="message" />
    <input type="submit" />
  </form>

  <?php foreach ($result as $row) : ?>
    <p>
      <form action="" method="post">
        <?php echo $row['body']; ?>
        <input type="hidden" name="del" value="<?php echo $row['id']; ?>" />
        <input type="submit" value="削除" />
      </form>
    </p>
  <?php endforeach; ?>
</body>
</html>
