<?php

?><html lang="en">
  <head>
	<?php
	include_once('./public/header.php');
	include_once('./styles/inject.php');
	$Parsedown = new Parsedown;
	
	if (!isset($_GET['tag'])) die("No tag specified"); ?>
    <title>Topics Tagged "<?php echo htmlspecialchars($_GET['tag']); ?>"</title>
  </head>
  <body>
	<h2>Showing: Topics Tagged <span class="tag"><?php echo htmlspecialchars($_GET['tag']); ?></span> (<a href="tags.php">all tags</a>)</h2>
	<h3>About This Tag</h3>
	<a href="edit_tag.php?tag=<?php echo htmlspecialchars($_GET['tag']); ?>"><em><small>improve tag info</small></em></a>
	<div>
		<h4>Short description</h4>
		<div style="border:1px solid; padding:3px;white-space:pre-wrap;"><?php 
		$tagName = $_GET['tag'];
		$config = json_decode(file_get_contents('config.json'));
		if (isset($config->descriptions->$tagName)) {
			echo htmlspecialchars($config->descriptions->$tagName->short);
			?></div><hr /><details><summary>More information</summary><div style="border:1px solid;padding:3px;"><?php
			echo $Parsedown->text($config->descriptions->$tagName->long);
			echo '</div></details>';
			?><script>hljs.highlightAll();</script><?php
		} else {
			?> No info yet. Let's <a href="edit_tag.php?tag=<?php echo htmlspecialchars($tagName); ?>">create it!</a><?php
		}
		?>
	</div>
	<ul style="list-style:none;padding:0;">
		<?php 
			$all = scan_dir("./data/messages");
			$names = array();
			foreach ($all as $key => $value) {
				if (!file_exists('./data/messages/'.$value.'/config.json')) continue;
				$config = json_decode(file_get_contents('./data/messages/'.$value.'/config.json'));
				$del = file_exists('./data/messages/'.$value.'/del.json');
				if ($del) {
					if (!verifyAdmin()) {
						if ($config->author !== getname()) {
							continue;
						}
					}
				}
				$tags = $config->tags;
				$tags = explode(" ", $tags);
				if (in_array($_GET['tag'], $tags)) {
					?>
					<li style="background-color:white;color:black;<?php 
						if ($del) {
							?>background-color:#ffdddd;<?php
						}
					?>border-radius:3px;"><h3><a href="viewtopic.php?room=<?php echo htmlspecialchars($config->title); ?>"><?php echo htmlspecialchars($config->title); ?></a></h3>
					Tagged <?php 
						foreach ($tags as $tag) {
							?><span class="tag"<?php 
							if ($tag == $_GET['tag']){echo ' style="font-weight:bold;"';} ?>><a href="tagged.php?tag=<?php echo htmlspecialchars($tag); ?>"><?php echo htmlspecialchars($tag); ?></a></span> <?php
							array_push($names, 'a');
						}
					?>
					 <br /><br />Created <?php
							echo date('Y-m-d H:i:s', $config->creationTime); ?> by <?php
							echo htmlspecialchars($config->author); ?>.
					</li><?php
				}
			}
			if ($names == array()) {
				?>There are no topics tagged <span class="tag"><?php echo htmlspecialchars($_GET['tag']); ?></span>. <a href="tags.php">Click to view all tags</a><?php
			}
		?>
	</ul>
	<?php include_once('./public/footer.php'); ?>