<?php

class NightlifeUser
{
	public $performLinkTest = false;
	
	public function __construct()
	{
		$this->loadSessionData();
		
		$CI =& get_instance();
		
		$controller_uri = $CI->uri->segment(1);
		
		if(strstr(current_url(), ".png"))
		{
			echo "browser listed png as a page";
			die;
		}
		
		$black_listed = array('login', 'logout', 'sign-me-up', 'forgot-password', 'widgets');
		$black_listed_url = array('/photos/album', '/tickets/ajaxInsertTicketImpression', '/tickets/sendTicket');
		
		$array_part = str_replace(site_url(), '', current_url());
		//echo "array part is ".$array_part;
		
		if(!in_array($controller_uri, $black_listed) && !in_array($array_part, $black_listed_url))
		{
			$this->setLinkRequest(current_url());
			//$this->addLinkSet(current_url());
		}
	}
	
	public function loadSessionData()
	{
		if(!isset($_SESSION))
			session_start();
		
		//$_SESSION['link_test'] = array();
	}
	
	public function isLoggedIn()
	{
		if($this->getUser() != null)
			return true;
			
		return false;
	}
	
	public function getUser()
	{
		if(isset($_SESSION['account']))
			return $_SESSION['account'];
		return null;
	}
	
	public function setUser($account)
	{
		$_SESSION['account'] = $account;
	}
	
	public function clearUser()
	{
		$_SESSION['account'] = null;
	}
	
	public function setLinkRequest($request)
	{
		$_SESSION['link_request'] = $request;
	}
	
	public function getLinkRequest()
	{
		if(isset($_SESSION['link_request']))
			return $_SESSION['link_request'];
		return null;
	}
	
	public function addLinkSet($link)
	{
		$_SESSION['link_test'][] = $link;
	}
	
	public function getLinkSet()
	{
		return $_SESSION['link_test'];
	}
	
	public function clearLinkRequest()
	{
		$_SESSION['link_request'] = null;
	}
	
	public function flashLinkRequest()
	{
		$request = $this->getLinkRequest();
		$this->clearLinkRequest();
	}
}