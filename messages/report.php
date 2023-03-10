<?php

?><html lang="en">
  <head>
    <title>Report Message</title>
	<base href="../" />
	<?php
	include_once('../public/header.php');
	include_once('../styles/inject.php');
	if (!isset($_GET['id'])) die("Bad ID");
	if (!isset($_COOKIE['login'])) die("Bad login");
	?>
  </head>
  <body>
	<?php
	if (!file_exists(__DIR__ . '/../data/accounts/' . cleanFilename(getname()) . '/msg.json')) die("You do not have any messages.");
	$m = json_decode(file_get_contents(__DIR__ . '/../data/accounts/' . cleanFilename(getname()) . '/msg.json'));
	$id = $_GET['id'];
	if (!isset($m->$id)) die("Bad ID");
	$s = $m->$id;
	if (!in_array(getname(), $s->people)) die("Access is denied as the message was not sent to you.");
	?>
	<p>&larr; Return to <a href="messages/">Messages Home</a> | <a href="messages/viewmsg.php?id=<?php echo htmlspecialchars($id); ?>">Offending message</a></p>
	<h2><?php echo htmlspecialchars($s->subject); ?> - Report message</h2>
	<p>Is this message spam, offensive, or a violation of the <a href="tos.php">Terms of Service</a>? Please fill in details below, and a volunteer (who will not be the sender) will take a look at it.</p>
	  <p><strong>Note: Reporting a message will permanently reveal ALL of the headers -- the sender, receiver, and sending time. However, the author will not see that the message has been reported.</strong></p>
	  <p>Please be descriptive in your reports.
	  This is how NOT to write a report: <blockquote>This message is bad.</blockquote> This is an example of a good report: <blockquote>This message only serves to promote the link enclosed - it is written like an advertisement and has no intention to actually communicate, only advertise.</blockquote>
	  </p>
	  <?php
if (isset($_POST['reason'])) {
	?><p>Received data -- reporting now...</p><?php
	if (!file_exists('reports.json')) {
		?><p>Report list does not exist -- creating...</p><?php
		fwrite(fopen('reports.json', 'w+'), "{\"reports\":[]}");
		?><p>Report list created -- adding this message...</p><?php
	} else {
		?><p>Report list exists -- adding to list...</p><?php
	}
	$contents = json_decode(file_get_contents("reports.json"));
	?><p>Message content starts with "<i><?php echo htmlspecialchars(substr($s->body, 0, 30)); ?></i>".</p><?php
	?><p>Reason given starts with "<i><?php echo htmlspecialchars(substr($_POST['reason'], 0, 30)); ?></i>"</p><?php
	$report = new stdClass;
	$report->body = $s->body;
	$report->time = $s->time;
	$report->from = $s->from;
	$report->reason = $_POST['reason'];
	$report->to = $s->people;
	$report->id = $_GET['id'];
	?><p>Finished gathering required information</p><?php 
	array_push($contents->reports, $report);
	fwrite(fopen('reports.json', 'w+'), json_encode($contents));
	?><p><b>Reporting complete, please leave this page.</b></p><?php 
	exit(0);
}
	?>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
	<p>I think this message is inappropriate because...<br />
	<label><span hidden="hidden">Enter reason here</span><textarea required="required" name="reason" rows="5" cols="50" placeholder="Insert your reason here. Common reasons: Inaccurate warning, spam, offensive, gibberish"></textarea></label>
	</p>
	<button type="submit">Report this message</button>
</form>