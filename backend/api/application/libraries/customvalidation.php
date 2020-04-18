<?php
/*******************************************************************************
 *
 * Written By CJ Buchmann
 * August 20, 2010
 *
 * The CustomValidation Library is used to validate (boolean checks) Get and
 * Post requests.
 ******************************************************************************
 |
 ******************************************************************************/
class CustomValidation
{
    
    var $errors;
	var $warnings;
	var $successMessages;
    
    public function __construct()
    {
        $this->errors = array();
    }
    
    //the simplest validation funciton
    public function validate($condition, $message)
    {
        if(!$condition)
            $this->addError($message);
    }
	
	public function validateNot($condition, $message)
	{
		if($condition)
			$this->addError($message);
	}
    
    public function validateNotEmpty($value, $name)
    {
        $this->validate(isset($value) && strlen($value) > 0, "The $name cannot be blank.");
    }
				
	public function validateEmail($value, $message = null)
	{
		if($message == null)
		{
			$message = "Please enter a valid Email.";
		}
		$this->validate(isset($value) &&
						strlen($value) > 0 &&
						preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $value),
						$message);			
	}
	
	public function looseEmailValidate($value, $message = null)
	{
		if($message == null)
		{
			$message = "Please enter a valid Email.";
		}
		$this->validate(isset($value) && strlen($value) > 0 && strstr($value, '@') && strstr($value, '.'), $message);
	}
	
	public function validatePhone($value, $message = null)
	{
		if($message == null)
		{
			$message = "Please enter a valid Phone Number.";	
		}
		
		$fmatted = preg_replace("/\D/","",$value);  
		$this->validate(
				isset($value) && 
				strlen($value) > 0 && 
				(strlen($fmatted) == 10 || 
					strlen($fmatted) == 11 || 
					strlen($fmatted) == 7 ||
					strlen($fmatted) > 10 && strstr($value, "x")
				), 
				$message);	
	}
    
	/*
	|----------------------------------------------------------------------------------------
	| These functions deal with printing and output.
	|----------------------------------------------------------------------------------------
	|
	*/	
    public function addError($message)
    {
        $this->errors[] = $message;
    }
	
	public function addWarning($message)
	{
		$this->warnings[] = $message;	
	}
	
	public function addSuccessMessage($message)
	{
		$this->successMessages[] = $message;
	}
    
	/*
	|----------------------------------------------------------------------------------------
	| checks and retrieval of errors, warning, and successes
	|----------------------------------------------------------------------------------------
	|
	*/	
    public function hasErrors()
    {
        if(count($this->errors) > 0)
            return true;
        return false;
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
	
	public function hasSuccessMessages()
	{
		if($this->successMessages > 0)
			return true;
		return false;
	}
    
	
	/*
	|----------------------------------------------------------------------------------------
	| These functions deal with printing and output.
	|----------------------------------------------------------------------------------------
	|
	*/
    public function printErrors($prefix = "<div>", $suffix = "</div>", $writeToVar = false)
    {
		$string = "";
		
        foreach($this->errors as $error)
        {
			$string.= $prefix.$error.$suffix;
		}
		
		if($writeToVar)
			return $string;
		else
			echo $string;
    }
	
	public function printErrorDiv($frame_tag = "<div>", $frame_end = "</div>", $error_tag = "<div>", $error_end = "</div>", $writeToVar = true)
	{
		if($this->hasErrors())
		{
			$string = $frame_tag.$this->printErrors($error_tag, $error_end, true).$frame_end;
			
			if($writeToVar)
				return $string;
			else
				echo $string;
		}
	}
	
	public function printSuccesses($prefix = "<div>", $suffix = "</div>", $writeToVar = false)
    {
        foreach($this->successMessages as $success)
        {
			if($writeToVar)
				return $prefix.$success.$suffix;
			else
            	echo $prefix.$success.$suffix;
		}
    }
	
	public function printSuccessDiv($frame_tag = "<div>", $frame_end = "</div>", $success_tag = "<div>", $success_end = "</div>", $writeToVar = true)
	{
		if($this->successMessages > 0)
		{
			$string = $frame_tag.$this->printSuccesses($success_tag, $success_end, true).$frame_end;
			
			if($writeToVar)
				return $string;
			else
				echo $string;
		}
	}
}