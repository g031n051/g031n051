<?php echo $_POST['password']; ?>

<html>
<head>
  <title> コメント編集フォーム</title>
  <meta charset="UTF-8">
</head>

<body>
  <table class="table" border=1>
    <tr><th>名前</th><th>コメント</th><th>編集</th>

      <tr>
        <form action="bbs.php" method="post">
          <input type="hidden" name="upd" value="<?php echo $_POST['upd']; ?>" />
        <td><input type="text" name="upd_name" value="<?php echo $_POST['name']; ?>" /></td>
        <td><input type="text" name="upd_body" value="<?php echo $_POST['body']; ?>" /></td>
        <td><input type="submit" value="編集" /></td>
      </form>
      </tr>
  </table>
</body>
</html>
