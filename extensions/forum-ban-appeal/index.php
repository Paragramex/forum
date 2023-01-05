<?php 
	if (isset($_POST['appeal'])) {
		$handle = fopen(__DIR__ . '/../../data/accounts/'.cleanFilename(getname()).'/appeal.txt', 'w+');
		$status = fwrite($handle, $_POST['reason']);
		if ($status) {
			echo 'Your ban appeal was filed successfully.';
		} else {
			echo 'There was a problem filing your appeal!';
		}
	}
?>
<h3>You may appeal this ban if you believe it was done in error.</h3><p>
<?php
if (file_exists(__DIR__ . '/../../data/accounts/'.cleanFilename(getname()).'/appeal.txt')) {
	echo 'NOTE: We found an existing appeal. You can add another appeal to the existing reason.';
}
?></p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<label>Reason:<br />
<textarea name="reason" rows="20" style="width: 100%;" minlength="1"><?php 
	if (file_exists(__DIR__ . '/../../data/accounts/'.cleanFilename(getname()).'/appeal.txt')) {
		echo htmlspecialchars(file_get_contents(__DIR__ . '/../../data/accounts/'.cleanFilename(getname()).'/appeal.txt'));
	}
?></textarea>
</label><br />
<input type="submit" value="appeal" name="appeal" />
</form>