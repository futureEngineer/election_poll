<?php 

/*******************************************************************************
 *
 * Library written by CJ Buchmann
 * August 3, 2010
 *
 * The CustomFormWriter is a library containing functions that will write
 * specific forms, such as birthday dropdowns. It is used to maintain
 * consistency in forms, and to make all forms more maintainable and to reduce
 * the amount of form code that must be handwritten.
 *
 *******************************************************************************
 | Updated Jan 03, 2011 :: CJ Buchmann
 | 		- Added support for textareas
 ******************************************************************************/

class CustomForms
{
    var $newline = "\r\n";
    var $tab = "\t";
    public function __construct(){}
    
    public function loadAddon($var, $name)
    {
        $CI =& get_instance();
        $CI->load->library($name);
        
        $name = strtolower($name);
        $this->$var = $CI->$name;
    }
    
	
	/*
	|---------------------------------------------------------------------------------------------------------
	| Basic Form Inputs
	|---------------------------------------------------------------------------------------------------------
	|
	*/	
    public function input($name, $value = "", $args = null, $writeToVar = false)
    {
        return $this->printLogic($writeToVar, $this->writeBaseInput("text", $name, $value, $args, true));
    }
    
    public function password($name, $value = "", $args = null, $writeToVar = false)
    {
        return $this->printLogic($writeToVar, $this->writeBaseInput("password", $name, $value, $args, true));
    }
    
    public function hidden($name, $value = "", $args = null, $writeToVar = false)
    {
        return $this->printLogic($writeToVar, $this->writeBaseInput("hidden", $name, $value, $args, true));
    }
    
    public function fileInput($name, $value = "", $args = null, $writeToVar = false)
    {
        return $this->printLogic($writeToVar, $this->writeBaseInput("file", $name, $value, $args, true));
    }
    
    public function checkbox($name, $value = "", $args = null, $writeToVar = false)
    {
        if($args == null)
            $args = array();
        $args['isCheckbox'] = true;
            
        return $this->printLogic($writeToVar, $this->writeBaseInput("checkbox", $name, $value, $args, true));
    }
    
    public function button($name, $value = "", $args = null, $writeToVar = false)
    {
        return $this->printLogic($writeToVar, $this->writeBaseInput("button", $name, $value, $args, true));
    }
    
    public function submit($name, $value = "", $args = null, $writeToVar = false)
    {
        return $this->printLogic($writeToVar, $this->writeBaseInput("submit", $name, $value, $args, true));
    }
	
	/*
	|---------------------------------------------------------------------------------------------------------
	| Textareas
	|---------------------------------------------------------------------------------------------------------
	|
	*/
	public function textarea($name, $value = "", $args = null, $writeToVar = true)
	{
		return $this->writeBaseTextArea($name, $value, $args, $writeToVar);
	}
	
	
	/*
	|---------------------------------------------------------------------------------------------------------
	| Some useful dropdowns
	|---------------------------------------------------------------------------------------------------------
	|
	*/
    
	function select($name, $list, $args = null, $writeToVar = false )
	{
		return $this->writeBaseselect($name, $list, $args, $writeToVar);
	}
	
	function yearSelect($name, $start = null, $stop, $args = null, $writeToVar = false)
	{
		//create the list
		$list = array();
		
		if($start == null)
		{
			$start = date("Y", time());
			$stop = date("Y", strtotime("+$stop years", strtotime($start)));
		}
		
		for($i = $start; $i <= $stop; $i++)
		{
			$list[$i] = $i;
		}
		
		return $this->select($name, $list, $args, $writeToVar);
	}
	
	function monthSelect($name, $args = null, $writeToVar = false)
	{
		//create the list
		$list = array();
		
		for($i = 1; $i <= 12; $i++)
		{
			$list[$i]['key'] = $this->padNum($i);
			$list[$i]['value'] = date("F", strtotime("2010-".$this->padNum($i)."-01"));
		}
		
		$args['key'] = "key";
		$args['value'] = "value";
		
		return $this->select($name, $list, $args, $writeToVar);
	}
	
	function dateSelect($name, $args = null, $writeToVar = false)
	{
		//create the list
		$list = array();
		
		for($i = 1; $i <= 31; $i++)
		{
			$list[$i] = $this->padNum($i);
		}
		
		return $this->select($name, $list, $args, $writeToVar);
	}
	
