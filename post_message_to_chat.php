<?php

header('Content-Type: application/json');
include_once('./libraries/lib.php');
include_once('./libraries/parsedown.php');
$Parsedown = new Parsedown;
$message = $_POST['message'];
$room = $_POST['room'];
$name = explode("\0", $_COOKIE['login'])[0];
$attach = cleanFilename($_POST['attach']);
$image = 'data/accounts/'.cleanFilename($name).'/avatar.png';
if ($attach == "") {
	$GLOBALS['attach'] = 'none!';
} else {
	if (file_exists('files/uploads/'.$attach)) {
		$GLOBALS['attach'] = htmlspecialchars($attach) . ' (<a href="files/uploads/'.htmlspecialchars($attach).'" download="">download at your own risk!</a>) (<a href="files/uploads/'.htmlspecialchars($attach).'" target="_blank">view raw</a>)';
	} else {
		$GLOBALS['attach'] = 'File not found. Ask the sender!';
	}
}
if ($name) {
	putenv("TZ=UTC");
	$raw = $Parsedown->text($message);
	$parsedHTML = html_entity_decode($raw);
	$parsedHTML = preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $parsedHTML);
	$time = date("Y-m-d H-i-s", time());
	$time.=' UTC';
	$name = getname() . time();
	$Parsedown = new Parsedown;
	class msg {
		public $author = null;
		public $md = null;
		public $time = null;
		function __construct($author, $md, $time, $attach) {
			$this->author = $author;
			$this->md = $md;
			$this->time = $time;
			$this->attach = $attach;
			$Parsedown = new Parsedown;
			$this->html = $Parsedown->text($this->md);
		}
	}
	$json = json_decode(file_get_contents(__DIR__ . '/data/messages/'.cleanFilename($_POST['room']) . '/msg.json'));
	$roomobj = json_decode(file_get_contents(__DIR__ . '/data/messages/'.cleanFilename($_POST['room']) . '/config.json'));
	// Add post to user contributions
	$contribsPath = __DIR__ . '/data/accounts/' . cleanFilename(getname()) . '/contribs.json';
	if (!file_exists($contribsPath)) $contribs = array();
	else $contribs = json_decode(file_get_contents($contribsPath));
	$contrib = new stdClass;
	$contrib->room = $_POST['room'];
	$contrib->post = $name;
	array_unshift($contribs, $contrib);
	fwrite(fopen($contribsPath, 'w+'), json_encode($contribs));
	$author = $roomobj->author;
	if ($author !== getname()) {
		// Then, notify the author of a new question reply
		$not = new stdClass;
		$not->type = "Reply to your question";
		$not->read = false;
		$not->url = 'viewtopic.php?room=' . urlencode($_POST['room']) . '#topic-message-' . urlencode($name);
		$not->text = "New reply to a thread you created. Click to open it and read the new reply.";
		$not->time = time();
		$existingnotifications = json_decode(file_get_contents("data/accounts/" . cleanFilename($author) . "/inbox.json"));
		array_push($existingnotifications->items, $not);
		fwrite(fopen("data/accounts/" . cleanFilename($author) . "/inbox.json", "w+"), json_encode($existingnotifications));
	}
	$json->$name = new msg(getname(), $_POST['message'], time(), $_POST['attach']);
	if ($_POST['reply'] != '')
		$json->$name->reply = $_POST['reply'];

	if ($_POST['reply'] != '') {
		if (file_exists(__DIR__ . '/data/accounts/' . cleanFilename($_POST['reply']) . '/user.txt')) {
			if (!file_exists(__DIR__ . '/data/accounts/' . cleanFilename($_POST['reply']) . '/inbox.json')) {fwrite(fopen(__DIR__ . '/data/accounts/' . cleanFilename($_POST['reply']) . '/inbox.json', 'w+'), '{"items":[]}');}

			$inbox = json_decode(file_get_contents(__DIR__ . '/data/accounts/' . cleanFilename($_POST['reply']) . '/inbox.json'));
			$item = new stdClass;
			$item->time = time();
			$item->text = getname() . ' replied to your post in ' . $_POST['room'];
			$item->read = false;
			$item->type = "Chat reply";
			if ($inbox->items == null) $inbox->items = array();
			$item->url = 'viewtopic.php?room=' . urlencode($_POST['room']);
			array_push($inbox->items, $item);
			fwrite(fopen(__DIR__ . '/data/accounts/' . cleanFilename($_POST['reply']) . '/inbox.json', 'w+'), json_encode($inbox));
		}
	}
	$pointer = fopen('data/messages/'.cleanFilename($room).'/msg.json', 'w+');
	$p = json_decode(file_get_contents('data/messages/'.cleanFilename($room).'/config.json'));
	$p->replies++;
	fwrite(fopen('data/messages/'.cleanFilename($room).'/config.json', 'w+'), json_encode($p));
	$write = fwrite($pointer, json_encode($json));
	$search = fopen(__DIR__ . '/data/messages/'.cleanFilename($_POST['room']).'/webchat.txt', 'a+');
	fwrite($search, "<div>".htmlspecialchars(getname())." on ".date("Y:m:d H:i:s", time()).":<div>".$Parsedown->text($_POST['message'])."</div>with attachment &quot;".$_POST['attach']."&quot;</div>");
	if ($write) {
		echo '{"status":true}';
	} else {
		echo '{"status":null}';
	}
} else {
	echo '{"status":false}';
}
if (!isset($_POST['js'])) header("Location: viewtopic.php?room=" . urlencode($_POST['room']));
?>