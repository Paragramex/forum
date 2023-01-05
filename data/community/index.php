<?php

?><html>
  <head>
	<base href="../../" />
    <title>data/community</title>
	<?php
	include('../../public/header.php');
	include('../../styles/inject.php');
	?>
  </head>
  <body>
	<p>This is the <code>data/community</code> directory, used for storing data that is generated by the system when a user posts content.</p>
	<p>Nothing to see here!</p>
	<?php
echo "<pre>";
if ($handle = opendir('./')) {
    echo "<h2>Data Explorer</h2>";
    echo "<h3>Entries:</h3><ul>";

    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
		if ($entry != "index.php") {
        	echo "<li><a href=\"data/$entry/\">$entry</a></li>";
		} else {
			echo "<li><a href=\"data/$entry\">$entry</a></li>";
		}
    }

    closedir($handle);
}
echo "</ul></pre>";
	include('../../public/footer.php');
	?>
</body>
</html>