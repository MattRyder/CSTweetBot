<?php
error_reporting(E_ALL);


require './twitter/tmhOAuth.php';
require './twitter/tmhUtilities.php';
require 'reguser.php';

include './login/twitter.inc.php';

$oAuthTokens = new tmhOAuth(array(
  'consumer_key'    => $csConsumerKey,
  'consumer_secret' => $csConsumerSec,
  'user_token'		=> $csUserToken,
  'user_secret'		=> $csUserSecret,
));

$method = $oAuthTokens->url('statuses/mentions.json?include_entities=true&count=100');

$oAuthTokens->request('GET', $method);

$raw_data = json_decode($oAuthTokens->response['response']);

foreach ($raw_data as $item)
{
	echo "Username: "   . $item->user->screen_name . "<br />";
	echo "Name:     "   . $item->user->name . "<br />";
	echo "Tweeted:  "   . $item->text . "<br />";
	echo "Tweet URL: <a href=\"http://twitter.com/#!/CSTweetBot/status/" . $item->id_str . "\">Open Twitter</a><br />";
}

//is the user in the database?
$screenname = $item->user->screen_name;
$isReg = isUserRegistered($screenname);

if(!$isReg) {
	echo $screenname . " not registered. <br />";
	registerUser($screenname);
} else
	echo $screenname . " is already registered. <br />";

?>