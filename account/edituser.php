<?php

?><html lang="en">
  <head>
    <base href=".." />
    <title>Edit My Account</title>
	<?php
	include_once('../public/header.php');
	include_once('../styles/inject.php');
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	?>
  </head>
  <body>
	<?php 
		$dir = __DIR__ . '/../data/accounts/'.cleanFilename(getname());
		$obj = json_decode(file_get_contents($dir.'/user.json'));
		if (isset($_POST['text'])) {
			$obj = (object) $_POST;
			$enc = json_encode($obj);
			$dir = fopen($dir.'/user.json', 'w+');
			if (fwrite($dir, $enc)) {
				echo 'Profile saved, <a href="account/viewuser.php?user='.htmlspecialchars(urlencode(getname())).'">view it now?</a>';
			} else {
				echo 'Cannot save profile';
			}
		} else {
			echo 'Edit your profile:';
		}
	?>
	<hr />
	<?php if (!isset($_COOKIE['login'])) die("Log in to edit your profile"); ?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<label>About me:<br /><textarea name="text" rows="10" style="width:100%;" placeholder="Write about me."><?php if (isset($obj->text)) { echo htmlspecialchars($obj->text); } ?></textarea></label>
	<br /><br />
	<label>GitHub link: <br /><span style="cursor:text;background-color:white;color:black;border:1px solid;padding:7px;max-width:100%;">https://github.com/<input value="<?php if (isset($obj->github)) { echo htmlspecialchars($obj->github); } ?>" type="text" name="github" style="outline:none;margin:none;border:0px solid;padding:0px;" /></span></label>
	<br /><br />
	<label>Personal site: <input value="<?php if (isset($obj->text)) { echo htmlspecialchars($obj->site); } ?>" type="url" name="site" /></label>
	<br />
	<p><strong>Note:</strong> All of these fields are optional. If you fill them out, they will be displayed when your profile is viewed.</p>
	<br />
	<input type="submit" value="Save profile" />
	</form>