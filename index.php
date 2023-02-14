<?php
?><html lang="en">
  <head>
    <title><?php 
		if (file_exists(__DIR__ . '/config.json')) {
			$name = json_decode(file_get_contents(__DIR__ . '/config.json'));
			echo htmlspecialchars($name->forumtitle);
		}
	?></title>
	<?php
	include_once('./public/header.php');
	include_once('./styles/inject.php');
	?>
  </head>
  <body>
    <h2><?php 
	$login = isset($_COOKIE['login']) ? $_COOKIE['login'] : "";
	if ($login != "") {
		echo "Welcome, ".htmlspecialchars(getname()).'!</h2> We&apos;re glad to have you. Choose a room to join. Or, <a href="create.php" class="fakebutton"> create a room? </a>';
	} else {
		echo "You are not logged in.</h2> You will not be able to post any messages, upload files, or communicate with others, although you will be able to view public content.";
	}
	include_once('./libraries/listroom.php');
	include_once('./public/footer.php');
	?>
  </body>
</html>