<?php

?><html lang="en">
  <head>
    <title>Manage Deletion</title>
	<?php
	include('./public/header.php');
	include('./styles/inject.php');
	?>
  </head>
  <body>
	  <h2>Manage Deletion</h2>
	  <p>Checking permissions...</p>
	  <p><?php 
		if (!isset($_GET['topic'], $_GET['post'])) {
			?>Double-check that you specified both a topic and post.</p><?php
			exit(0);
		}
		$topic = $_GET['topic'];
		$postName = $_GET['post'];
		$topicCleaned = cleanFilename($topic);
		$configaddr = __DIR__ . "/data/messages/$topicCleaned/config.json";
		if (!file_exists($configaddr)) die("Bad topic name.");
		$msgaddr = __DIR__ . "/data/messages/$topicCleaned/msg.json";
		$msgs = json_decode(file_get_contents($msgaddr));
		$config = json_decode(file_get_contents($configaddr));
		if (!isset($msgs->$postName)) die("Bad post name");
		$post = $msgs->$postName;
		if (!verifyAdmin() && $post->author !== getname()) die("Access denied");
		if (isset($_POST['go4post'])) {
			$delObj = new stdClass;
			$delObj->reason = $_POST['reason'] ?? "";
			$delObj->extendedReason = $_POST['extendedReason'] ?? "";
			$delObj->time = time();
			$delObj->user = getname();
			if (isset($post->del))  unset($post->del);
			else $post->del = $delObj;
			$msgs->$postName = $post;
			fwrite(fopen($msgaddr, 'w+'), json_encode($msgs));
		}
		?>
			  <h3>Current deletion status</h3>
	  <p>This post is currently <?php echo isset($post->del) ? "" : "not "; ?>deleted.</p>
	  <h3><?php echo isset($post->del) ? "Und" : "D"; ?>elete this post</h3>
	  <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
<?php 
if (!isset($post->del)) {
	?><label>Select deletion reason: <select name="reason"><?php deletionReasons(); ?></select></label><br />
	<label>Type more details: <input type="text" name="extendedReason" /></label>	  
<br /><?php
}
?>
		  <input name="go4post" type="submit" value="Confirm and <?php echo isset($post->del) ? "Und" : "D"; ?>elete this post" />
	  </form>
	  <p>Return to <a href="viewtopic.php?room=<?php echo htmlspecialchars(urlencode($_GET['topic'])); ?>#topic-message-<?php echo htmlspecialchars(urlencode($postName)); ?>">post</a>.</p>