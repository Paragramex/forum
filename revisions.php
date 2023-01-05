<?php

?><html lang="en">
  <head>
    <title>Topic Revisions</title>
	<?php
	include('./public/header.php');
	include('./styles/inject.php');
require 'libraries/diff.php';
	if (!isset($_GET['topic'])) die("Specify room first");
	if (!file_exists(__DIR__ . '/data/messages/'.cleanFilename($_GET['topic']).'/config.json')) die("Bad title");
	$config = json_decode(file_get_contents(__DIR__ . '/data/messages/'.cleanFilename($_GET['topic']).'/config.json'));
	$postcontent = json_decode(file_get_contents(__DIR__ . '/data/messages/'.cleanFilename($_GET['topic']).'/msg.json'));
if (isset($_GET['post']) && isset($postcontent->{$_GET['post']})) $config = $postcontent->{$_GET['post']};
	?>  </head>
  <body>
  <h2>Revisions</h2>
  <a href="viewtopic.php?room=<?php echo htmlspecialchars(urlencode($_GET['topic'])); ?>">Return to topic</a>
  <?php 
  if (!isset($config->revisions)) {
	  ?><details><summary>1. <strong>Original version</strong> by <a href="account/viewuser.php?user=<?php echo htmlspecialchars(urlencode($config->author)); ?>"><?php echo htmlspecialchars($config->author); ?></a> on <?php echo date("Y-m-d H:i:s", isset($config->creationTime) ? $config->creationTime : $config->time); ?></summary><?php echo isset($config->description_html) ? $config->description_html : $config->html; ?><details><summary>Source</summary><pre><code class="lang-markdown"><?php echo htmlspecialchars(isset($config->description) ? $config->description : $config->md); ?></code></pre></details></details><?php
  } else {
	$revs = array_reverse($config->revisions);

	  ?>
	  	<details><summary>Compare revisions</summary>
	<form action="comparerevs.php" method="post">
	<label>
	Select base revision:
	<?php 
	function revSelectBox(string $name, $revs) {
		?><select name="<?php echo $name; ?>"><?php
		$revcount = count($revs);
		foreach ($revs as $index => $revision) {
			?><option value="<?php echo htmlspecialchars(json_encode($revision->text)); ?>"><?php echo $revcount - $index; ?>. <?php echo htmlspecialchars($revision->summary); ?></option><?php
		}
		?></select><?php
	}
	revSelectBox('old', $revs);
	?>
	</label><br />
	<label>
	Select revision after change:
	<?php 
	revSelectBox('new', $revs); ?>
	</label><br />
	<input type="submit" value="Compare selected revisions" />
	</form></details>
	<hr />
	<?php

	  foreach ($revs as $index => $revision) {
		  ?><details><summary><?php echo count($revs) - $index; ?>. <strong><?php echo htmlspecialchars($revision->summary); ?></strong> by <a href="account/viewuser.php?user=<?php echo htmlspecialchars(urlencode($revision->author)); ?>"><?php echo htmlspecialchars($revision->author); ?></a> on <?php echo date("Y-m-d H:i:s", $revision->time); ?></summary><?php echo $revision->html; ?><details><summary>Source</summary><pre><code class="lang-markdown"><?php echo htmlspecialchars($revision->text); ?></code></pre></details>
		  <?php if (isset($revs[$index + 1])) { ?><details>
			  <summary>Diff</summary>
			  <?php 
				  $pre = $revs[$index+1];
				  diff($pre->text, $revision->text);
			  ?>
		  </details>
		  <?php } ?></details><?php
	  }
  }
  ?>
  <p class="smaller">
  Tip:
  <span><?php 
  $items = array(
	  "To see how a page has developed over time, select two far-apart revisions under Compare Revisions.",
	  "The source for each revision is available. Expand the revision and click Source.",
	  "To see what changed in a revision, open the revision and open Diff.",
	  "<a href=\"#\">Click here</a> or use the <kbd>Home</kbd> key to return to the top of the page.",
	  "Browsing a long list? You can use your browser's Find on Page feature to search edit summaries, users, and times. Try pressing <kbd>Ctrl</kbd> + <kbd>F</kbd>"
  );
  shuffle($items);
  echo $items[array_rand($items)];
  ?></span>
  </p>
  <script>hljs.highlightAll();</script>