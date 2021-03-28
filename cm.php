<?php
	header("Content-Type: text/plain");
	include_once("functions.php");

	$clanManagement = clanManagement();
	$MessageData = createMessage($clanManagement);
	
	if(in_array(date('D'), DAYS_TO_POST)) { 
		sendDiscordMessage($MessageData);
	}
	
	printData($MessageData);
?>