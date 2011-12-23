<?php

function openDatabase()
{
	include "login/mysql.inc.php";
	$DB_REF = mysql_connect($DB_HOST, $DB_USER, $DB_PASS);
	
	if(!$DB_REF) 
		die("Failed to connect to MySQL DB. <br />Guru Meditation:<br />" . mysql_error());
	else	
		mysql_select_db($DB_NAME, $DB_REF);
}
	

function isUserRegistered($screenname)
{
	openDatabase();
	
	$safeSN = mysql_escape_string($screenname);
	
	$query = "SELECT * FROM USERS WHERE SCREENNAME = \"$safeSN\"; ";
	$result = mysql_query($query) or die(mysql_error());
	
	if(mysql_num_rows($result) > 0) 
	{
		return TRUE;
	} 
	else return FALSE;
}


function registerUser($sn)
{
	$safeSN = mysql_escape_string($sn);
	openDatabase();
	
	//Create the SQL query:
	$result = mysql_query("INSERT INTO USERS (SCREENNAME) VALUES (\"$safeSN\")") or die(mysql_error());
	echo "Added user: " . $sn;
		
}

function getUserIDFromScreenName($sn)
{
	openDatabase();
	
	$result = mysql_query("SELECT USERID FROM USERS WHERE SCREENNAME = \"$sn\"") or die(mysql_error());
	
	$rows = mysql_fetch_row($result);
	
	if(mysql_num_rows($rows) > 0) die("Failed to get UserID. " . mysql_error());
	else return $rows[0];
}

function getScreenNameFromMentionID($mentionid)
{
	openDatabase();
	
	//Get UserID for that mention:
	$result = mysql_query("SELECT USERID FROM CONVERSATIONS WHERE MENTIONID = \"$mentionid\"") or die(mysql_error());
	$result = mysql_fetch_row($result);
	
	$result = mysql_query("SELECT SCREENNAME FROM USERS WHERE USERID = \"$uid\"") or die(mysql_error());

	$rows = mysql_fetch_row($result);
	print_r($rows[0]);
	
	if(mysql_num_rows($rows) > 0) die("Failed to get ScreenName. " . mysql_error());
	else return $screenname;
}
	

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

function hasResponse($mentionid)
{
	$result = mysql_query("SELECT REPLYID FROM CONVERSATIONS WHERE MENTIONID = \"$mentionid\"") or die(mysql_error());
  
	if(mysql_num_rows($result) > 0) 
	{
		return TRUE;
	}
	else return FALSE;
}

function registerMention($screenName, $mentionid)
{
	openDatabase();
	
	//Register it as a conversation:
	$userid = getUserIDFromScreenName($screenName);
	$result = mysql_query("INSERT INTO CONVERSATIONS (USERID, MENTIONID) VALUES (\"$userid\", \"$mentionid\")") or die(mysql_error());
}

function registerResponse($mentionid, $replyid)
{
	$result = mysql_query("UPDATE CONVERSATIONS SET REPLYID = \"$replyid\" WHERE MENTIONID = \"$mentionid\"") or die(mysql_error());
}
	
	
	