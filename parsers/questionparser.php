<?php

/* QUESTION PARSER (questionparser.php)
 * Parses questions passed to it and provokes a valid response.
 * Date: 17 Dec 2011
 */
 
require_once 'twitter/twitterUtils.php';
require_once 'baseparser.php';
include_once 'mathparser.php';
include_once 'wikiparser.php';
 
class QuestionParser extends BaseParser
{
	function parse($question)
	{
		$answer = NULL;
		$question = strtolower($question); 						//Parse it to lower
		$question = preg_replace("/[?|!]$/", '', $question); 	//Remove any ending question/exclamation marks passed in the question
		
		$qElements = preg_split("/[\s]/", $question, -1, PREG_SPLIT_NO_EMPTY);
		
		$wikiparser = new WikiParser($qElements);
		if(($answer = $wikiparser->parse($qElements)) != NULL) return $answer;
	}
};