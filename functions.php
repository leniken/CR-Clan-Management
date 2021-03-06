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
		foreach($clan['memberList'] as $member){
			$statArray[$member["name"]] = array("donations" => $member["donations"], "role" => $member["role"]);
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
		$statArray[$player["name"]]["battlecount"] = $player["decksUsed"];
		}
		
		/*
		** Geneate clan management data
		*/
		$promotion = [];
		$demotion = [];
		$kick = [];
		foreach ($statArray as $name => $data){
			if(PROMOTION_STRICT){
				if($data["battlecount"] >= PROMOTION_WAR_ATTACKS && $data["donations"] >= PROMOTION_DONATION && $data["role"] == "member"){
					$promotion[$name] = array($data["battlecount"], $data["donations"]);
				}
			} else {
				if(($data["battlecount"] >= PROMOTION_WAR_ATTACKS || $data["donations"] >= PROMOTION_DONATION) && $data["role"] == "member"){
					$promotion[$name] = array($data["battlecount"], $data["donations"]);
				}
			}
			
			if(DEMOTION_STRICT){
				if($data["battlecount"] < DEMOTION_WAR_ATTACKS && $data["donations"] < DEMOTION_DONATION && $data["role"] == "elder"){
					$demotion[$name] = array($data["battlecount"], $data["donations"]);
				}
			} else {
				if(($data["battlecount"] < DEMOTION_WAR_ATTACKS || $data["donations"] < DEMOTION_DONATION) && $data["role"] == "elder"){
				$demotion[$name] = array($data["battlecount"], $data["donations"]);
				}
			}
			
			if(KICK_STRICT){
				if($data["battlecount"] < KICK_WAR && $data["donations"] < KICK_DONATION && $data["role"] == "member"){
					$kick[$name] = array($data["battlecount"], $data["donations"]);
				}
			} else {
				if(($data["battlecount"] < KICK_WAR || $data["donations"] < KICK_DONATION) && $data["role"] == "member"){
					$kick[$name] = array($data["battlecount"], $data["donations"]);
				}
			}
			
		}

	
		$return = [];
		$return[] = $promotion;
		$return[] = $demotion;
		$return[] = $kick;
		
		return $return;
	}

	function createMessage($clanManagement, $plain){
		
		$header	= "It's time for clan management. Here are the proposals of this week ". DISCORD_ROLE_ID ."\r\n\r\n";
		
		if($plain){
			$promoHead =  "** Promotion:\r\n";
		} else {
			$promoHead =  "**Promotion :star_struck:**\r\n";
		}
		if(sizeof($clanManagement[0]) == 0){
			if($plain){
				$promoContent =  "  none\r\n";
			} else {
				$promoContent =  "  none :slight_frown:\r\n";
			}
		} else {
			$promoContent = "";
			foreach($clanManagement[0] as $name=>$data){
				if($plain){
					$promoContent .=  "  ".$name." - Attacks: ".$data[0]." - Donations: ".$data[1]."\r\n";
				} else {
					$promoContent .=  "  :small_blue_diamond: ".$name." :boom: ".$data[0]." :gift: ".$data[1]."\r\n";
				}
			}
		}
		
		if($plain){
			$demoHead =  "** Demotion:\r\n";
		} else {
			$demoHead =  "**Demotion :cry:**\r\n";
		}
		if(sizeof($clanManagement[1]) == 0){
			if($plain){
				$demoContent =  "  none\r\n";
			} else {
				$demoContent =  "  none :smiling_face_with_3_hearts:\r\n";
			}
		} else {
			$demoContent = "";
			foreach($clanManagement[1] as $name=>$data){
				if($plain){
					$demoContent .=  "  ".$name." - Attacks: ".$data[0]." - Donations: ".$data[1]."\r\n";
				} else {
					$demoContent .=  "  :small_blue_diamond: ".$name." :boom: ".$data[0]." :gift: ".$data[1]."\r\n";
				}
			}
		}
		
		if($plain){
			$kickHead =  "** Kick:\r\n";
		} else {
			$kickHead =  "**Kick :mans_shoe:**\r\n";
		}
		if(sizeof($clanManagement[2]) == 0){
			if($plain){
				$kickContent =  "  none\r\n";
			} else {
				$kickContent =  "  none :partying_face:\r\n";
			}
		} else {
			$kickContent = "";
			foreach($clanManagement[2] as $name=>$data){
				if($plain){
					$kickContent .=  "  ".$name." - Attacks: ".$data[0]." - Donations: ".$data[1]."\r\n";
				} else {
					$kickContent .=  "  :small_blue_diamond: ".$name." :boom: ".$data[0]." :gift: ".$data[1]."\r\n";
				}
			}
		}
		
		
		return array($header, $promoHead, $promoContent, $demoHead, $demoContent, $kickHead, $kickContent);
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