<?php
abstract class Parseable{
	protected $_arrData;
	
	protected $_strName;
	
	protected $_strError = '';
	
	
	
	public function __construct(){
		$this->_arrData = array();
		$this->_strName = get_class($this);
	}
	
	abstract public function Parse($strText);
	
	abstract public function ToHTML();
	
	public function extraAction(){
		
	}
	
	protected function ParseAsTable($strText, $intExpectedColumns = -1){
		// blank out the array
		$this->_arrData = array();
		
		// split the data
		$arrData = explode(PHP_EOL,$strText);
		
		// make sure we have the class name as the first element
		if(trim($arrData[0]) != $this->_strName){
			$this->AddError('Class was not found expected: ' . $this->_strName . ' found: ' . $arrData[0]);
			return false;
		}
		
		// loop through the remaining results
		for($i = 1; $i<count($arrData); $i++){
			// make sure there is data to parse
			if(strlen($arrData[$i])>0){
				// split the string
				$this->_arrData[$i-1] = explode('|', $arrData[$i]);
				
				// remove the blank items
				array_pop($this->_arrData[$i-1]);
				array_shift($this->_arrData[$i-1]);
				
				// check to see if we need to verify the columns
				if($intExpectedColumns > 0){
					// check
					$intCount = count($this->_arrData[$i-1]);
					if($intCount != $intExpectedColumns){
						$this->AddError('Found wrong number of columns on line ' . $i . ' found ' . $intCount . ' but expected ' . $intExpectedColumns . '.');
						return false;
					}
				}
			} 
		}
		
		return true;
	}
	
	public function AddError($strError){
		$this->_strError .= $strError;	
	}	
	
	public function GetErrors(){
		return $this->_strError;
	}
}