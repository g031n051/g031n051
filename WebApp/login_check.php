<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//クロスサイトリクエストフォージェリ（CSRF）対策のトークン判定
if ($_POST['token'] != $_SESSION['token']){
  echo "不正アクセスの可能性あり";
  exit();
}

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//データベース接続
require_once("db.php");
$dbh = db_connect();

//前後にある半角全角スペースを削除する関数
function spaceTrim ($str) {
  // 行頭
  $str = preg_replace('/^[ 　]+/u', '', $str);
  // 末尾
  $str = preg_replace('/[ 　]+$/u', '', $str);
  return $str;
}

//エラーメッセージの初期化
$errors = array();

if(empty($_POST)) {
  header("Location: login_form.php");
  exit();
}else{
  //POSTされたデータを各変数に入れる
  $account = isset($_POST['account']) ? $_POST['account'] : NULL;
  $password = isset($_POST['password']) ? $_POST['password'] : NULL;

  //前後にある半角全角スペースを削除
  $account = spaceTrim($account);
  $password = spaceTrim($password);

  //アカウント入力判定
  if ($account == ''):
    $errors['account'] = "アカウントが入力されていません。";
    endif;

    //パスワード入力判定
    if ($password == ''):
      $errors['password'] = "パスワードが入力されていません。";
      endif;

    }

    //エラーが無ければ実行する
    if(count($errors) === 0){
      try{
        //例外処理を投げる（スロー）ようにする
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //アカウントで検索
        $statement = $dbh->prepare("SELECT * FROM account WHERE account=(:account) AND flag =1");
        $statement->bindValue(':account', $account, PDO::PARAM_STR);
        $statement->execute();

        //アカウントが一致
        if($row = $statement->fetch()){

          $password_hash = $row[password];

          //パスワードが一致
          if (password_verify($password, $password_hash)) {

            //セッションハイジャック対策
            session_regenerate_id(true);

            $_SESSION['account'] = $account;
            header("Location: MainMenu.php");
            exit();
          }else{
            $errors['password'] = "アカウント及びパスワードが一致しません。";
          }
        }else{
          $errors['account'] = "アカウント及びパスワードが一致しません。";
        }

        //データベース接続切断
        $dbh = null;

      }catch (PDOException $e){
        print('Error:'.$e->getMessage());
        die();
      }
    }

    ?>

    <!DOCTYPE html>
    <html>
    <head>
      <title>ログイン確認</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="http://153.126.145.101/liquid/css/bootstrap.min.css">
    </head>

    <body>
      <div class="container"><br>
        <?php
        echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボGO"/>';
        echo '<img src="http://153.126.145.101/WebApp/get_img.php?name=ツボツボ"/>';
        ?><br><br>

        <?php if(count($errors) > 0): ?>

          <?php
          foreach($errors as $value){
            echo "<p>".$value."</p>";
          }
          ?>

          <form action="login_form.php" method="post">
            <input type="submit" value="戻る" class="btn btn-primary" onclick="check()" />
          </form>

        <?php endif; ?>

      </div>
    </body>
    </html>
