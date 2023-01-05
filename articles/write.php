<?php

?><html>
  <head>
	<base href="../../" />
    <title>Articles - Write</title>
	<?php
	include('../public/header.php');
	include('../styles/inject.php');
	if (!isset($_COOKIE['login'])) die("Log in to write");
	?>
	</head>
	<?php 
		class Article {
			public $text = null;
			public $title = null;
			public $time = null;
			public $author = null;
		}
		if (isset($_POST['title'])) {
			$article = new Article;
			if (file_exists('./content/'.cleanFilename($_POST['title']).'/config.json')) {
				?> ERR: Article with that name already exists.<?php
			} else {
				$article->title = $_POST['title'];
				$article->author = explode("\0", $_COOKIE['login'])[0];
				$article->time = time();
				$article->text = $_POST['message'];
				mkdir("./content/".cleanFilename($_POST['title']));
				$write = fwrite(fopen('./content/'.cleanFilename($_POST['title']).'/config.json', 'w+'), json_encode($article));
				if ($write) {
					die("Success!");
				} else {
					echo 'Couldn&apos;t write article!';
				}
			}
		}
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="form">
		<label>Title: 
		<input type="text" name="title" required="required" value="<?php if (isset($_POST['title'])) { echo htmlspecialchars($_POST['title']); } ?>" /></label>
		<br />
		<label>Contents (markdown supported):<br />
		<textarea name="message" rows="20" style="width:100%;"><?php if (isset($_POST['message'])) { echo htmlspecialchars($_POST['message']); } ?></textarea>
		</label>
		<button id="previewButton" type="button" onclick="this.innerHTML='Please wait...';this.disabled='disabled';preview()">Preview</button>
		<div id="preview" style="border:1px solid;margin:3px;">Markdown preview here</div>
		<input type="submit" value="Go" />
	</form>
	<script>
	function preview() {
    let xhr = new XMLHttpRequest();

    xhr.open("POST", "../libraries/parsemd.php");
	let formdata = new FormData(document.getElementById('form'));
    xhr.send(formdata);

    xhr.onload = function () {
        if (xhr.status != 200) {
			throw new Error('error');
			document.getElementById('preview').innerHTML = "<span style=\"color:red;\">Error "+xhr.status+"!</span>";

        } else {
			var text = xhr.responseText;
			document.getElementById('preview').innerHTML='';
			document.getElementById('preview').innerHTML=text;
			hljs.highlightAll();
			document.getElementById('previewButton')
				.setAttribute(
					'style',
					'color:white;background-color:#00ff00;'
				);
			document.getElementById('previewButton').innerHTML = 'Done';
			setTimeout(function() {
				document.getElementById('previewButton').removeAttribute('style');
				document.getElementById('previewButton').innerHTML = 'Preview';
				document.getElementById('previewButton').disabled = '';
			}, 667);
        }
    };
    xhr.onerror = function () {
        alert("Request failed");
    };
}
</script>
