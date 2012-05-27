<?php

/* BASE PARSER (baseparser.php)
 * Base parse object as parent for any parser plugin
 * Date: 29 Jan 2012
 */
 
abstract class BaseParser
{
	public abstract function parse($args);
}

?>