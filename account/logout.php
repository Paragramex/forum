<?php
if (isset($_POST['logout'])) {
	setcookie('login', false, time() + 72000, '/');
	setcookie('login', false, time() + 72000);
	unset($_COOKIE['login']);
}

?><html lang="en">
  <head>
	<base href="../" />
    <title>Logging Out...</title>
	<?php
	include('../public/header.php');
	include('../styles/inject.php');
	?>
  </head>
  <body>
	<?php
	ob_start();
if (isset($_POST['logout'])) {
	echo '<em>Please wait...</em>';
	echo '<p>Logged out!</p>';
	echo '<script>location.href="/";</script>';
} else {
	?><form action="account/logout.php" method="post">
		To help prevent <abbr title="Cross-site request forgery">CSRF</abbr>, please click the button below to send a POST request that will log you out.
		<br />
		<input type="submit" name="logout" value="Confirm log out" />
	</form><?php
}
	?>
	</body>
	</html>