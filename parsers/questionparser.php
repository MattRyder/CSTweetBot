<?php

/* QUESTION PARSER (questionparser.php)
 * Parses questions passed to it and provokes a valid response.
 * Date: 17 Dec 2011
 */

/* Parses a given question by exploding and analyzing the string 
 * to generate an appropriate response.
 */ 
include 'mathparser.php';
 
class QuestionParser
{
	function parseQuestion($question)
	{
		//Parse it to lower:
		$question = strtolower($question);
		$qElements = preg_split("/[\s]/", $question, -1, PREG_SPLIT_NO_EMPTY);
		
		//Regex the first word for "who/what/when/where/why"
		if(preg_match("/^wh([at]|[en]|[ere]|[hy])/", $qElements[0]))
		{			
			if($qElements[1] == "is")
			{
				//Can we do math on this question? Regex to find out!
				if(preg_match("/^[0-9]+[\+|\-|*|\/|\\][0-9]+./", $qElements[2]))
				{
					return va_math($qElements[2]);
				}
			}
		}
		
		if(preg_match("/^h([ello]|[ey]|[i])/", $qElements[0]))
		{
			return "RETURN_GREETING_WITH_NAME";
		}
	}
	
	
};