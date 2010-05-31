<?php
require_once('classDatabaseTable.php');

class classDatabase extends Parseable{
	public function Parse($strText){
		// this should be in tabular format
		return $this->ParseAsTable($strText,2);
	}
	
	public function ToHTML(){
		global $DATA_DIR;
		
		$strData = '<table class="classDatabaseTable">' . PHP_EOL;
		// print the table header
		$strData .= '<tr><th>Table</th><th>Layout</th><th>Foreign Keys</th></tr>' . PHP_EOL;
		
		// loop through all the arrays
		foreach($this->_arrData as $arrLine){
			// determine the table name
			$strTable = 'Table' . $arrLine[0];
			
			// create a line to display this
			$strData .= '<tr><td>[' . $strTable . '|'.$arrLine[0].']</td><td>';
			
			// determine the name of the file
			$strFile = $DATA_DIR . '/' . $strTable;
			
			// check to see if the file exists
			if(file_exists($strFile)){
				$strData .= wikify(file_get_contents($strFile));
			} else {
				$strData .= '['.$strTable.'|'.$arrLine[0].']';
			} 
			
			
			$strData .= '</td><td>'.$arrLine[1].'</td></tr>' . PHP_EOL;
		}
				
		$strData .= '</table>' . PHP_EOL;
		
		
		
		return $strData;
	}
}