	function hourSelect($name, $args = null, $writeToVar = false)
	{
		//create the list
		$list = array();
		
		for($i = 1; $i <= 12; $i++)
		{
			$list[$i] = $this->padNum($i);
		}
		
		return $this->select($name, $list, $args, $writeToVar);
	}
	
	function minuteSelect($name, $increment = 1, $args = null, $writeToVar = false)
	{
		//create the list
		$list = array();
		
		for($i = 0; $i <= 59; $i+= $increment)
		{
			$list[$i] = $this->padNum($i);
		}
		
		//find the selected value
		
		return $this->select($name, $list, $args, $writeToVar);
	}
	
	function meridianSelect($name, $args = null, $writeToVar = false)
	{
		if(!isset($args['default']))
			$args['default'] = "pm";
		return $this->select($name, array("am"=>"AM", "pm"=>"PM"), $args, $writeToVar);
	}
	
	//converts a comma separated string into a drop down
	function stringSelect($name, $string, $args = null, $writeToVar = false)
	{
		$list = explode(",", $string);
		
		for($i = 0; $i < count($list); $i++)
			$list[$i] = trim($list[$i]);
		
		return $this->select($name, $list, $args, $writeToVar);
	}
	
	function minMaxSelect($name, $min, $max, $increment = 1, $args = null, $writeToVar = false)
	{
		//create the list
		$list = array();
		
		if($args != null && is_array($args))
            extract($args);
		
		for($i = $min; $i <= $max; $i+= $increment)
		{
			if(isset($padnum) && $padnum)
				$list[$i] = $this->padNum($i);
			else
				$list[$i] = $i;
		}
		
		if(isset($additional_entries) && strlen($additional_entries) > 0)
		{
			$entries = explode(",", $additional_entries);
			
			for($i = 0; $i < count($entries); $i++)
			{
				$entry = trim($entries[$i]);
				if(isset($padnum) && $padnum)
				$list[$entry] = $this->padNum(trim($entry));
			else
				$list[$entry] = trim($entry);
			}
		}
		
		sort($list);
		
		return $this->select($name, $list, $args, $writeToVar);
	}
    

	/*
	|---------------------------------------------------------------------------------------------------------
	| Base Functions. These are the functions from which all other inputs will be created.
	|---------------------------------------------------------------------------------------------------------
	|
	*/
	
	/*******************************
     * the simple dropdown.
     *
     * Input array containing one or more of the following
     * name - the name of dropdown,
     * list - the list to of options,
     * args - additional features such as class and id, also can set key/value for a list with multiple keys and values
     */
	 
    private function writeBaseselect($name, $list, $args = null, $writeToVar = false )
    {
        if($args != null && is_array($args))
            extract($args);
        
        $string = $this->newline."<select name='$name' ";
        if(isset($class))
            $string.= " class = '$class' ";
        if(isset($id))
            $string.= " id = '$id' ";
        if(isset($style))
            $string.= " style = '$style' ";
        $string.= " >";
        
        
        if(isset($key) && isset($value))
        {
            $arr_key = $key;
            $arr_val = $value;
        }
        
        //we'll overide the default selector with the request
        if(!isset($getRequest) || isset($getRequest) && $getRequest)
        {
            $request = $this->getRequest($name);
            if(strlen($request) > 0)
                $selected = $request;
        }
        
        if($this->isAssociativeArray($list))
        {
            foreach($list as $key=>$val)
            {
                if(isset($key) && is_array($val))
                {
                    $key_val = $val[$arr_key];
                    $value_val = $val[$arr_val];
                }
                elseif(isset($key))
                {
                    $key_val = $key;
                    $value_val = $val;
                }
                
                (isset($selected) && $key_val == $selected)? $select = " SELECTED " : $select = "";
                if(!isset($selected) && $select == "" && isset($default) && $key_val == $default)
                    $select = " SELECTED ";
                $string.= $this->newline.$this->tab."<option $select value = '$key_val'>$value_val</option> ";
            }
        }
        else
        {
            foreach($list as $key=>$val)
            {
                (isset($selected) && $val == $selected)? $select = " SELECTED " : $select = "";
                if($select == "" && !isset($selected) && isset($default) && $val == $default)
                    $select = " SELECTED ";
				
				// check to see if this is a date variable
				if ( (strlen($val) == 10) && ( strstr($val,'-') != false ) ) {
					$to_show=date('l, F jS',strtotime($val));	
				} else {
					$to_show=$val;	
				}
                $string.= $this->newline.$this->tab."<option $select value = '$val'>$to_show</option> ";
            }
        }
        
        $string.= $this->newline."</select>";
        
        return $this->printLogic($writeToVar, $string);
    }
	
