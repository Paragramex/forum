<?php

?><html lang="en">
  <head>
    <title>Post Reply</title>
	<?php
	include_once('./public/header.php');
	include_once('./styles/inject.php');
	if (!isset($_GET['room'])) die("Bad title");
	if (!isset($_COOKIE['login'])) die("Not logged in");
	if (!file_exists(__DIR__ . '/data/messages/' . cleanFilename($_GET['room']) . '/msg.json')) die("Bad title");
	?>
  </head>
  <body>
	<h2>Post a Reply</h2>
	  <b><a href="files">Click to upload a file</a></b>
	<div><?php
	if (!isset($_POST['submit'], $_POST['message'])) { ?>
	Write your reply below: <?php } 
	if (isset($_POST['submit'], $_POST['message'])) {
		if ($_POST['submit'] == 'Preview') { ?>
			Preview:<br /><?php 
			$Parsedown = new Parsedown;
			echo $Parsedown->text($_POST['message']); 
		}
		if ($_POST['submit'] == 'Submit') {
			require 'post_message_to_chat.php';
		}
	}
	?></div>
	<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
	<ul style="list-style:none;padding:0;"><input type="hidden" name="room" value="<?php echo htmlspecialchars($_GET['room']); ?>" />
		<li><label>Reply contents:<br /><textarea name="message" rows="20" style="width:100%;"><?php if (isset($_POST['contents'])) { echo htmlspecialchars($_POST['message']); } ?></textarea></label></li>
		<li><label>Reply to: <input type="text" name="reply" /></label></li>
		<li><label>Reply attachment (<a href="files/">upload</a>: <input type="text" name="attach" /></label></li>
		<li><input type="submit" name="submit" value="Preview" /> 
		<input type="submit" name="submit" value="Submit" style="font-weight:bold;" /></li>
	</ul>
	</form>