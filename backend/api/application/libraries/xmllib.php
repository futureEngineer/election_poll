<?php

/*************************************************************************
/* XML LIB
/*
/* Written by Cary Buchmann. (cjbuchmann)
/*
/* Created March 31, 2011
/************************************************************************/

class XMLLib
{
	
	private $rawXML;
	private $arrayXML;
	
	
	private $showErrors = true;
	
	private $fileErrors;
	
	public function __construct()
	{
		$this->fileErrors = array();
	}
	
	public function xmlRequest($url)
	{
		if($this->isValidFile($url))
		{
			$xml_request = $this->getCurlRequest($url);
			
			if($xml_request)
			{
				$xml = simplexml_load_string($xml_request);
			
				return $xml;
			}
			else
			{
				$this->addError("Error retrieving File.");
			}
		}
		
		//setup for debugging
		if($this->showErrors)
		{
			$this->printErrors();
		}
	}
	
/*************************************************************************
/* CURL REQUESTS
/************************************************************************/
	private function getCurlRequest($url)
	{
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		$request = curl_exec($curl);
		
		if(!$request)
			return null;
		
		return $request; 
	}
	
/*************************************************************************
/* ERROR HANDLING
/************************************************************************/
	
	private function isValidFile($file)
	{
		$isCorrupt = false;
		
		if(strlen($file) <= 0)
		{
			$this->addError($this->getErrorMessage('NO_FILE_SPECIFIED'));
			$isCorrupt = true;
		}
			
		if($isCorrupt)
			return false;
		return true;
	}
	
	private function addError($message)
	{
		$this->fileErrors[] = $message;
	}
	
	private function getErrors()
	{
		return $this->fileErrors;
	}
	
	private function hasErrors()
	{
		if(count($this->fileErrors) > 0)
			return true;
		return false;	
	}
	
	private function printErrors($pre_tag = '<div id = \'xml_errors\'>', $post_tag = '</div>')
	{
		if($this->hasErrors())
		{
			$errors = $this->getErrors();
			
			foreach($errors as $error)
				echo $pre_tag.$error.$post_tag;
		}
	}
	
	private function getErrorMessage($name)
	{
		$errors = array();
		$error['NO_FILE_SPECIFIED'] = "Error Opening File. Please specify a file.";
		$error['FILE_DOES_NOT_EXIST'] = "Error Opening File. The file specified does not exist.";
		$error['DEFAULT_ERROR'] = "An Error Occurred.";
		
		if(isset($error[$name]))
			return $error[$name];
		return null;
	}
}