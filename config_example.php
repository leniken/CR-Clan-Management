<?php
	/*
	** API TOKEN
	** Get one here: https://developer.clashroyale.com/
	*/
	const API_TOKEN = "";
	
	/*
	** CLAN MANAGEMENT PARAMETERS
	*/
	
	/* Clan Tag of your clan */
	const CLAN_TAG = ""; 
	
	/* Define the minimum level of a member to be considered for clan management. Default is level 6 */
	MIN_LEVEL = 6;
	
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
	const DISCORD_WEBHOOK = "";
	
	/* The username of the bot when posting in the channel */
	const BOT_USERNAME = "";
	
	/* Define the days where the bot is allowed to post. Everyday would be: array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun") */
	const DAYS_TO_POST = array("Sun");
	
	/* Role-ID to mention in Discord. 
	   You get the role-ID by typing \@rolename in Discord. It looks something like <@&404707606725394442> */
	const DISCORD_ROLE_ID = "";