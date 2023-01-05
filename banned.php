<?php

?><html lang="en">
  <head>
    <title>Banned</title>
	<?php
	chdir(__DIR__);
	echo '<!--';
	include_once('./public/header.php');
	echo '-->';
	include_once('./styles/inject.php');
	if (!(file_exists('./data/accounts/'.cleanFilename(getname()).'/ban.txt'))) {
		echo '<script>location.href="/";</script>';
	}
	?>
  </head>
  <body>
	<h2>You have been banned</h2>
	Here is the reason the administrator has given you:
	<blockquote><?php echo file_get_contents('./data/accounts/'.cleanFilename(getname()) . '/ban.txt'); ?></blockquote>
	  The administrator can lift the ban.
	  <section><?php 
	  if (file_exists('./extensions/forum-ban-appeal/index.php')) {
		  include_once('./extensions/forum-ban-appeal/index.php');
	  }
	  ?></section>
  </body>
</html>
