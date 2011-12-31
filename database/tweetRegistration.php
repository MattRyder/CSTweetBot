<?php

/* TWEET REGISTRATION (tweetregistration.php)
 * Functions for registering and recalling tweet data via MySQL Database
 * Date: 24 Dec 2011
 */
 
//creates a database reference, if not created.
if(!function_exists("openDatabase"))
{
	function openDatabase()
	{
		include "login/mysql.inc.php";
		$DB_REF = mysql_pconnect($DB_HOST, $DB_USER, $DB_PASS) or die("Failed to connect to MySQL DB:\n" . mysql_error());
		mysql_select_db($DB_NAME, $DB_REF) or die("Failed to connect to MySQL DB:\n" . mysql_error());
	}
}

// Returns a boolean value whether a mention
// is registered in the database
function isMentionRegistered($mentionid) 
{
	openDatabase();
	$result = mysql_query("SELECT * FROM CONVERSATIONS WHERE MENTIONID = \"$mentionid\"") or die(mysql_error());

	if(mysql_num_rows($result) > 0) 
	{
		return TRUE;
	}
	else return FALSE;
}

// Returns a boolean value whether a mention has
// been given a reply over Twitter
function hasResponse($mentionid)
{
	$result = mysql_query("SELECT REPLYID FROM CONVERSATIONS WHERE MENTIONID = \"$mentionid\"") or die(mysql_error());
  
	if(mysql_num_rows($result) > 0) 
	{
		return TRUE;
	}
	else return FALSE;
}

// Registers a mention in the database
function registerMention($screenName, $mentionid)
{
	openDatabase();
	
	$userid = getUserIDFromScreenName($screenName);
	$result = mysql_query("INSERT INTO CONVERSATIONS (USERID, MENTIONID) VALUES (\"$userid\", \"$mentionid\")") or die(mysql_error());
}

//Registers a response in the database
function registerResponse($mentionid, $replyid)
{
	$result = mysql_query("UPDATE CONVERSATIONS SET REPLYID = \"$replyid\" WHERE MENTIONID = \"$mentionid\"") or die(mysql_error());
}	