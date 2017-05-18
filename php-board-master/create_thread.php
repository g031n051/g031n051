<?php /* スレッドを作成する */

if (strlen($_POST['uuid']) != 18) {
  header("Location: http://{$_SERVER['SERVER_ADDR']}:{$_SERVER['SERVER_PORT']}/board");
}

require_once 'base_class.php';

$database = BaseClass::connect_database();

$thread_id = $database->insert('threads', $_POST);

$error = $database->error();
if ($error[0] == '00000') {
  header("Location: http://{$_SERVER['SERVER_ADDR']}:{$_SERVER['SERVER_PORT']}/board/thread.php?id={$thread_id}");
} else {
  header("Location: http://{$_SERVER['SERVER_ADDR']}:{$_SERVER['SERVER_PORT']}/board");
}
