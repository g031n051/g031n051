<?php /* スレッドを削除する */

if (strlen($_POST['uuid']) != 18) {
  header("Location: http://{$_SERVER['SERVER_ADDR']}:{$_SERVER['SERVER_PORT']}/board");
}

require_once 'base_class.php';

$database = BaseClass::connect_database();

$database->delete('messages', array('thread_id' => intval($_POST['id'])));

$database->delete('threads', array('AND' => array(
  'id'   => intval($_POST['id']),
  'uuid' => $_POST['uuid']
)));

header("Location: http://{$_SERVER['SERVER_ADDR']}:{$_SERVER['SERVER_PORT']}/board");
