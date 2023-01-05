
This is a list of banned users who have filed ban appeals.
<table>
<tr>
<th>Name</th>
<th>Appeal</th>
</tr>
<?php
if ($handle = opendir(__DIR__ . '/../../data/accounts/')) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != "." && $entry != ".." && (is_dir(__DIR__.'/../../data/accounts/'.$entry.'/')) && (file_exists(__DIR__.'/../../data/accounts/'.$entry.'/appeal.txt')) && (file_exists(__DIR__.'/../../data/accounts/'.$entry.'/ban.txt'))) {
			echo '<tr><td>';
			echo htmlspecialchars(file_get_contents(__DIR__.'/../../data/accounts/'.$entry.'/user.txt'));
			echo '</td><td><textarea readonly="readonly" rows="25" cols="80">';
			echo htmlspecialchars(file_get_contents(__DIR__.'/../../data/accounts/'.$entry.'/appeal.txt'));
			echo '</textarea></td></tr>';
		}
	}
	closedir($handle);
} else {
	echo '<tr><td>ERROR:</td><td>Could not fetch appeals</td></tr>';
}
?>
</table>
