<?php

/* QUESTION PARSER (questionparser.php)
 * Parses questions passed to it and provokes a valid response.
 * Date: 17 Dec 2011
 */

/* Parses a given question by exploding and analyzing the string 
 * to generate an appropriate response.
 */ 
 
class QuestionParser
{
	function parseQuestion($question)
	{
		//Parse it to lower:
		$question = strtolower($question);
		$qElements = explode($question);
		
		if($qElements[0] == "what")
		{
			//It's a question, singular or plural?
			
			if($qElements[1] == "is")
			{
				
			}
			
		}
	}
};