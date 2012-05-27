<?php

/* BOT TALK PARSER (bottalkparser.php)
 * Parses tweets referenced to the bot itself (e.g. "Hi, how are you today?", or "Who is your creator?")
 * Date: 09 March 2012
 */
 
 include_once('baseparser.php');
 
 class BotTalkParser extends BaseParser
 {
	 function parse($qElements)
	 {
		if(preg_match("/^h([ello]|[ey]|[i])/", $qElements[0]))
		{
			//Return the token that tells CSTweetBot to send a personal hello message.
			return "RETURN_GREETING_WITH_NAME";
		}		
	 }
 }