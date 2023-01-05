<?php

?><html lang="en">
  <head>
	<base href="../../" />
    <title>Articles</title>
	<?php
	include_once('../public/header.php');
	include_once('../styles/inject.php');
	?>
	Articles (<a href="articles/write.php">write</a>):
	<ul style="list-style:none;padding:0;">
	<?php 
	$files = scandir("./content");
	natcasesort($files);
	error_reporting(E_ALL);
	foreach ($files as $key => $dirs) {
		if (is_dir('./content/'.$dirs) && file_exists('./content/'.$dirs.'/config.json')) {
			?><li style="border-radius:3px;background-color:white;color:black;"><?php
			$config = json_decode(file_get_contents('./content/'.$dirs.'/config.json'));
			echo '<h2><a href="articles/read.php?title='.htmlspecialchars($config->title).'">'.htmlspecialchars($config->title).'</a></h2>Created ';
			echo friendlyDate($config->time);
			echo ' by ';
			echo htmlspecialchars($config->author);
			?></li><?php
		}
	}
	?>
	</ul>
	<a href="articles/about.php">About the articles</a>