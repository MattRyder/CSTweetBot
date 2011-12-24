<?php

/* USER REGISTRATION (userregistration.php)
 * Functions for registering and recalling users via MySQL Database
 * Date: 24 Dec 2011
 */

//creates a database reference, if not created.
if(!function_exists("openDatabase"))
{
	function openDatabase()
	{
		include "login/mysql.inc.php";
		$DB_REF = mysql_connect($DB_HOST, $DB_USER, $DB_PASS);
	
		if(!$DB_REF) 
			die("Failed to connect to MySQL DB. <br />Guru Meditation:" . mysql_error());
		else	
			mysql_select_db($DB_NAME, $DB_REF);
	}
}

// Returns a boolean value whether a user is in the database
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

// Registers a user in the database
function registerUser($sn)
{
	$safeSN = mysql_escape_string($sn);
	openDatabase();
	
	$result = mysql_query("INSERT INTO USERS (SCREENNAME) VALUES (\"$safeSN\")") or die(mysql_error());
	echo "Added user: " . $sn;
		
}

// Gets the user's internal Database ID from their Twitter Screenname
function getUserIDFromScreenName($sn)
{
	openDatabase();
	
	$result = mysql_query("SELECT USERID FROM USERS WHERE SCREENNAME = \"$sn\"") or die(mysql_error());
	
	$rows = mysql_fetch_row($result);
	
	if(mysql_num_rows($rows) > 0) die("Failed to get UserID. " . mysql_error());
	else return $rows[0];
}

// Gets the user's Twitter Screenname from a Mention ID
function getScreenNameFromMentionID($mentionid)
{
	openDatabase();
	
	$query = "SELECT USERS.USERID, USERS.SCREENNAME, CONVERSATIONS.MENTIONID 
			  FROM USERS INNER JOIN CONVERSATIONS 
			  ON USERS.USERID = CONVERSATIONS.USERID
			  WHERE CONVERSATIONS.MENTIONID = \"$mentionid\"";
	
	$result = mysql_query($query);
	$rows = mysql_fetch_assoc($result);
	return $rows['SCREENNAME'];
}