<?php

?><html lang="en">
  <head>
    <title>Edit Topic</title>
	<?php
	include('./public/header.php');
	include('./styles/inject.php');
	require './libraries/editlib.php';
	if (!isset($_GET['name'])) die("Specify room first");
	if (!getname()) die("Please log in to edit");
	if (!file_exists(__DIR__ . '/data/messages/'.cleanFilename($_GET['name']).'/config.json')) die("Bad title");
	$config = json_decode(file_get_contents(__DIR__ . '/data/messages/'.cleanFilename($_GET['name']).'/config.json'));
	if ((verifyAdmin() == false) && (getname() != $config->author)) die("access denied");
	?>
  </head>
  <body>
  <?php 
  	if (isset($_POST['body'])) {
		if ($config->description != $_POST['body']) {
			if (!isset($config->revisions)) {
				$config->revisions = array();
				$config->revisions[0] = new Revision($config->description, $config->author, $config->creationTime, "Original version");
			}

			array_push($config->revisions, new Revision($_POST['body'], getname(), time(), $_POST['summary']));

			$Parsedown = new Parsedown;
			$config->description_html = $Parsedown->text($_POST['body']);

			$config->description = $_POST['body'];

			fwrite(fopen(__DIR__ . '/data/messages/'.cleanFilename($_GET['name']).'/config.json', 'w+'), json_encode($config));
			?>Your edit has been saved. <a href="viewtopic.php?room=<?php echo htmlspecialchars(urlencode($_GET['name'])); ?>">Return to topic</a> <?php
		} else {
			?>You forgot to make changes!<hr /><?php
		}
	}
		?>
	<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
	<label>Edit topic:<br />
	<textarea name="body" rows="15" style="width:100%;"><?php echo htmlspecialchars($config->description); ?></textarea></label>
	<br />
	<label>Edit summary: <input required="required" type="text" name="summary" /></label>
	<br />
	<input type="submit" value="Save edits" />
	</form>
	