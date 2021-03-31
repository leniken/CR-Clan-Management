<?php
	include_once("functions.php");
	
	$pw = '';
	if(@$_GET["pw"] != NULL){
		$pw = $_GET["pw"];
	} elseif(@$_POST["discordPassword"] != NULL){
		$pw = $_POST["discordPassword"];
	}
?>

Post to
<div class="discord-link">
	<a href="#passwordModal" data-toggle="modal"><img src="img/Discord-Logo+Wordmark-Color.png"></a>
</div>



<?php	
	$clanManagement = clanManagement();

	if(DISCORD_ENABLED && in_array(date('D'), DISCORD_DAYS_TO_POST) && $pw == DISCORD_PASSWORD) { 
		sendDiscordMessage(createMessage($clanManagement, false));
	}
	
	printData(createMessage($clanManagement, true));
?>


			
<div class="modal fade text-dark" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="authorLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="authorLabel">Security</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="passwordForm" id="passwordForm" method="post">
		  <div class="modal-body">
				<div class="form-group">
					<label for="exampleInputPassword1">Security password to post on Discord</label>
					<input type="password" class="form-control" id="discordPassword" name="discordPassword" placeholder="Password">
				</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary">Post</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
	  </form>
	</div>
  </div>
</div>