<?php

?><html>
  <head>
	<base href="../../" />
	<title>About the Articles</title>
	<?php 
	include('../public/header.php');
	include('../styles/inject.php');
	?>
	</head>
	<body>
	<h2>Articles are like permanent information containers.</h2>
	because they exist indefinitely and cannot be deleted by anyone.
	<p>The data is stored as JSON, making it easy to read or write from. Minifying the JSON also saves disk space so there is more room for new articles.</p>
	<details>
	<summary>Raw data</summary>
	<pre style="word-break:break-word;"><code class="lang-json"><?php 
		$stuff = new stdClass;
		if ($array = array_diff(scandir('./content'), array('.', '..'))) {
			natcasesort($array);
			foreach ($array as $entry)
				$stuff->$entry = json_decode(file_get_contents('./content/'.$entry.'/config.json'));
			echo htmlspecialchars(json_encode($stuff));
		}
	?></code></pre>
	</details>
	<script>hljs.highlightAll();</script>
