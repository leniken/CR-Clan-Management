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
	
	/* Define the minimum level of a member to be considered for clan management. Default is level 6. Set to 0 to ignore this option. */
	const MIN_LEVEL = 7;
	
	/* Co management 
	*  Set DO_CO_MANAGEMENT to true, to list promotions and demotions for co-leaders. 
	*  Set LIST_CO_STATS to true to have a separate list of the co-leaders performance.
	*/
	const DO_coLeader_MANAGEMENT = false;
	const LIST_coLeader_STATS = true;
	const coLeader_MONITOR_WAR_ATTACKS = true;
	const coLeader_MONITOR_DONATIONS = true;
	
	/* Define promotion parameters for your clan: Player is elder and must have more than the parameters to be promoted.
	   Stict parametere defines if the elder has to fullfil both (true) or just one (false) parameter to get a promotion */
	const coLeader_PROMOTION_WAR_ATTACKS = 12;	
	const coLeader_PROMOTION_DONATION = 500;
	const coLeader_PROMOTION_STRICT = true;
	
	/* Define demotion parameters for your clan: Player is co and must have less than the parameters to be demoted. 
	   Stict parametere defines if the co has to fullfil both (true) or just one (false) parameter to get a demotion */ 
	const coLeader_DEMOTION_WAR_ATTACKS = 12;	
	const coLeader_DEMOTION_DONATION = 400;
	const coLeader_DEMOTION_STRICT = true;
	
	/* Elder management
	*  Set DO_ELDER_MANAGEMENT to true, to list promotions and demotions for elders. 
	*/
	const DO_elder_MANAGEMENT = true;
	const elder_MONITOR_WAR_ATTACKS = true;
	const elder_MONITOR_DONATIONS = true;
	
	/* Define promotion parameters for your clan: Player is member and must have more than the parameters to be promoted.
	   Stict parametere defines if the member has to fullfil both (true) or just one (false) parameter to get a promotion */
	const elder_PROMOTION_WAR_ATTACKS = 8;	
	const elder_PROMOTION_DONATION = 300;
	const elder_PROMOTION_STRICT = true;
	
	/* Define demotion parameters for your clan: Player is elder and must have less than the parameters to be demoted. 
	   Stict parametere defines if the elder has to fullfil both (true) or just one (false) parameter to get a demotion */ 
	const elder_DEMOTION_WAR_ATTACKS = 8;	
	const elder_DEMOTION_DONATION = 200;
	const elder_DEMOTION_STRICT = true;
	
	/* member management
	*  Set DO_MEMBER_MANAGEMENT to true, to list kicks for members that didn't fulfill the defined attack and donations values. 
	*/
	const DO_member_MANAGEMENT = true;
	const member_MONITOR_WAR_ATTACKS = true;
	const member_MONITOR_DONATIONS = true;
	
	/* Define kick parameters for your clan: Player is member and must have less than the parameters to be kicked.
	   Stict parametere defines if the member has to fullfil both (true) or just one (false) parameter to get a kick */
	const member_DEMOTION_WAR = 8;
	const member_DEMOTION_DONATION = 50;
	const member_DEMOTION_STRICT = true;
	
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