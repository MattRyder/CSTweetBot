<?php

/* WIKIPEDIA (AND OTHER WIKI) PARSER (wikiparser.php)
 * Looks up a reference article from wikipedia
 * Date: 26 Dec 2011
 */
 
//Gets a wiki reference article, defaults to "Wikipedia"
function getWikiArticle($refName)
{
	$url = "http://www.wikipedia.org/w/api.php?action=query&redirects&format=json&titles=" . $refName;
	
	$wikires = get_data($url);
	$url_response = json_decode($wikires);

	foreach($url_response->query->pages as $item => $val) { $pageid = $item; break; }
	
	if($pageid > 0)
	{
		$url = "http://en.wikipedia.org/w/api.php?action=query&redirects&format=json&prop=info&pageids=$pageid&inprop=url";
		$pageJSON = get_data($url);
		$pageJSON = json_decode($pageJSON);
		$pageURL = $pageJSON->query->pages->$pageid->fullurl;
		return $pageURL;
	}
	else return NULL;
}

//Gets a wiki reference article from the given Wiki site
//Examples: WIkia, MediaWiki, Encyclopedia Dramatica
function getAltWikiArticle($wikiAddress)
{
	
}

function get_data($url)
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
?>