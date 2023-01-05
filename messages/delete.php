<?php

?><html lang="en">
  <head>
    <title>Delete Message</title>
	<base href="../" />
	<?php
	include_once('../public/header.php');
	include_once('../styles/inject.php');
	?>
  </head>
  <body>
	<?php
	$userid = getname() ? getname() : null;
	$message = isset($_GET['id']) ? $_GET['id'] : null;
	$file = json_decode(file_get_contents('../data/accounts/' . cleanFilename($userid) . '/msg.json'));
if (!isset($file->$message)) {
	?><h2>Error:</h2><p>Your message could not be found.</p><?php
	exit(0);
}
if (isset($_POST['delete'])) {
	unset($file->$message);
	fwrite(fopen('../data/accounts/' . cleanFilename($userid) . '/msg.json', 'w+'), json_encode($file));
	?><h2>Message deleted</h2><p>Please <a href="messages/">return to your inbox</a> to continue using Private Messages.</p><?php
	exit(0);
}
?><h2>Confirm Delete</h2>
	  <p>You will permanently lose your copy of this message. Other people may still have a copy.</p>
<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
	<label>Confirm delete:
		<input type="submit" name="delete" /></label>
</form>