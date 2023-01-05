<?php

?><html>
  <head>
	<base href="../../" />
	<?php 
	include('../public/header.php');
	include('../styles/inject.php');
	if (!isset($_GET['title'])) die("Specify title first");
	?>
    <title>Article: <?php echo htmlspecialchars($_GET['title']); ?></title>
	</head>
	<body>
		<?php if (!file_exists('./content/'.cleanFilename($_GET['title']).'/config.json')) die("Bad title"); ?>
		<h2><?php 
		$config = json_decode(file_get_contents('./content/'.cleanFilename($_GET['title']).'/config.json'));
		echo htmlspecialchars($_GET['title']); ?></h2>
		<?php 
		$Parsedown = new Parsedown;
		echo $Parsedown->text($config->text);
		?>
		<table width="100%">
		<tr>
		<td align="right">
		Created <?php echo date('Y-m-d H:i:s', $config->time); ?><br /><?php echo htmlspecialchars($config->author); ?></td></tr></table>
		<?php include('../public/footer.php'); ?>