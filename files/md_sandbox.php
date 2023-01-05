<?php

?><html>
  <head>
	<base href="../" />
    <title>Markdown Rendering Sandbox</title>
	<?php
	include('../public/header.php');
	include('../styles/inject.php');
	?>
  </head>
  <body>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <label>Enter the text to render:<br />
  <textarea rows="5" cols="50" name="text"><?php if (isset($_POST['text'])) { if (isset($_POST['clear'])) { echo ''; } else { echo htmlspecialchars($_POST['text']); } } if (isset($_POST['recover'])) { echo htmlspecialchars($_POST['oldtext']); } ?></textarea></label>
  <br />
  <label><input type="checkbox" name="inline" <?php if (isset($_POST['inline'])) { ?>checked="checked" <?php } ?>/> Inline mode (disables all features except Bold, Italic, Code, HTML, and links)</label>
  <br />
  <input type="submit" name="clear" value="<< Clear" />
  <?php if (isset($_POST['clear'])) {
	  ?>
	  <label hidden="hidden">DO NOT TOUCH THIS FIELD!
	  <textarea name="oldtext"><?php echo htmlspecialchars($_POST['text']); ?></textarea></label>
	  <input type="submit" name="recover" value="Recover" /><?php
  }
  ?>
  <input type="submit" value="Convert >>" />
  </form>
  <h2>Converted Text</h2>
  <div id="converted">
  <?php 
  if (!isset($_POST['text'])) {
	  ?><span style="color:red;">Nothing to convert.</span> </div><?php  
  } else {
	  require_once '../libraries/parsedown.php';
	  $Parsedown = new Parsedown;
	  $t = $Parsedown->text($_POST['text']);
	  if (isset($_POST['inline'])) $t = $Parsedown->line($_POST['text']);
	  echo $t;
	  ?>   </div><h2>HTML</h2>
		<p>If you like to see what's there before your browser makes it pretty.</p>
		<pre><code class="lang-html"><?php
		echo htmlspecialchars($t); ?></code></pre><?php
  }
  ?>
  <style>#converted { border: 1px solid; padding: 3px; }</style>