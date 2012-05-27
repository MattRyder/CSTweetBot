<?php

/* TWEET ANSWER (tweetanswer.php)
 * Formats and responds to tweets, then registers it in the Database
 * Date: 22 Dec 2011
 */
require_once "twitter/tmhOAuth.php";
require_once "twitter/tmhUtilities.php";
require_once "database/userRegistration.php";

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
	$screenname = getScreenNameFromMentionID($mentionid);
	$tweet = "@" . $screenname . " A: " . $tweet;
	print_r($tweet);
	
	$code = $oAuthTokens->request('POST', $oAuthTokens->url('1/statuses/update'), array('status' => $tweet,'in_reply_to_status_id' => $mentionid));
	$response = json_decode($oAuthTokens->response['response']);
	
	if($code == 200)
	{
		//success!
		$responseid = $response->id_str;
		registerResponse($mentionid, $responseid);
	}	
}
?>