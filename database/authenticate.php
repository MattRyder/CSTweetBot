<?php

require_once "twitter/tmhOAuth.php";
require_once "twitter/tmhUtilities.php";
require_once "userRegistration.php";

function getMentions() 
{
	require_once "login/twitter.inc.php";
	
	$oAuthTokens = new tmhOAuth(array(
	'consumer_key'    => $csConsumerKey,
	'consumer_secret' => $csConsumerSec,
	'user_token'		=> $csUserToken,
	'user_secret'		=> $csUserSecret,
  ));
  
  $method = $oAuthTokens->url('statuses/mentions.json?include_entities=true&count=100');
  
  $oAuthTokens->request('GET', $method);
  
  $raw_data = json_decode($oAuthTokens->response['response']);
  return $raw_data;
}

function tryRegisterUser($screenname)
{ 
  if(!isUserRegistered($screenname)) 
  {
	  registerUser($screenname);
  }
}

?>