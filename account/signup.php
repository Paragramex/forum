<?php

ini_set('display_errors',1);

error_reporting(E_ALL);
?><html>
  <head>
	<base href="../" />
    <title>Sign Up</title>
	<?php
	include('../public/header.php');
	include('../styles/inject.php');
	?>
  </head>
  <body>
	  <?php 
$IP = $_SERVER['REMOTE_ADDR'];
$IPBans = json_decode(file_get_contents('../ipblock.json'));
if (isset($IPBans->$IP)) {
	?><p>Sorry, you cannot create an account right now because your IP address has been blocked for the following reason:</p>
	  <p><?php echo htmlspecialchars($IPBans->$IP->reason); ?></p><?php
	if (!$IPBans->$IP->blockExistingAccounts) {
		?><p>To create an account, please try again when you have a different IP address.</p><?php
	}
	exit(0);
}
?>
  <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
	<?php
	$page = $_POST['page'];
	if ($page == "1") {
		echo '<script>function change(){if(document.getElementById("psw").type=="password"){document.getElementById("psw").type="text";}else{document.getElementById("psw").type="password";}}</script>';
		echo '<input type="hidden" value="2" name="page" />';
		echo '<center><h2>Fill in information. This is step two of three.</h2>';
		echo '<big><strong>Be careful! You cannot change any of these fields after you sign up!</strong></big><br>';
		echo '<script>function random(min, max) {return Math.random() * (max - min) + min;}</script>';
		echo '<label for="usr"><strong>Enter your username (3-25 characters).</strong><br><small>It is recommended to not use your real name for privacy online. Anyone can screenshot or see your username, as it is available publicly.</small><br></label>';
		echo '<input minlength="3" value="' . (isset($_GET['name']) ? htmlspecialchars($_GET['name']) : "") . '" maxlength="25" required="required" type="text" size="25" id="usr" name="usr" />';
		echo '&nbsp;';
		echo '<button type="button" onclick="document.getElementById(\'usr\').value=\'user\'+Math.round(random(1000000000,9999999999));">Generate random</button>';
		echo '<br><label for="psw">Enter a password:</label><br>';
		echo '<input spellcheck="false" type="password" id="psw" name="psw" required="required" />';
		echo '&nbsp;&nbsp;';
		echo '<button type="button" onclick="change()">Show/Hide Password</button>';
		echo '<br><br>';
		echo '<label for="date">When did you turn 20?&nbsp;</label>';
		include('../files/date.php');
		echo '<br><br>';
		echo '<label for="image">Profile picture (100x100 is best): </label>';
		echo '<input type="file" accept="image/png" name="image" id="image" />';
		echo '<br><br>';
		?>
		<label>Security question (for password resets): <input type="text" required="required" name="question" /></label><br />
		<label>Answer:
		<input type="text" name="answer" required="required" /></label>
		<br /><br />
		<?php
		echo '<input type="submit" value="Continue" />';
	} else if ($page == "2") {
		$PASSWORD = $_POST['psw'];
		$USER = $_POST['usr'];
		$directory = cleanFilename($USER);
		if (!(file_exists('../data/accounts/'.$directory.'/user.txt'))) {
			$now = new DateTime('now');
			$twenty = new DateTime($_POST['date']);
			$diff = $twenty->diff($now);
			$years = $diff->y + 1;
			if ($years > 30) {
				echo "You are underage. You have to be at least 9 years of age to continue.";
			} else {
				echo "<center><h2>Hi, @".htmlspecialchars($USER)."! Just a second...</h2>";
				echo "<h3>We're setting up your account. This may take a long time. Please do not close this window, as all data will be lost if you do so. Thank you.</h3></center>";
				$hash = password_hash($PASSWORD, PASSWORD_DEFAULT);
				error_log(__DIR__ . '/../data/accounts/'.$directory.'/question.json');
				if (!$hash) {
					echo "Password hash not created. Try reloading.";
				} else {
					echo "Password hash created.";
				}
				class securityQuestion {
					public $question = null;
					public $answer = null;
				}
				$userinput = new securityQuestion;
				$userinput->question = $_POST['question'];
				$ansHash = password_hash($_POST['answer'], PASSWORD_DEFAULT);
				if (!$ansHash) {
					die("Hash not generated");
				}
				$illegal = array(" ","?","/","\\","*","|","<",">",'"');
				// legal characters
				$legal = array("-","_","_","_","_","_","_","_","_");
				$directory = str_replace($illegal,$legal,$USER);
				$fullname = '../data/accounts/'.$directory;
				$dirstatus = mkdir('../data/accounts/'.$directory, 0777, true);
				if ($dirstatus) {
					echo "<br>Your personal directory was created.";
				} else {
					echo "<br>Bad bad bad. Your personal directory was not created.";
				}
				fwrite(fopen("../data/accounts/" . $directory . '/inbox.json', 'w+'), '{"items":[{"time":0,"text":"Welcome to this forum! We are glad that you are here.","read":false,"type":"Welcome","url":"welcome.php"}]}');
				$userinput->answer = $ansHash;
				$userinputHandle = fopen(__DIR__ . '/../data/accounts/'.$directory.'/question.json', 'w+');
				$json_encoded = json_encode($userinput);
				fwrite($userinputHandle, $json_encoded);
				$about = fopen(__DIR__ . '/../data/accounts/'.cleanFilename($USER).'/user.json', 'w+');
				fwrite($about, '{"text":"","site":"","github":"","mail":""}');
				if ($_FILES['image']['name'] != '' && $_FILES['image']['size'] < 4538) {
					$uploaddir = __DIR__ . '/../data/accounts/'.cleanFilename($USER).'/';
					$uploadfile = $uploaddir . basename($_FILES['image']['name']);

					echo '<pre>';
					if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
						echo "Avatar is valid, and was successfully uploaded. ";
						rename('../data/accounts/'.cleanFilename($USER).'/'.$_FILES['image']['name'], '../data/accounts/'.cleanFilename($USER).'/avatar.png');
					} else {
						echo "Possible file upload attack!\n";
					}

					echo '<details><summary>Here is some more debugging info:</summary>';
					echo var_dump($_FILES);

					print "</details></pre>";
				} else {
					$avatar = fopen('../data/accounts/'.cleanFilename($USER).'/avatar.png', 'w+');
					fwrite($avatar, file_get_contents('../data/accounts/default.png'));
				}
				$hashfile = fopen($fullname . "/psw.txt", 'w+');
				$hashwrite = fwrite($hashfile, $hash);
				fclose($hashfile);
				if ($hashwrite) {
					echo "<br>Hash file generated.";
				} else {
					echo "<br>Houston, we have a really serious problem... We can't write the hash!";
				}
				$userfile = fopen($fullname . "/user.txt", 'w+');
				$userwrite = fwrite($userfile, $USER);
				fclose($userfile);
				if ($userwrite) {
					echo "<br>Account registration completed.";
				} else {
					echo "<br>This is <em>really</em> serious. Start again. Thanks!";
			}
		}
		} else {
			echo 'Username is taken';
		} 
	} else if ($page != "1" && $page != "2") {
		echo '<center><h2>Welcome: This is step one of three.</h2>';
		echo "<h3>Please read this information, then state if you agree with it.</h3></center>";
		include('../tos_raw.php');
		echo '<center>';
		echo '<input type="hidden" value="1" name="page" />';
		echo '<input type="submit" value="I agree to these terms" /> &nbsp; ';
		echo '<input type="reset" onclick="location.href=\'/\';" value="I do not agree" />';
		echo '</center>';
	}
?>
	</form>