<?php

?><html lang="en">
  <head>
    <base href="../../" />
    <title>User Subpages</title>
	<?php
include ('../../public/header.php');
include ('../../styles/inject.php');
require 'editorlib.php';
?>
  </head>
  <body>
	  <h2>Create a User Subpage</h2>
	<?php
if (!isset($_COOKIE['login'])) {
?>Log in to write subpages<?php
	exit(0);
}
function savePage() {

	if (isset($_POST['title'], $_POST['contents'])) {
?><p>Saving your page... please wait.</p><?php
		if (!file_exists(__DIR__ . '/../../data/accounts/' . cleanFilename(getname()) . '/subpages.json')) $obj = json_decode("{}");
		else $obj = unserialize(base64_decode(file_get_contents(__DIR__ . '/../../data/accounts/' . cleanFilename(getname()) . '/subpages.json')));
		$path = explode("/", $_POST['title']);
		$path = array_values(array_filter($path, function ($m) {
			return $m !== "";
		}));
		$currentobj = $obj;
		$objPath = "";
		foreach ($path as $index => $element) {
			if (!isset($path[$index + 1])) {
				$objPath .= '->files->{' . json_encode($element) . '}';
				if (!isset($currentobj->files)) {
					$currentobj->files = json_decode("{}");
				}
				$currentobj->files->$element = new subPage($_POST['type'], $element, $_POST['contents']);
				$currentobj = $currentobj->files->$element;
				$GLOBALS['currentobj'] = $currentobj;
				eval('$obj' . $objPath . ' = $currentobj;');
				break;
			}
			else {
				$objPath .= ('->folders->{' . json_encode($element) . '}');
				if (!isset($currentobj->folders)) {
					$currentobj->folders = json_decode('{}');
					$currentobj->folders->$element = new folder($element);

				}
				$currentobj = $currentobj->folders->$element;
			}
			$GLOBALS['currentobj'] = $currentobj;
			eval('$obj' . $objPath . ' = $currentobj;');
		}
		fwrite(fopen("../../data/accounts/" . cleanFilename(getname()) . '/subpages.json', 'w+'), base64_encode(serialize($obj)));
		?><p>Page saved. <a href="<?php echo htmlspecialchars("account/pages/index.php?username=" . urlencode(getname()) . "&path=" . urlencode(implode("/", $path))); ?>">Click to visit it now.</a></p><?php
		exit(0);
	}
}
savePage();
?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<label>Choose the content type of the page. This cannot be changed later.<br />
		<select name="type">
			<option value="markdown">Markdown document</option>
			<option value="txt">Plain text file</option>
			<option value="js">JavaScript file</option>
			<option value="css">CSS file</option>
		</select>
		</label><br />
		<label>Enter the path and filename, without the leading slash. If the page already exists, an error will occur.
		<input required="required" type="text" name="title" value="<?php if (isset($_POST['title'])) {
	echo htmlspecialchars($_POST['title']);
} ?>" />
		</label>
		<details><summary>Examples of directories</summary>
			<ul>
				<li><code>/foo</code> or <code>foo</code>: page named <code>foo</code> in root directory</li>
				<li><code>foo/bar</code>: Page <code>bar</code> in directory <code>foo</code>, which also functions as the index page of <code>foo/bar/</code></li>
			</ul></details>
		<?php
$contents = isset($_POST['contents']) ? $_POST['contents'] : "";
userSubpageEditor($contents, false, true);
?>
