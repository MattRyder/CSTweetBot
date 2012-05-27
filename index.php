<?php
error_reporting(E_ALL); //DISABLE WHEN IN PRODUCTION

include_once 'botmeta.php'; //Load TweetBot Metadata

require_once 'database/authenticate.php';
require_once 'parsers/questionparser.php';
require_once 'twitter/tweetAnswer.php';
require_once 'database/userRegistration.php';
require_once 'database/tweetRegistration.php';

//Setup Database & Grep Mentions:
$mentions = getMentions();
//parseMentions($mentions);

$qp = new QuestionParser();
$answer = $qp->parse("Who is Goku?");

echo "Final Output: " . $answer. "\n";


function parseMentions($mentions)
{
	foreach($mentions as $mention)
	{
		$mentionid = $mention->id_str;
		if(!isMentionRegistered($mentionid))
		{
			//Register the user:
			tryRegisterUser($mention->user->screen_name);
			$tweet = stripMentionText($mention->text);
			
			//Register the question in the database:
			registerMention($mention->user->screen_name, $mentionid);
			
			//Parse the Question and get an answer:
			$qp = new QuestionParser();
			$answer = $qp->parse($tweet);
			
			if($answer == "RETURN_GREETING_WITH_NAME") { $answer = "Hey there, " . $mention->user->name; }
			
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