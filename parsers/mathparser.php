<?php

/* MATH PARSER (mathparser.php)
 * Parses basic (for now) math tweeted to it.
 * Date: 17 Dec 2011
 */
 
 
function doOrderOfOperations($va_args, $opChar)
{
	for($i = 0; $i < count($va_args); $i++)
	{
		//Iterate through, do the operation, reinsert into array
		//then normalise the array with array_values:
		if($va_args[$i] == $opChar)
		{
			$l_arg = $va_args[$i-1];
			$r_arg = $va_args[$i+1];
			
			switch($va_args[$i])
		  	{
			  case '+':
				  $va_args[$i] = $l_arg + $r_arg;
				  unset($va_args[$i-1]); unset($va_args[$i+1]);
				  $va_args = array_values($va_args);
				  break;
			  case '-':
				  $va_args[$i] = $l_arg - $r_arg;
				  unset($va_args[$i-1]); unset($va_args[$i+1]);
				  $va_args = array_values($va_args);
				  break;
			  case '*':
				  $va_args[$i] = $l_arg * $r_arg;
				  unset($va_args[$i-1]); unset($va_args[$i+1]);
				  $va_args = array_values($va_args);
				  break;
			  case '/':
				  if($r_arg != 0) { $va_args[$i] = $l_arg / $r_arg; } else break;
				  unset($va_args[$i-1]); unset($va_args[$i+1]);
				  $va_args = array_values($va_args);
				  break;
			  default:
				  break;
		  	}
		}
	}
	
	return $va_args;
}

function va_math($mathstr)
{
	$operators = array('/', '*', '+', '-'); 
	$va_args = preg_split("/([*\/^+-]+)\s*|([\d.]+)\s*/", $mathstr, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
	
	foreach($operators as $operator) 
	{
		$va_args = doOrderOfOperations($va_args, $operator);
	}
	
	return $va_args[0]; //Return the 0'th index, should be the last one in array.
}

?>