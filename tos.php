<?php
?><html>
  <head>
    <title>Forums &mdash; TOS</title>
	<?php
	include('./public/header.php');
	include('./styles/inject.php');
	?>
  </head>
  <body>
  <p style="background-color:red;">This is an official policy.</p>
  <?php include('tos_raw.php'); 
  // Check if TOS Edit plugin is installed
  if (file_exists('./extensions/nodb-forum-tos-edit/index.php')) {
	  include './extensions/nodb-forum-tos-edit/index.php';
  }
  ?>
  <?php
  include('public/footer.php'); ?></body></html>