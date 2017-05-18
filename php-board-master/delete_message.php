<?php /* メッセージを削除する */

if (strlen($_POST['uuid']) != 18) {
  header("Location: {$_SERVER['HTTP_REFERER']}");
}

require_once 'base_class.php';

$database = BaseClass::connect_database();

$database->delete('messages', array('AND' => array(
  'id'   => intval($_POST['id']),
  'uuid' => $_POST['uuid']
)));

header("Location: {$_SERVER['HTTP_REFERER']}");
