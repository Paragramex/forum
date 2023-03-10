<?php

?><html lang="en">
  <head>
    <title>View Poll</title>
	<base href="../" />
	<?php
	include_once('../public/header.php');
	include_once('../styles/inject.php');
	require_once '../libraries/formfuncs.php';
	?></head><body><?php
	if (!isset($_GET['user'], $_GET['id'])) die("<h2>Invalid details.</h2><p>Specify user and id.</p>");
	if (!file_exists(__DIR__ . '/polls.json')) {
		die("<h2>Invalid details.</h2><p>Poll file not found.");
	}
	$j = json_decode(file_get_contents(__DIR__ . '/polls.json'), true);
	$user = $_GET['user'];
	$id = $_GET['id'];
	$name = getname();
	if (!isset($j[$user][$id])) die("<h2>Bad id</h2><p>Invalid ID</p>");
	$j = $j[$user][$id];
	?><h2><?php echo htmlspecialchars($j['title']); ?></h2><?php require 'header.php'; 
	$Parsedown = new Parsedown;
	echo $Parsedown->text($j['description']);
	require '../libraries/bargraph.php';
	?>
	<ul>
		<li><?php echo count($j['questions']); ?> question(s)</li>
		<li><?php echo isset($j['responses']) ? count($j['responses']) : 0; ?> response(s)</li>
	</ul>
	<?php if (!isset($j['responses'][getname()])) { ?><a href="polls/viewpoll.php?user=<?php echo htmlspecialchars(urlencode($user)); ?>&id=<?php echo htmlspecialchars(urlencode($id)); ?>">Take this poll</a><?php } ?>
	<h3>Results</h3>
	<?php 
	if (!isset($j['responses'])) exit("There are no responses.");
	function record($j) {
		$res = array();
		foreach ($j['responses'] as $response) {
			foreach ($response as $question => $answer) {
				if (!isset($res[$question])) $res[$question] = array();
				array_push($res[$question], $answer);
			}
		}
		?><ol><?php
		foreach ($res as $question => $answers) {
			$responses = array();
			?><li><?php 
			$Parsedown = new Parsedown;
			echo $Parsedown->text($j['questions'][$question]['description']);
			echo count($answers); ?> answer(s)
			<br />Breakdown:
			<?php 
				barGraph("Responses", array_count_values($answers));
			?></li><?php
		}
		?></ol><?php
	}
	record($j);