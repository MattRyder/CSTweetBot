<?php

/* QUESTION PARSER (questionparser.php)
 * Parses questions passed to it and provokes a valid response.
 * Date: 17 Dec 2011
 */
 
require_once 'mathparser.php';
require_once 'wikiparser.php';
require_once 'twitter/twitterUtils.php';
 
class QuestionParser
{
	function parseQuestion($question)
	{
		$question = strtolower($question); 						//Parse it to lower
		$question = preg_replace("/[?|!]$/", '', $question); 	//Remove any ending question/exclamation marks passed in the question
		
		$qElements = preg_split("/[\s]/", $question, -1, PREG_SPLIT_NO_EMPTY);
		
		//Regex the first word for "who/what/when/where/why"
		if(preg_match("/^wh([at]|[en]|[ere]|[hy])/", $qElements[0]))
		{
			if($qElements[1] == "is")
			{
				//Can we do math on this question? Regex to find out!
				if(preg_match("/^[0-9]+[\+|\-|*|\/|\\][0-9]+./", $qElements[2]))
				{
					//Get the full string and account for spaces!
					for($i=2; $i < count($qElements); ++$i) 
					{
		  				if(strlen($str) == 0) 
		  					$mathstr = $qElements[$i];
		  				else 
		  					$mathstr = $mathstr . " " . $qElements[$i];
					}
					echo $mathstr;
					return va_math($mathstr);
				}
			}
		}
		
		//They're trying to talk to a robot. *sigh*
		if(preg_match("/^h([ello]|[ey]|[i])/", $qElements[0]))
		{
			//Return the token that tells CSTweetBot to send a hello message.
			return "RETURN_GREETING_WITH_NAME";
		}
		
		if(preg_match("/^w([ho]|[hom])/", $qElements[0]))
		{
			if(preg_match("/^([is]|[are]|[was]|[were])/", $qElements[1]))
			{
				//sentence so far is: "Who is/are"
				//So we're going to try for a reference article!
				$referenceName = NULL;
				$displayName = NULL;
				for($i=2; $i < count($qElements); ++$i) 
				{ 
					if(strlen($referenceName) == 0) { $referenceName = $qElements[$i]; $displayName = ucwords($qElements[$i]); }
					else { $referenceName = $referenceName . '_' . $qElements[$i]; $displayName = $displayName . ' ' . ucwords($qElements[$i]); }
				}
				$wikiResult = "More info for " . $displayName . ": " . getWikiArticle($referenceName);
				return $wikiResult;
			}
		}
	}
};