<?php

/* MATH PARSER (mathparser.php)
 * Parses basic (for now) math tweeted to it.
 * Date: 17 Dec 2011
 */

// Parses basic math in form of: [NUMERIC] [OPERAND] [NUMERIC]
function simplemath($addstr)
{
	list($ai, $op, $bi) = explode(" ", $addstr);
	
	//work the math
	switch($op)
	{
		case '+':
			return $ai + $bi;
		case '-':
			return $ai - $bi;
		case '*':
			return $ai * $bi;
		case '/':
			return $ai / $bi;
	}
}

?>