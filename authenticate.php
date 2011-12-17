<?php

require './twitter/tmhOAuth.php';
require './twitter/tmhUtilities.php';
require 'reguser.php';

include './login/twitter.inc.php';

function authenticateAndGetMentions() 
{
  $oAuthTokens = new tmhOAuth(array(
	'consumer_key'    => $csConsumerKey,
	'consumer_secret' => $csConsumerSec,
	'user_token'		=> $csUserToken,
	'user_secret'		=> $csUserSecret,
  ));
  
  $method = $oAuthTokens->url('statuses/mentions.json?include_entities=true&count=100');
  
  $oAuthTokens->request('GET', $method);
  
  $raw_data = json_decode($oAuthTokens->response['response']);
  
  //DEBUG:
  foreach ($raw_data as $item)
  {
	  echo "Username: "   . $item->user->screen_name . "<br />";
	  echo "Name:     "   . $item->user->name . "<br />";
	  echo "Tweeted:  "   . $item->text . "<br />";
	  echo "Tweet URL: <a href=\"http://twitter.com/#!/CSTweetBot/status/" . $item->id_str . "\">Open Twitter</a><br />";
  }
  
  // Register Tweeters in Database:
  $screenname = $item->user->screen_name;
  
  if(!isUserRegistered($screenname)) {
	  echo $screenname . " not registered. <br />";
	  registerUser($screenname);
  } else
	  echo $screenname . " is already registered. <br />";
}

?>