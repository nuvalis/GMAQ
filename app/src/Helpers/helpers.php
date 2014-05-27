<?php

namespace nuvalis\Helpers;

class Helpers
{

	function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	    $url = 'http://www.gravatar.com/avatar/';
	    $url .= md5( strtolower( trim( $email ) ) );
	    $url .= "?s=$s&d=$d&r=$r";
	    if ( $img ) {
	        $url = '<img src="' . $url . '"';
	        foreach ( $atts as $key => $val )
	            $url .= ' ' . $key . '="' . $val . '"';
	        $url .= ' />';
	    }
	    return $url;
	}

	function truncate($text, $chars = 250)
  	{
      $text = $text." ";
      $text = substr($text,0,$chars);
      $text = substr($text,0,strrpos($text,' '));
      
      if(strlen($text) === $chars){
      	$text = $text."...";
      }
      
      return $text;
  	}

  	function now()
  	{
  		return date("Y-m-d H:i:s");
  	}

}