<?php

?><html lang="en">
  <head>
    <base href="../../" />
    <title>Edit User Subpages</title>
	<?php
	include('../../public/header.php');
	include('../../styles/inject.php');
	require 'editorlib.php';
	?>
  </head>
  <body>
<?php 
if (!isset($_GET['path'], $_GET['username'])) die("You must specify a username and path.");

$datapath = __DIR__ . '/../../data/accounts/' . cleanFilename($_GET['username']) . '/subpages.json';
if (!file_exists($datapath)) {
	die("Your input was invalid.");
}
$obj = unserialize(base64_decode(file_get_contents($datapath)));
$path = array_filter(explode("/", $_GET['path']), function($v) { return $v !== ''; });
if (!checkIfPageExists($path, $obj)) {
	die("The specified page does not exist.");
}
$info = checkIfPageExists($path, $obj);
$readonly = getname() !== $_GET['username'];
if (isset($_POST['contents'])) {
	if (!$readonly) {
		?><p>Saving your page...</p><?php
		$objProps = "";
		$currentobj = $obj;
		foreach ($path as $index => $element) {
			if (!isset($path[$index + 1])) {
				$objProps .= '->{"files"}->{' . json_encode($element) . '}';
				$currentobj = $currentobj->files->$element;
			} else {
				$objProps .= '->{"folders"}->{' . json_encode($element) . '}';
				$currentobj = $currentobj->folders->$element;
			}
		}
		$GLOBALS['currentobj'] = $currentobj;
		$currentobj->contents = $_POST['contents'];
		$rev = new pageRevision($_POST['contents'], $_POST['summary']);
		array_unshift($currentobj->revisions, $rev);
		eval('$obj' . $objProps . ' = $currentobj;');
		fwrite(fopen(__DIR__ . '/../../data/accounts/' . cleanFilename($_GET['username']) . '/subpages.json', 'w+'), base64_encode(serialize($obj)));
		?>Subpage saved. <a href="account/pages?path=<?php echo htmlspecialchars(urlencode(implode('/', $path))); ?>&username=<?php echo htmlspecialchars(urlencode($_GET['username'])); ?>">Return to your subpage?</a><?php
	}
}
?>
<h2><?php echo $readonly ? "View source for " : "Edit "; echo htmlspecialchars($info->title); ?></h2>
<?php 
if ($readonly) {
	?><p>You do not have permission to edit this page, however, you can still view its source.</p><?php
}
?>
<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
	<?php 
userSubpageEditor($info->contents, $readonly);
?>
<p>Return to <a href="account/pages?path=<?php echo htmlspecialchars(urlencode(implode('/', $path))); ?>&username=<?php echo htmlspecialchars(urlencode($_GET['username'])); ?>">subpage</a>.</p>