<?php /* スレッド一覧を表示するページ */
require_once 'base_class.php';

class ThreadsController extends BaseClass {
  function __construct() {
    $this->title = 'スレッド一覧';

    parent::__construct();
  } /* end of __construct */

  function generate_html() {
    $this->body .= "<h1>{$this->title}</h1>";
    $this->body .= $this->generate_form();
    $this->body .= $this->generate_thread_list();
    $this->body .= '<script src="/board/js/threads.js"></script>';
  } /* end of generate_html */

  private function generate_form() {
    $retval = '';

    $retval .= '<form action="/board/create_thread.php" method="post" class="form-inline">';
    $retval .= '<input type="text" name="name" placeholder="スレッド名を入力" class="form-control col-md-10" required />';
    $retval .= '<input type="submit" value="スレッドを作成" class="btn btn-primary btn-sm" />';
    $retval .= '</form>';

    return $retval;
  } /* end of generate_form */

  private function generate_thread_list() {
    $retval = '';

    $retval .= '<table class="table table-striped table-hover">';
    $retval .= '<thead><tr><th>スレッド名</th><th>作成日時</th><th>削除</th></tr></thead>';
    $retval .= '<tbody>';
    foreach ($this->obtain_threads() as $thread) {
      $retval .= "<tr data-href=\"/board/thread.php?id={$thread['id']}\">";

      $retval .= '<td>';
      $retval .= htmlspecialchars($thread['name']);
      $retval .= '</td>';

      $retval .= "<td>{$thread['created_at']}</td>";

      $retval .= '<td>';
      $retval .= '<form action="/board/delete_thread.php" method="post">';
      $retval .= '<input type="submit" value="スレッドを削除する" class="btn btn-danger btn-sm" />';
      $retval .= "<input type=\"hidden\" name=\"id\" value=\"{$thread['id']}\" />";
      $retval .= '</form>';
      $retval .= '</td>';

      $retval .= '</tr>';
    }
    $retval .= '</tbody>';
    $retval .= '</table>';

    return $retval;
  } /* end of generate_thread_list */

  private function obtain_threads() {
    return $this->database->select('threads', '*', array('ORDER' => array('id' => 'DESC')));
  } /* end of obtain_threads */
} /* end of ThreadsController */

$controller = new ThreadsController();
$controller->generate_html();

include 'layout.php';
