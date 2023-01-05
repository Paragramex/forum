<?php

?><html>
  <head>
    <title>Compare Revisions</title>
	<?php
	include('./public/header.php');
	include('./styles/inject.php');
	?>
  </head>
  <body>
  <?php 
  if (!isset($_POST['old'], $_POST['new'])) die("Not all parameters specified.");

  $old = json_decode($_POST['old']);
  $new = json_decode($_POST['new']);
  if (!(is_string($old) && is_string($new))) die("Malformed input.");
  ?>
  <h2>Comparison of provided strings</h2>
  <table>
  <tr>
  <th>Old</th>
  <th>New</th>
  </tr>
  <tr>
  <td>
  <pre><?php echo htmlspecialchars($old); ?></pre></td>
  <td>
  <pre><?php echo htmlspecialchars($new); ?></pre></td>
  </tr>
  </table><?php
  require 'libraries/diff.php';
  diff($old, $new);