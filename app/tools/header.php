<?php

?><html lang="en">
  <head>
	<base href="../../" />
    <title>Forums &mdash; Tools</title>
	<?php
	include_once('../../styles/inject.php');
	include_once(__DIR__ . '/../../libraries/lib.php');
	if (isset($_COOKIE['login'])) {
		if (!verifyAdmin()) {
			echo 'You need to have admin permission. Try mailing one of these admins:<ul>';
			$config = json_decode(file_get_contents(__DIR__ . '/../../config.json'));
			foreach ($config->admins as $a) {
				?><li><?php echo htmlspecialchars($a); ?></li><?php
			}
			echo '</ul>';
			exit(0);
		}
	} else {
		echo 'This feature is not available to anonymous users.';
		exit(0);
	}
	?>
  </head>
  <body>
	<h1>Moderation Tools</h1>
	<small><small><em>Only admins may view this page.</em></small></small>
	<nav style="display:flex; flex-wrap:nowrap;overflow-x:scroll;justify-content:center;">
	<div style="margin:2px;"><a href="app/tools">Home</a></div>
	<div style="margin:2px;"><a href="app/tools/admins.php">Admins</a></div>
	<div style="margin:2px;"><a href="app/tools/users.php">Users</a></div>
	<div style="margin:2px;"><a href="app/tools/topics.php">Topics</a></div>
	<div style="margin:2px;"><a href="app/tools/files.php">Files</a></div>
	<div style="margin:2px;"><a href="app/tools/edit_tos.php">Edit TOS</a></div>
	<div style="margin:2px;"><a href="app/tools/banner.php">Banners</a></div>
		<div style="margin:2px;"><a href="app/tools/backup.php">Backup</a></div>
	<div style="margin:2px;"><a href="app/tools/ipban.php">IP bans</a></div>
	<div style="margin:2px;"><a href="app/tools/flags.php">Flags</a></div>
	<?php 
		if (file_exists(__DIR__ . '/../../extensions/nodb-forum-ban-appeal/index.php')) {
			echo '<div style="margin:2px;"><a href="app/tools/appeals.php">Appeals</a></div>';
		}
	?>
	<div style="margin:2px;"><a href="."><strong>Log Out</strong></a></div>
	</nav>