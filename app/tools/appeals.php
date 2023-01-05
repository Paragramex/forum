<?php
include('header.php');
if (!file_exists(__DIR__ . '/../../extensions/forum-ban-appeal/appeals.php')) {
	die("Sorry, the Ban Appeal extension is not installed. For questions on how to intall plugins, view your /extensions/ directory");
} else {
	include(__DIR__ . '/../../extensions/forum-ban-appeal/appeals.php');
}