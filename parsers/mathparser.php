<?php

/* MATH PARSER (mathparser.php)
 * Parses basic (for now) math tweeted to it.
 * Date: 17 Dec 2011
 */
 
 include_once('baseparser.php');
 
 class MathParser extends BaseParser
 {
	 private function doOrderOfOperations($va_args, $opChar)
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
	  
	 function parse($qElements)
	 {
		 $mathstr = NULL;
		 $operators = array('/', '*', '+', '-'); 
		 $va_args = preg_split("/([*\/^+-]+)\s*|([\d.]+)\s*/", $mathstr, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
		 
		 //Regex the first word for "who/what/when/where/why"
		if(preg_match("/^wh([at]|[en]|[ere]|[hy])/", $qElements[0]))
		{
			if($qElements[1] == "is")
			{
				//Can we do math on this question? Regex to find out!
				if(preg_match("/^[0-9]+[\+|\-|*|\/|\\][0-9]+/", $qElements[2]))
				{
					//Get the full string and account for spaces!
					for($i=2; $i < count($qElements); ++$i) 
					{
		  				if(strlen($mathstr) == 0)
		  					$mathstr = $qElements[$i];
		  				else 
		  					$mathstr = $mathstr . " " . $qElements[$i];
					}
					
					//And do the math, iterating through each operation:
					foreach($operators as $operator) 
		  			{
			  			$mathstr = $this->doOrderOfOperations($mathstr, $operator);
						
		  			}
					
					return $mathstr;
				}
			}
		}
	 }
 }
?>