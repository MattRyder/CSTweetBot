<?php

function openDatabase()
{
	include './login/mysql.inc.php';
	
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
	
	$query = "SELECT * FROM USERS WHERE SCREENNAME = \"" . $safeSN . "\"";
	$result = mysql_query($query);
	
	if(!$result) 
	{
		die("Failed to run sql!" . mysql_error());
	} 
	else 
	{	
		if(mysql_num_rows($result) > 0) 
		{
			return TRUE;
		}
		else return FALSE;
	}
}

function registerUser($sn)
{
	$safeSN = mysql_escape_string($sn);
	
	//Open the database:
	openDatabase();
	
	//Create the SQL query:
	$query = "INSERT INTO USERS (SCREENNAME) VALUES (\"$safeSN\"); ";
	
	$result = mysql_query($query);
	
	if(!$result)
		die("Error adding user: " . mysql_error());
	else
		echo "Added user: " . $sn;
		
}
	
	
	