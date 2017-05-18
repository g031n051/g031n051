<?php /* メッセージを投稿する */

if (strlen($_POST['uuid']) != 18) {
  header("Location: {$_SERVER['HTTP_REFERER']}");
}

require_once 'base_class.php';

$database = BaseClass::connect_database();

$database->insert('messages', $_POST);

header("Location: {$_SERVER['HTTP_REFERER']}");
