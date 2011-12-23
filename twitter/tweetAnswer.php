<?

/* TWEET ANSWER (tweetanswer.php)
 * Formats and responds to tweets, then registers it in the Database
 * Date: 22 Dec 2011
 */
require_once "twitter/tmhOAuth.php";
require_once "twitter/tmhUtilities.php";
require_once "database/reguser.php";

function verifyCharLimit($tweet)
{
	
}

function postReply($mentionid, $tweet)
{
	include "login/twitter.inc.php";
	$oAuthTokens = new tmhOAuth(array(
	'consumer_key'    => $csConsumerKey,
	'consumer_secret' => $csConsumerSec,
	'user_token'		=> $csUserToken,
	'user_secret'		=> $csUserSecret,
	));
	
	//Set the Mention!
	$foo = getScreenNameFromMentionID($mentionid);
	echo $foo;
	echo "Why am I not being hit?";
	
	$code = $oAuthTokens->request('POST', $oAuthTokens->url('1/statuses/update'), array('status' => $tweet));
	
	if($code == 200)
	{
		//success!
		tmhUtilities::pr(json_decode($oAuthTokens->response['response']));
		registerResponse($mentionid, $responseid);
	}	
}