<?php

?><html>
  <head>
	<base href=".." />
    <title>Add an Event</title>
	<?php
	include('../public/header.php');
	include('../styles/inject.php');
	?>
  </head>
  <body>
  <?php 
  if (!isset($_COOKIE['login'])) die("Log in to add events");
  if (isset($_POST['submit'])) {
	$config = json_decode(file_get_contents(__DIR__."/../data/community/events/config.json"));

	$title = $_POST['title'];
	$handle = fopen(__DIR__."/../data/community/events/config.json", 'w+');
	echo 'Creating... ';
	$t = strtotime($_POST['time']);
	$date = date("m/d/Y", $t);
	$name = getname() . "|" . time();
	$config->$date->$name = json_decode("{}");
	$config->$date->$name->title = $_POST['title'];
	$config->$date->$name->url = $_POST['url'];
	$config->$date->$name->time = strtotime($_POST['time']);
	$config->$date->$name->author = getname();
	if (fwrite($handle, json_encode($config))) {
	echo "Added!";
	} else {
		echo 'Could not add';
	}
  } else {
	  ?>Only add event items as actual events.<?php
  }
  ?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <label>Title:<br />
  <input type="text" value="<?php if (isset($_POST['title'])) { echo htmlspecialchars($_POST['title']); } ?>" name="title" oninput="document.getElementById('titleleft').innerHTML=150-this.value.length;" maxlength="150" required="required" /></label>
  <div>You can enter <span id="titleleft">150</span> more characters in the title.</div>
  <label>Clickthrough URL:<br /><input type="url" name="url" required="required"value="<?php if (isset($_POST['url'])) { echo htmlspecialchars($_POST['url']); } ?>" /></label>
  <br />
  <label>Time: <input name="time" type="datetime-local" value="<?php if (isset($_POST['time'])) { echo htmlspecialchars($_POST['time']); } ?>" required="required" /></label>
  <br />
  <input type="submit" value="Add item" name="submit" />
  </label>
  </form>