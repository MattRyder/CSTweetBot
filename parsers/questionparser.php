<?php

/* QUESTION PARSER (questionparser.php)
 * Parses questions passed to it and provokes a valid response.
 * Date: 17 Dec 2011
 */
 
require_once 'mathparser.php';
require_once 'wikiparser.php';
 
class QuestionParser
{
	function parseQuestion($question)
	{
		//Parse it to lower:
		$question = strtolower($question);
		
		//Remove any ending question/exclamation marks passed in the question:
		$question = preg_replace("/[?|!]$/", '', $question);
		
		$qElements = preg_split("/[\s]/", $question, -1, PREG_SPLIT_NO_EMPTY);
		
		if(preg_match("/^w([ho]|[hom])/", $qElements[0]))
		{
			if(preg_match("/^([is]|[are]|[was]|[were])/", $qElements[1]))
			{
				//sentence so far is: "Who is/are"
				//So we're going to try for a reference article!
				for($i=2; $i < count($qElements); ++$i) 
				{ 
					if(strlen($referenceName) == 0) { $referenceName = $qElements[$i]; }
					else $referenceName = $referenceName . '_' . $qElements[$i];
				}
				
				return getWikiArticle($referenceName);
			}
		}
				
		
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
		
		//They're trying to talk to a robot. *sigh*
		if(preg_match("/^h([ello]|[ey]|[i])/", $qElements[0]))
		{
			//Return the token that tells CSTweetBot to send a hello message.
			return "RETURN_GREETING_WITH_NAME";
		}
	}
};