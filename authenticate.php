<?php
error_reporting(E_ALL);


require './twitter/tmhOAuth.php';
require './twitter/tmhUtilities.php';
require 'reguser.php';

$oAuthTokens = new tmhOAuth(array(
  'consumer_key'    => 'Uts0w9RUdLDiEv0p12tEg',
  'consumer_secret' => 'exmzMoayDhSQ9WgL9aoYrdhVnq48OZkzRTQCRQ52is',
  'user_token'		=> '436274628-iLI6nj8LPNF5BOXDt6rNtVwtKA36miFRA47fB8EH',
  'user_secret'		=> 'uLg0R2nQeTfG80CG7qqgJQEmvNZv3vNhP9Z3eBIX9M'
));

$method = $oAuthTokens->url('statuses/mentions.json?include_entities=true&count=2');

$oAuthTokens->request('GET', $method);

$raw_data = json_decode($oAuthTokens->response['response']);

foreach ($raw_data as $item)
{
	echo "Username: " . $item->user->screen_name . "<br />";
	echo "Name:     " . $item->user->name . "<br />";
	echo "Tweeted:  " . $item->text . "<br /><br />";
}

//is the user in the database?
$screenname = $item->user->screen_name;
$isReg = isUserRegistered($screenname);

if(!$isReg) {
	echo $screenname . " not registered. <br />";
	registerUser($screenname);
}