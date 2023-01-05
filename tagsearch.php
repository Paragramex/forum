<?php

?><html>
  <head>
	<?php
	include('./public/header.php');
	include('./styles/inject.php');
	?>
    <title>Search with Tags</title>
  </head>
  <body>
<form action="search.php" method="GET">
	<fieldset><legend>Tags to add</legend>
	<label>Search for this: <input type="search" name="query" /></label>... <label>With these space-separated tags: <input type="text" name="tags" /></label>
	<input type="submit" value="Search" /></fieldset>
</form>
	  <p>Tags you search for will show up in the search box.</p>
<img src="img/tagsearch.png" style="max-width:100%;" alt="Tag search" />