	private function writeBaseInput($type, $name, $value = "", $args = null, $writeToVar = true)
    {
        if($args != null && is_array($args))
            extract($args);
			
		$old_value = $value;
        
        $string = "<input type = '$type' name ='$name' ";
        
        //we'll overide the default selector with the request
        if(!isset($getRequest) || isset($getRequest) && $getRequest)
        {
            $request = $this->getRequest($name);
			
            if(is_array($request) || strlen($request) > 0)
                $value = $request;
        }
        if(isset($class))
            $string.= " class = '$class' ";
        if(isset($id))
        {
            $string.= " id = '$id' ";
        }
        if(isset($style))
            $string.= " style = '$style' ";
        if(isset($default_value) && $value == "")
            $string.= " value = '$default_value' ";
        elseif($value != "")
            $string.= " value = '$value' ";
		if(isset($disabled))
			$string.= " disabled = true ";
		if(isset($maxlength))
			$string.= " maxlength = $maxlength ";
        if(isset($isCheckbox) && $isCheckbox)
        {
            if(!($value == null || $value == "0" || $value == "") || $old_value == "1")
            	$string.= " CHECKED ";
        }
        $string.= " />";
        
        return $this->printLogic($writeToVar, $string);
    }
	
	/*
	|---------------------------------------------------------------------------------------------------------
	| Textareas
	|---------------------------------------------------------------------------------------------------------
	|
	*/
	private function writeBaseTextArea($name, $value = "", $args = null, $writeToVar = true)
	{
		 if($args != null && is_array($args))
            extract($args);
			
		$string = "<textarea ";
		$string.= "name = '$name' ";
		if(isset($id))
			$string.= "id = '$id' ";
		if(isset($class))
			$string.= "class = '$class' ";
		if(isset($style))
			$string.= "style = '$style' ";
			
		$string.= ">";
			
		//we'll overide the default selector with the request
        if(!isset($getRequest) || isset($getRequest) && $getRequest)
        {
            $request = $this->getRequest($name);
            if(strlen($request) > 0)
                $value = $request;
        }
		
        if(isset($default_value) && $value == "")
            $string.= "$default_value";
        elseif($value != "")
            $string.= "$value";
		
		$string.= "</textarea>";
			
		return $this->printLogic($writeToVar, $string);
	}
	
	/*
	|---------------------------------------------------------------------------------------------------------
	| Helper functions
	|---------------------------------------------------------------------------------------------------------
	|
	*/
	
	public function padNum($value)
	{
		
		if(is_numeric($value) && is_integer($value) && $value < 10)
			return "0".$value;
		return $value;
	}
    
    
    public function isAssociativeArray($array)
    {
        foreach($array as $key=>$val)
        {
            if(is_array($val))
            {
                if($this->isAssociativeArray($val))
                    return true;
            }
            if(!is_numeric($key))
            {
                return true;
            }
        }
        return false;
    }
    
    public function getRequest($name)
    {
        if($this->isArrayRequest($name))
        {
            return $this->getArrayRequest($name);
        }
        else
        {
            if(isset($_REQUEST[$name]))
            {
                return $_REQUEST[$name];
            }
        }
    }
    
    public function isArrayRequest($name)
    {
        if(strstr($name, "["))
            return true;
    }
    
    function getArrayRequest($name)
    {
        $name = str_replace("]", "", $name);
        $parts = explode("[", $name);
        
        if(count($parts) > 0)
        {
            if(!isset($_REQUEST[$parts[0]]))
                return;
            $request = $_REQUEST[$parts[0]];
            
            for($i = 1; $i < count($parts); $i++)
            {
                if(!isset($request[$parts[$i]]))
                    return null;
                $request = $request[$parts[$i]];   
            }
            
            return $request;
        }
        else
        {
            return null;
        }
        
    }
    
    public function printLogic($writeToVar, $inputString)
    {
        if($writeToVar)
            return $inputString;
        
        echo $inputString;
        return null;
    }
}