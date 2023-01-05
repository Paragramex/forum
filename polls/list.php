<?php

?><html lang="en">
  <head>
    <title>List of Polls</title>
	<base href="../" />
	<?php
	include_once('../public/header.php');
	include_once('../styles/inject.php');
	require_once '../libraries/formfuncs.php';
	if (!file_exists(__DIR__ . '/polls.json')) {
		die("<h2>Invalid details.</h2><p>Poll file not found.");
	}
	?>
  </head>
  <body>
  <h2>Index of polls</h2>
	  <?php require 'header.php'; ?>
  <p>All the polls, indexed by user and creation date.</p>
  <table class="table exempt-from-format width-100" width="100%">
  <tr>
  <th>User</th><th>Poll</th></tr>
  <?php 
  function getPollList() {
	$polls = json_decode(file_get_contents(__DIR__ . '/polls.json'), true);
	$result = array();
	foreach ($polls as $user => $polls) {
		$result[$user] = array();
		foreach ($polls as $id => $poll) {
			$result[$user][$id] = $poll;
		}
	}
	return $result;
  }
  $polls = getPollList();

  foreach ($polls as $author => $polls) {
	  ?><tr><td rowspan="<?php echo count($polls);
	  ?>"><?php echo htmlspecialchars($author); 
	  ?></td><?php 
	  foreach ($polls as $id => $obj) {
		  ?><td><?php 
		  formatPollLink($id, $author, $obj['title']);
		  ?></td></tr><tr><?php
	  }
	  ?><td colspan="2">--end--</td></tr><?php
  }
  ?>
  </table>
