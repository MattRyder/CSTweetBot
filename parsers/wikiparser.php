<?php

/* WIKIPEDIA (AND OTHER WIKI) PARSER (wikiparser.php)
 * Looks up a reference article from wikipedia
 * Date: 26 Dec 2011
 */
 
//Gets a wiki reference article, defaults to "Wikipedia"

include_once('baseparser.php');
 
class WikiParser extends BaseParser
{
	function parse($qElements)
	{
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
					$wikiResult = "More info for " . $displayName . ": " . $this->getWikiArticle($referenceName);
					return $wikiResult;
				}
			}
	}
		
	private function getWikiArticle($refName)
	{
		$url = "http://www.wikipedia.org/w/api.php?action=query&redirects&format=json&titles=" . $refName;
		
		$wikires = $this->get_data($url);
		$url_response = json_decode($wikires);
	
		foreach($url_response->query->pages as $item => $val) { $pageid = $item; break; }
		
		if($pageid > 0)
		{
			$url = "http://en.wikipedia.org/w/api.php?action=query&redirects&format=json&prop=info&pageids=$pageid&inprop=url";
			$pageJSON = $this->get_data($url);
			$pageJSON = json_decode($pageJSON);
			$pageURL = $pageJSON->query->pages->$pageid->fullurl;
			return $pageURL;
		}
		else return NULL;
	}
	
	//Gets a wiki reference article from the given Wiki site
	//Examples: WIkia, MediaWiki, Encyclopedia Dramatica
	private function getAltWikiArticle($wikiAddress)
	{
		
	}
	
	private function get_data($url)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_NOBODY, FALSE);
		curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
		curl_setopt($ch, CURLOPT_REFERER, "");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, "CSTweetBot/0.0.0.1 [http://www.github.com/MattRyder/CSTweetBot]");
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}
?>