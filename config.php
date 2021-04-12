<?php
	/*
	** API TOKEN
	** Get one here: https://developer.clashroyale.com/
	*/
	const API_TOKEN = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6IjI1MDE2MjhiLTBlYmYtNGJmMS1hMzVmLTU5NmI1YWY2YjEwOSIsImlhdCI6MTYxODI1Njc4MSwic3ViIjoiZGV2ZWxvcGVyL2ZmN2NiMDk1LWIwYmItMGQ3MC0wMzY2LTk1NjMxZTJlNzhmZSIsInNjb3BlcyI6WyJyb3lhbGUiXSwibGltaXRzIjpbeyJ0aWVyIjoiZGV2ZWxvcGVyL3NpbHZlciIsInR5cGUiOiJ0aHJvdHRsaW5nIn0seyJjaWRycyI6WyI5MS41NC4xMjQuMTM2Il0sInR5cGUiOiJjbGllbnQifV19.lBzCMdgf8OndkUnbb5ZWSIHlSqwOX8JC7EXQGIpDipXTfJMe1qQ90lnAsaIW4Cfl5zRwhv9pI_vA1nMH-QtKAA";
	
	/*
	** CLAN MANAGEMENT PARAMETERS
	*/
	
	/* Clan Tag of your clan */
	const CLAN_TAG = "#Y0UVYGRJ"; 
	
	/* Define promotion parameters for your clan: Player is member and must have more than the parameters to be promoted. Set to 0 if you do not want to monitor a parameter.
	   Stict parametere defines if the member has to fullfil both (true) or just one (false) parameter to get a promotion */
	const PROMOTION_WAR_ATTACKS = 12;	
	const PROMOTION_DONATION = 400;
	const PROMOTION_STRICT = true;
	
	/* Define promotion parameters for your clan: Player is elder and must have less than the parameters to be demoted. Set to 0 if you do not want to monitor a parameter.
	   Stict parametere defines if the member has to fullfil both (true) or just one (false) parameter to get a demotion */ 
	const DEMOTION_WAR_ATTACKS = 10;	
	const DEMOTION_DONATION = 300;
	const DEMOTION_STRICT = true;
	
	/* Define kick parameters for your clan: Player is member and must have less than the parameters to be kicked. Set to 0 if you do not want to monitor a parameter.
	   Stict parametere defines if the member has to fullfil both (true) or just one (false) parameter to get a kick */
	const KICK_WAR = 8;
	const KICK_DONATION = 50;
	const KICK_STRICT = true;
	
	/*
	** DISCORD INTEGRATION
	*/
	
	/* Enable or disable Discord integration */
	const DISCORD_ENABLED = false;
	
	/* A password to send the discord message. If empty everyone knowing the script URL can send Discord messages.
	   If a password is set use ?pw=<your password> at the end of the url to access the script.*/
	const DISCORD_PASSWORD = "";
	
	/* Discord Webhook URL.
	   How to get the URL: https://support.discord.com/hc/en-us/articles/228383668-Intro-to-Webhooks */
	const DISCORD_WEBHOOK = "https://discord.com/api/webhooks/831242496080085003/_q_x4XoUUCQxUBaOEBNGn_h-GehGvSX0hbhmGuMW3XTpAySRjYyWqIZNgtiz77_1X6V4";
	
	/* The username of the bot when posting in the channel */
	const BOT_USERNAME = "CR-BOT";
	
	/* Define the days where the bot is allowed to post. Everyday would be: array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun") */
	const DAYS_TO_POST = array("array");
	
	/* Role-ID to mention in Discord. 
	   You get the role-ID by typing \@rolename in Discord. It looks something like <@&404707606725394442> */
	const DISCORD_ROLE_ID = "";
