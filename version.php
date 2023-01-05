<?php

?><html lang="en">
  <head>
    <title>Installed Software</title>
	<?php
	include_once('./public/header.php');
	include_once('./styles/inject.php');
	?>
  </head>
  <body>
    <h2>Version Information</h2>
<table>
    <tr>
        <th scope="row">nodb-forum installed:</th>
        <td><?php echo file_exists('config.json') ? 'Yes' : 'No, please <a href="app/install.php">set it up first</a>'; ?></td>
    </tr>
    <tr>
        <th scope="colgroup" colspan="2">Installed Plugins (<?php echo count(scandir('extensions/', SCANDIR_SORT_NONE)) - 3; ?>)</th>
    </tr>
    <?php 
$ext = scandir('extensions/');
foreach ($ext as $p) {
    if (in_array($p, array('.', '..', 'readme.txt'))) {
        continue;
    }
        $c = json_decode(file_get_contents("extensions/$p/config.json"));
    ?>
        <tr>
            <th scope="colgroup">Plugin: <?php echo $c->name; ?></th>
        </tr><?php
    foreach ((array) $c as $prop => $value) {
        ?><tr>
            <th scope="col"><?php echo htmlspecialchars($prop); ?></th>
            <td><?php echo htmlspecialchars(json_encode($value)); ?></td>
        </tr><?php
    }
}
?>
</table>
