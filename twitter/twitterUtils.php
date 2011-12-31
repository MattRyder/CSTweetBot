<?php

/**
*
* twitterStatusUrlConverter
*
* To convert links on a twitter status to a clickable url. Also convert @ to follow link, and # to search
*
* @author: Mardix - http://mardix.wordpress.com, http://www.givemebeats.net
* @date: March 16 2009
* @license: LGPL (I don't care, it's free lol)
*
* @param string : the status
* @param bool : true|false, allow target _blank
* @param int : to truncate a link to max length
* @return String
*
* */
function twitterStatusUrlConverter($status,$targetBlank=true,$linkMaxLen=250){
  
  // The target
  $target=$targetBlank ? " target=\"_blank\" " : "";

    // convert link to url
    $status = preg_replace("/((http:\/\/|https:\/\/)[^ )
]+)/e", "'<a href=\"$1\" title=\"$1\"  $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);

    // convert @ to follow
    $status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);

    // convert # to search
    $status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"http://search.twitter.com/search?q=%23$2\" title=\"Search $1\" $target >$1</a>",$status);

    // return the status
    return $status;
}

?>