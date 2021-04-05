<?php
	include_once("config.php");
	

	
	
	function clanManagement(){

		/* 
		* get data 
		*/
		
		/* Get name, donations and rank */		
		$url = "https://api.clashroyale.com/v1/clans/".urlencode(CLAN_TAG);

		$ch = curl_init($url);
		
		$headr = array();
		$headr[] = "Accept: application/json";
		$headr[] = "Authorization: Bearer ".API_TOKEN;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		$clanDataJSON = curl_exec($ch);
		$headerSent = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL );

		curl_close($ch);
		$clan = json_decode ($clanDataJSON , $assoc = TRUE);	

		$statArray = [];
		foreach($clan["memberList"] as $member){
			if($member["expLevel"] >= MIN_LEVEL && $member["role"] != "leader"){
				$statArray[$member["tag"]] = array("name" => $member["name"], "donations" => $member["donations"], "role" => $member["role"]);
			}
		}
		
		/* Get war battles */
		$url = "https://api.clashroyale.com/v1/clans/".urlencode(CLAN_TAG)."/currentriverrace";

		$ch = curl_init($url);
		
		$headr = array();
		$headr[] = "Accept: application/json";
		$headr[] = "Authorization: Bearer ".API_TOKEN;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		$raceJSON = curl_exec($ch);
		$headerSent = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL );
		
		curl_close($ch);
		$race = json_decode ($raceJSON , $assoc = TRUE);
		
		/* store war battles */
		foreach($race["clan"]["participants"] as $player){
			if(array_key_exists($player["tag"], $statArray)){
				$statArray[$player["tag"]]["battlecount"] = $player["decksUsed"];
			}
		}
		
		/*
		** Generate clan management data
		*/
		
		/* Define return array */
		$return = [];
		
		/* loop the players */
		foreach ($statArray as $tag => $data){
			
			/* Check action to take for each member equal or above MIN_LEVEL */
			$statArray[$tag]["action"] = max(doPromotion($data), doDemotion($data));
		}
		
		/* return the result */
		return $statArray;
	}

	
	function doPromotion($data){
		$enabled = "DO_".$data["role"]."_MANAGEMENT";
		$strict = $data["role"]."_PROMOTION_STRICT";
		$war = $data["role"]."_PROMOTION_WAR_ATTACKS";
		$donation = $data["role"]."_PROMOTION_DONATION";

		if(constant($enabled)){
			if(constant($strict)){
				if($data["battlecount"] >= constant($war) && $data["donations"] >= constant($donation)){
					return 3;
				}
			} else {
				if($data["battlecount"] >= constant($war) || $data["donations"] >= constant($donation)){
					return 3;
				}
			}
		}
		return 0;
		
		
	}
	
	function doDemotion($data){
		$enabled = "DO_".$data["role"]."_MANAGEMENT";
		$strict = $data["role"]."_DEMOTION_STRICT";
		$war = $data["role"]."_DEMOTION_WAR_ATTACKS";
		$donation = $data["role"]."_DEMOTION_DONATION";
		
		if(constant($enabled)){
			if(constant($strict) && constant($war) != 0 && constant($donation) != 0){
				if($data["battlecount"] < constant($war) && $data["donations"] < constant($donation)){
					if($data["role"] == "member"){
						return 1;
					} else {
						return 2;
					}
				}
			} else {
				if(($data["battlecount"] < constant($war) && constant($war) != 0) || ($data["donations"] < constant($donation) && constant($donation) != 0)){
					if($data["role"] == "member"){
						return 1;
					} else {
						return 2;
					}
				}
			}
		}
		return 0;
	}
	


	function createMessage($clanManagement, $html){
		
		if($html){
			$header	= "It's time for clan management. Here are the proposals of this week\r\n\r\n";
		} else {
			$header	= "It's time for clan management. Here are the proposals of this week ". DISCORD_ROLE_ID ."\r\n\r\n";
		}
		$promoHead =  "**Promotion :star_struck:**\r\n";
		$demoHead =  "**Demotion :cry:**\r\n";
		$kickHead =  "**Kick :mans_shoe:**\r\n";
		
		$promoContent =  "";
		$demoContent =  "";
		$kickContent =  "";
		
		foreach($clanManagement as $tag => $data){
			switch($data["action"]){
				case 1:
					//Kick
					$kickContent .=  singleMessage($tag, $data);
					
					break;
				case 2:
					//Demotion
					$demoContent .=  singleMessage($tag, $data);
					break;
				case 3:
					//Promotion
					$promoContent .=  singleMessage($tag, $data);
					break;
			}
		}
		if($promoContent == ""){
			$promoContent =  "  none :slight_frown:\r\n";
		}
		if($demoContent == ""){
			$demoContent =  "  none :smiling_face_with_3_hearts:\r\n";
		}
		if($kickContent == ""){
			$kickContent =  "  none :partying_face:\r\n";
		}
		
		if($html){
			return array(
				discordToHtml($header), 
				discordToHtml($promoHead), 
				discordToHtml(spaceToNbsp($promoContent)), 
				discordToHtml($demoHead), 
				discordToHtml(spaceToNbsp($demoContent)), 
				discordToHtml($kickHead), 
				discordToHtml(spaceToNbsp($kickContent))
			);
		}
		return array($header, $promoHead, $promoContent, $demoHead, $demoContent, $kickHead, $kickContent);
	}
	
	function singleMessage($tag, $data){
		return "  :small_blue_diamond: ".$data["name"]."(". $tag .") :boom: ".$data["battlecount"]." :gift: ".$data["donations"]."\r\n";
	}
	
	function sendDiscordMessage($messageData){
		
		// Send to Discord Script by Mo45: https://gist.github.com/Mo45/cb0813cb8a6ebcd6524f6a36d4f8862c
		
		//=======================================================================================================
		// Create new webhook in your Discord channel settings and copy&paste URL
		//=======================================================================================================

		$webhookurl = DISCORD_WEBHOOK;

		//=======================================================================================================
		// Compose message. You can use Markdown
		// Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
		//========================================================================================================
		
		$json_data = json_encode([
			// Message
			"content" => $messageData[0],
			// Username
			"username" => DISCORD_BOT_USERNAME,

			"embeds" => [
				[
					// Embed Type
					"type" => "rich",

					// Timestamp of embed must be formatted as ISO8601
					"timestamp" => $timestamp,

					// Embed left border color in HEX
					"color" => hexdec( "3366ff" ),

					// Additional Fields array
					"fields" => [
							[
								"name" => $messageData[1],
								"value" => $messageData[2],
								"inline" => false
							],
							[
								"name" => $messageData[3],
								"value" => $messageData[4],
								"inline" => false
							],
							[
								"name" => $messageData[5],
								"value" => $messageData[6],
								"inline" => false
							],
						
					]
				]
			]

		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


		$ch = curl_init( $webhookurl );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		curl_setopt( $ch, CURLOPT_POST, 1);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt( $ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec( $ch );
		// If you need to debug, or find out why you can't send message uncomment line below, and execute script.
		//echo $response;
		curl_close( $ch );

	}
	
	function printData($messageData){
		foreach ($messageData as $message){
			echo $message;
		}
	}
	
	function discordToHtml($text) {
        $icons = array(
                ':slight_frown:'    =>  '',
                ':star_struck:'   =>  '',
                ':small_blue_diamond:'    =>  '&bull;',
                ':boom:'    =>  '&#128481;',
                ':gift:'    =>  '&#128230;',
                ':cry:'    =>  '',
                ':smiling_face_with_3_hearts:'   =>  '',
                ':mans_shoe:'   =>  '',
                ':partying_face:'    =>  ''
        );
		return preg_replace('#\*{2}(.*?)\*{2}#', '<span class="cm-header">$1</span>',nl2br(strtr($text, $icons)));
    }
	
	function spaceToNbsp($text){
		return str_replace(' ', '&nbsp;', $text);
	}
