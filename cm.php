<?php
	header("Content-Type: text/plain");
	include_once("functions.php");
	
	$pw = @$_GET["pw"];
	
	$clanManagement = clanManagement();

	if(DISCORD_ENABLED && in_array(date('D'), DISCORD_DAYS_TO_POST) && $pw == DISCORD_PASSWORD) { 
		sendDiscordMessage(createMessage($clanManagement, false));
	}
	
	printData(createMessage($clanManagement, true));
?>