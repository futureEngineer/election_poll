<?php

class StringLib
{
	public function __construct()
	{
		
	}
	
	public function substring($string, $start, $length, $addDots = true)
	{
		$n_string = substr($string, 0, $length);
		
		if($addDots)
			if(strlen($n_string) < strlen($string))
				$n_string.= "...";
		
		return $n_string;
	}
}