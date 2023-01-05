<?php

?><html>
  <head>
	<base href="../" />
    <title>Forums &mdash; Installation</title>
	<?php
	include('../styles/inject.php');
	?>
  </head>
  <body>
	<?php 
		if (file_exists('../config.json')) {
			header('Location: ..');
		}
	?>
	<h1>Install!</h1>
	<p>It looks like your discussion board has not been set up yet! That's fine, you can set it up by completing the form below.</p>
	<p>If you think you already installed the software and you see this screen after reloading, there's something wrong with the installation. Please open an issue on GitHub: Paragramex/forum.</p>
	<form action="app/welcome.php" method="post">
	<label for="title">Type the title:</label>
	<input type="text" id="title" name="title" required="required" value="My Forum &lt;small&gt;v1.0&lt;/small&gt;" size="35"/>
	<br />
	HTML will <strong>not</strong> be escaped! This allows rich text formatting. Please be aware that this is used in the forum title on the top of the tab.
	<hr />
	<label>These are the tags. Type them, separated by spaces.
	<br />
	<input type="text" name="tags" style="width: 100%;" placeholder="javascript python php" />
	</label>
	<hr />
	<input type="submit" value="install" /></form></bodybody></html>