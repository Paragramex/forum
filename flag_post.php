<?php

?><html lang="en">
  <head>
	<?php
	include_once('./public/header.php');
	include_once('./styles/inject.php');
	?>
    <title>Flag a Post</title>
  </head>
  <body>
	<?php if (!isset($_GET['room'])) die("no room specified"); 
	if (!isset($_GET['post'])) die("Specify post name");

	$post = $_GET['post'];
	if (!getname()) die("log in to flag");
	if (!file_exists(__DIR__ . '/data/messages/'.cleanFilename($_GET['room']).'/config.json')) die("Bad title");
	$config = json_decode(file_get_contents(__DIR__ . '/data/messages/' . cleanFilename($_GET['room']) . '/config.json'));
	$msgs = json_decode(file_get_contents(__DIR__ . '/data/messages/' . cleanFilename($_GET['room']) . '/msg.json'));
	if (!isset($msgs->$post)) die("Bad post name");
	$name = getname();
	class Flagged extends emptyClass {
		public $reason = '';
	}
	if (isset($_POST['flag'])) {
		$flag = new Flagged;
		$flag->reason = $_POST['flag'];
		if (isset($_POST['input']) && $_POST['flag'] == 'Other') $flag->modText = $_POST['input'];
		if ($_POST['flag'] == 'Junk') $flag->junkreason = $_POST['junk'];

		$msgs = json_decode(file_get_contents(__DIR__ . '/data/messages/' . cleanFilename($_GET['room']) . '/msg.json'));
		$name = getname();
		$msgs->$post->flags->$name = $flag;
		fwrite(fopen(__DIR__ . '/data/messages/'.cleanFilename($_GET['room']).'/msg.json', 'w+'), json_encode($msgs));
	}
	?>
	<h2>Why is this post inappropriate?</h2>
	<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
	<fieldset<?php if (isset($msgs->$post->flags->$name)) echo ' disabled="disabled"'; ?>><legend>Flag reasons</legend>
		<ul style="list-style:none;">
		<li><label><input required="required" type="radio" name="flag" value="Spam" /><strong>Spam:</strong> Advertisement without disclosing affiliation</label></li>
		<li><label><input required="required" type="radio" name="flag" value="Junk" /><strong>Junk:</strong> Adds nothing to the conversation.</label><br /><label>What best describes this post?
			<select name="junk">
				<option value="me too">"same problem, did you figure it out?"</option>
				<option value="thanks">"+1, great!"</option>
				<option value="non constructive criticism">"-1, I hate you!"</option>
				<option value="linkonly">"The answer is here: LINK"</option>
				<option value="another question">"So how do I solve &lt;another question here>?"</option>
				<option disabled="disabled">Something else? Use "Other"!</option>
			</select>
		</label></li>
		<li><label><input required="required" type="radio" name="flag" value="Offensive" /><strong>Offensive:</strong> Offensive content.</label></li>
		<li><label><input required="required" type="radio" name="flag" value="Gibberish" /><strong>Gibberish:</strong> <code>asdfasdf</code></label></li>
		<li><label><input required="required" type="radio" name="flag" value="Other" /><strong>Something else:</strong> Another issue which requires moderator attention.</label><br />
		<label>Why does this topic require moderator attention?<br />
		<textarea name="input" style="width:100%;" rows="5" placeholder="ONLY FILL THIS IN IF YOU ARE USING THE &quot;OTHER&quot; REASON. Otherwise, it will not be sent." disabled="disabled" oninput="this.innerHTML=this.value"></textarea></label>
		</li>
		</ul>
		<input type="submit" value="Flag!" /></fieldset>
	</form>
	<details><summary>This post</summary><div style="border:1px solid;padding:4px;"><?php echo $msgs->$post->html; ?></div></details>
	<script>
	hljs.initHighlightingOnLoad();

	document.body.onclick = function() {
		if (document.querySelector('input[value=Other]').checked) { document.querySelector('textarea').required = 'required'; document.querySelector('textarea').disabled = ''; } else { document.querySelector('textarea').removeAttribute('required'); document.querySelector('textarea').disabled = 'disabled'; }
	}</script>
	</body></html>