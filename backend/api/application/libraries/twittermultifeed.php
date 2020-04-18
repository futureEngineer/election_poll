<?php

class twittermultifeed
{
	private $cache_time = "20";
	private $cache_units = "minutes";
	
	private $current_time;

	private $cache_dir = "/system/application/modules/widgets/applications/twitter_multi_feed/cache/";
	
	public function __construct()
	{
		//enable this for IIS underconstruction sites
		define('ci_doc_root', $_SERVER['DOCUMENT_ROOT'].'/irvinelake.net');
		//enable this for localhost sites
		//define('ci_doc_root', 'E:/webserver/inkrefuge/sites/irvinelake.net');
		//enable this for Apache Sites
		
		$this->current_time = date("Y-m-d H:i:s");
	}
	
	public function setCacheTime($cache_time)
	{
		$this->cache_time = $cache_time;
	}
	
	public function setCacheUnits($cache_units)
	{
		$this->cache_units = $cache_units;
	}
	
	public function getTwitterFeeds($screen_name)
	{
		$file_resource = $this->requestFileResource($screen_name);
		
		if($file_resource == null || ($file_resource != null && strtotime("+".$this->cache_time." ".$this->cache_units, filemtime($file_resource)) <= time()))
		{
			$feeds = $this->requestFeedsFromTwitter($screen_name);
			
			$feed_test = json_decode($feeds, true);
			
			if(!isset($feed_test['error']) && $feed_test != null)
			{
				$this->cacheFeeds($screen_name, $feeds);
			}
			else
			{
				if($file_resource != null)
				{
					$feeds = $this->requestFeedsFromLocal($screen_name);
				}
			}
				
			return $feeds;
			//$this->cacheFeeds($screen_name, $feeds);
		}
		else
		{
			$feeds = $this->requestFeedsFromLocal($screen_name);
			return $feeds;
		}
	}
	
	private function cacheFeeds($screen_name, $feed_resource)
	{
		$handler = fopen(ci_doc_root.$this->cache_dir.$screen_name, 'w');
		fwrite($handler, $feed_resource);
		fclose($handler);
	}
	
	private function requestFeedsFromTwitter($screen_name)
	{
		$curl_handler = curl_init();
		curl_setopt($curl_handler, CURLOPT_URL, "http://api.twitter.com/1/statuses/user_timeline.json?screen_name=$screen_name");
		curl_setopt($curl_handler, CURLOPT_POST, 0);
		curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handler, CURLOPT_CONNECTTIMEOUT, 10);
		$response = curl_exec($curl_handler); 
		curl_close($curl_handler); 
		
		if($response)
		{	
			return $response;
		}
		else
		{
			return json_encode(array("status"=>0, "error"=>"An unknown error occurred"));
		}	
	}
	
	private function requestFeedsFromLocal($screen_name)
	{
		
		if(file_exists(ci_doc_root.$this->cache_dir.$screen_name))
		{
			$handler = fopen(ci_doc_root.$this->cache_dir.$screen_name, "r");
			$file;
			while (!feof($handler)) {
			   $file = fgets($handler);
			}
			fclose($handler);
			return $file;
		}
		
		return null;
	}
	
	private function requestFileResource($screen_name)
	{
		if(file_exists(ci_doc_root.$this->cache_dir.$screen_name))
		{
			return ci_doc_root.$this->cache_dir.$screen_name;
		}
		
		return null;
	}
}