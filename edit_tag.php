<?php

?><html>
  <head>
	<?php
	include('./public/header.php');
	include('./styles/inject.php');
	
	if (!isset($_GET['tag'])) die("No tag specified");
	if (!isset($_COOKIE['login'])) die("Log in to edit tags"); ?>
    <title>Forums &mdash; Edit Tag "<?php echo htmlspecialchars($_GET['tag']); ?>"</title>
	</head>
	<body>
	<?php 
		$tagName = $_GET['tag'];
		$config = json_decode(file_get_contents('config.json')); 
		if (isset($_POST['sender'])) {
			echo 'Saving...';
			if (!isset($config->descriptions->$tagName))
				$config->descriptions->$tagName = new stdClass;
			$config->descriptions->$tagName->short = $_POST['short'];
			$config->descriptions->$tagName->long = $_POST['long'];
			$handle = fopen('config.json', 'w+');
			fwrite($handle, json_encode($config));
		}
	?>
	<h2>Editing tag: <span class="tag"><?php 
	echo htmlspecialchars($tagName); 
	?></span></h2>
	<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
	<label>Short tag description (no Markdown, 500 character max):
	<textarea maxlength="500" name="short" rows="9" style="width: 100%;"><?php if (isset($config->descriptions->$tagName->short)) {
		echo htmlspecialchars($config->descriptions->$tagName->short);
	} ?></textarea>
	</label>
	<label>Tag description:
	<textarea name="long" rows="20" style="width:100%;"><?php if (isset($config->descriptions->$tagName->long)) {
		echo htmlspecialchars($config->descriptions->$tagName->long);
	} ?></textarea>
	</label>
	<hr />
	<input type="submit" name="sender" value="Save" />