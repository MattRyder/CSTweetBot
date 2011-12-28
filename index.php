<?php

require_once 'database/authenticate.php';
require_once 'parsers/questionparser.php';
require_once 'twitter/tweetAnswer.php';
require_once "database/userRegistration.php";
require_once "database/tweetRegistration.php";

//Setup Database & Grep Mentions:
$mentions = getMentions();
parseMentions($mentions);

function parseMentions($mentions)
{
	//Setup error reporting:
	error_reporting(E_ALL);
	echo "<a href=\"https://github.com/MattRyder/CSTweetBot\">Tweetbot v0.0.0.2</a>";
	
	foreach($mentions as $mention)
	{
		$mentionid = $mention->id_str;
		if(!isMentionRegistered($mentionid))
		{
			/*Keep this for debug purposes, it's pretty handy!
			echo "<br /><br /> Username: " . $mention->user->screen_name . "<br />\n";
			echo "     Name: " . $mention->user->name . "<br />\n";
			echo "  Tweeted: " . $mention->text . "<br />\n";
			echo "Tweet URL: <a href=\"http://twitter.com/#!/CSTweetBot/status/" . $mention->id_str . "\">Open Twitter</a>\n";
			*/ 
					
			//Register the user:
			tryRegisterUser($mention->user->screen_name);
			$tweet = stripMentionText($mention->text);
			
			//Register the question in the database
			registerMention($mention->user->screen_name, $mentionid);
			
			//Parse the Question and get an answer:
			$qp = new QuestionParser();
			$answer = $qp->parseQuestion($tweet);
			
			if($answer == "RETURN_GREETING_WITH_NAME") { $answer = "Hey there, " . $mention->user->name; }
			
			//Tweet the answer to the user and register the response:
			echo "Mention ID: $mentionid, Answer: $answer";
			postReply($mentionid, $answer);
			
		}
	}
}

//Strips the @ScreenName from a tweet
function stripMentionText($tweet)
{
	return preg_replace("/^[@][A-Za-z0-9]+/", "", $tweet);
}

?>