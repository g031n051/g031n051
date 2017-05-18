<html>
  <head>
    <title><?php print $controller->title ?></title>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link href="/board/css/board.css" rel="stylesheet">
  </head>

  <body class="container">
    <?php print $controller->body ?>
  </body>
</html>

<?php $uuid = uniqid('uuid_'); ?>
<script>
var uuid = localStorage.getItem('g231o021_board_uuid');
if (uuid == null) {
  localStorage.setItem('g231o021_board_uuid', '<?php echo $uuid ?>');
  uuid = localStorage.getItem('g231o021_board_uuid');
}

$('form').append(
  $('<input>')
    .attr('type', 'hidden')
    .attr('name', 'uuid')
    .attr('value', uuid)
);
</script>
