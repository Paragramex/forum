<?php

date_default_timezone_set('UTC');

set_error_handler(function($errno, $errstr, $errfile, $errline) {
	if (isset($GLOBALS['noerror'])) return;
	logmsg("error", "Error number " . $errno . " with string " . json_encode($errstr) . " in file " . $errfile . " on line " . $errline, getname());
	?>
<details>
	<summary style="color:red;"><i>AN ERROR HAS OCCURRED (Click to view)</i></summary>
<div>
	<strong>[Debug info] Error:</strong>
	<table class="table">
		<tr>
			<th>Name</th>
			<th>Value</th>
		<tr>
			<td>Error number</td>
			<td><?php echo $errno; ?></td>
	</tr>
		<tr>
			<td>Error string</td>
			<td><?php echo htmlspecialchars($errstr); ?></td>
		</tr>
		<tr>
			<td>File</td>
			<td><?php echo $errfile; ?></td>
		</tr>
		<tr>
			<td>Line</td>
			<td><?php echo $errline; ?></td>
	<tr>
		<td>Explanation</td>
		<td> <?php 
						if (htmlspecialchars($errstr) == "Invalid argument supplied for foreach()"){
							echo "The code could not find/parse the value put in the foreach() function.";
						} else if (htmlspecialchars($errstr) == "natcasesort() expects parameter 1 to be array, bool given") {
							echo "Array has not been filled up so it does not fit into code.";
						}	else if (htmlspecialchars($errstr) == "scandir(): (errno 2): No such file or directory"){
							echo "Program could not find the file/directory anywhere. Maybe file/directory is created by user input?";
							
						} else if (htmlspecialchars($errstr) == "scandir(./content): failed to open dir: No such file or directory"){ echo "Could not find any articles or files in this directory. Maybe create one?";
							
						} else if (htmlspecialchars($errstr) == ""){
							echo "Error not found but system has stopped: THIS IS FATAL, PLEASE REPORT USING BUTTON BELOW";
						} else if (htmlspecialchars($errstr) == ""){
							
						} else if (htmlspecialchars($errstr) == "file_get_contents(./readme.txt/config.json): failed to open stream: No such file or directory"){
							echo "Nothing in the directory that this program reads (example: no flags have been made. This will throw this error...)";
						}  else if (htmlspecialchars($errstr) == "chdir(): No such file or directory (errno 2)"){
							echo "Program tried to interact with another directorys files, the directory did not have the correct files it was looking for";
						}  else if (htmlspecialchars($errstr) == "file_get_contents(msg.json): failed to open stream: No such file or directory
"){
							echo "The program attempted to edit/remove/add messages in a topic with no messages :(";
						}  /*else if (htmlspecialchars($errstr) == ""){
							echo "";
						}  else if (htmlspecialchars($errstr) == ""){
							echo "";
						}  else if (htmlspecialchars($errstr) == ""){
							echo "";
						}  else if (htmlspecialchars($errstr) == ""){
							echo "";
						}  else if (htmlspecialchars($errstr) == ""){
							echo "";
						}  else if (htmlspecialchars($errstr) == ""){
							echo "";
						}*/ else {
							echo "Error does not have an explanation. Please report this error below to fix this.";
						}
									
									
									
			?> 
		</td>
	</tr>
	</table>
	<a href="https://github.com/Paragramex/forum/issues/new/choose">Report this error</a></div>
	</details>	
	<?php
	return true;
}, E_ALL & ~E_NOTICE);
?><!-- Why not take this for some ice 
cream⸮ It's only a prick!

Why not⸮ People are harmed more than
helped by this! -->
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<link rel="icon" type="image/x-icon" href="<?php echo __DIR__ . '/../img/logo.png'?>" />
<?php
ini_set('display_errors', 0);
require_once __DIR__ . '/../libraries/lib.php';
echo '<link rel="stylesheet" href="./styles/main/main.css" />';
if (file_exists(__DIR__ . '/../config.json')) {
	$config = json_decode(file_get_contents(__DIR__ . '/../config.json'));
	if (!isset($config->admins)) $config->admins = array('admin');

	fwrite(fopen(__DIR__ . '/../config.json', 'w+'), json_encode($config));
}
	if (file_exists(__DIR__ . '/../data/accounts/' . cleanFilename(getname()) . "/increasedfontsize.txt")) {
		echo "<style>body { font-size: 125% !important; }</style>";
	}
?>
<link rel="stylesheet"
      href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.2.0/styles/vs.min.css" />
<!-- highlight.js -->
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.2.0/highlight.min.js"></script>
<script>
console.log('%cIf you are pasting code here others could be trying to make you do Self XSS. ', 'color:red;font-size:2em;');
console.log("%cWhat could attackers do when you paste their code? A lot of evil things. Such as:\n - Logging a user out\n - Creating random topics without user interaction\n - or even send messages without user consent!\nSo don't paste any code unless you absolutely know what you're doing!", 'color:#d3b312;font-size:1.2em;')
console.log("%cIf you're debugging you're fine", 'color:peachwhite;font-size:1.5em;');
console.log("%cIf you're wondering how to make a bot, we are working on an API page for the public" , "color:peach;font-size:1.25em;"
window.addEventListener('DOMContentLoaded', function() {
	hljs.highlightAll();
});
</script>
<?php 
require_once __DIR__ . '/../libraries/lib.php';
?>
<script src="libraries/load.js"></script>