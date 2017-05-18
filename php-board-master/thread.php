<?php /* スレッドでのやり取りを表示し，メッセージの投稿ができるページ */
require_once 'base_class.php';

class ThreadController extends BaseClass {
  private $messages = array();

  function __construct() {
    parent::__construct();

    $thread      = $this->obtain_thread();
    $this->title = $thread['name'];

    $this->messages = $this->obtain_messages();
  } /* end of __construct */

  function generate_html() {
    $this->body .= '<h1 id="thread_name">';
    $this->body .= htmlspecialchars($this->title);
    $this->body .= '</h1>';

    $this->body .= '<a href="/board" class="btn btn-link">戻る</a>';
    $this->body .= $this->generate_message_list();
    $this->body .= $this->generate_form();
    $this->body .= '<script src="/board/js/thread.js"></script>';
  } /* end of generate_html */

  private function generate_message_list() {
    $retval = '';

    $retval .= '<div id="messages">';
    foreach ($this->messages as $message) {
      $retval .= '<div class="message">';

      $retval .= "{$message['name']} - {$message['created_at']}<br />";

      $retval .= '<span class="message-body">';
      $retval .= htmlspecialchars($message['body']);
      $retval .= '</span>';

      $retval .= '<button class="btn btn-link btn-sm" onclick="edit_mode(arguments[0]);">編集する</button>';

      $retval .= '<form action="" method="post" class="form-inline hidden">';
      $retval .= '<input type="submit" value="編集する" class="btn btn-link btn-sm" onclick="edit_message();"   />';
      $retval .= '<input type="submit" value="削除する" class="btn btn-danger btn-sm" onclick="delete_message();" />';
      $retval .= "<input type=\"hidden\" name=\"id\" value=\"{$message['id']}\" />";
      $retval .= '</form>';

      $retval .= '</div>';
    }
    $retval .= '</div>';

    return $retval;
  } /* end of generate_message_list */

  private function generate_form() {
    $retval = '';

    $retval .= '<form action="/board/post_message.php" method="post" class="form-inline" id="message-form">';
    $retval .= '<input type="text" name="name" placeholder="ハンドルネームを入力" class="form-control col-md-2" required />';
    $retval .= '<input type="text" name="body" placeholder="メッセージを入力" class="form-control col-md-8" required />';
    $retval .= "<input type=\"hidden\" name=\"thread_id\" value=\"{$_GET['id']}\" />";
    $retval .= '<input type="submit" value="メッセージを投稿" class="btn btn-primary btn-sm" />';
    $retval .= '</form>';

    return $retval;
  } /* end of generate_form */

  private function obtain_thread() {
    return $this->database->get('threads', '*', array('id' => intval($_GET['id'])));
  } /* end of obtain_thread */

  private function obtain_messages() {
    return $this->database->select('messages', '*', array(
      'thread_id' => intval($_GET['id']),
      'ORDER'     => array('id' => 'DESC')
    ));
  }
} /* end of ThreadController */

$controller = new ThreadController();
$controller->generate_html();

include 'layout.php';
