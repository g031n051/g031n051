$('#messages').height(window.innerHeight - ($('#thread_name').outerHeight(true) + $('#message-form').outerHeight(true) + 30));

function edit_mode(e) {
  var message_body = $(e.target).siblings('.message-body').text();
  $(e.target).siblings('form').prepend(`<input type="text" name="body" value="${message_body}" required />`);

  $(e.target).addClass('hidden');
  $(e.target).siblings('.message-body').addClass('hidden');
  $(e.target).siblings('form').removeClass('hidden');
}

function edit_message() {
  $('form').attr('action', '/board/edit_message.php');
}

function delete_message() {
  $('form').attr('action', '/board/delete_message.php');
}
