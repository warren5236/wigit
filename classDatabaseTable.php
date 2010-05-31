<?php
class classDatabaseTable extends Parseable{
	
	public function Parse($strText){
		// this should be in tabular format
		return $this->ParseAsTable($strText,6);
	}
	
	public function ToHTML(){
		$strData = '<table border="1">' . PHP_EOL;
		// print the table header
		$strData .= '<tr><td>Field</td><td>Type</td><td>Null</td><td>Key</td><td>Default</td><td>Extra</td></tr>' . PHP_EOL;
		
		// loop through all the arrays
		foreach($this->_arrData as $arrLine){
			// create a line to display this
			$strData .= '<tr><td>'.$arrLine[0].'</td><td>'.$arrLine[1].'</td><td>'.$arrLine[2].'</td><td>'.$arrLine[3].'</td><td>'.$arrLine[4].'</td><td>'.$arrLine[5].'</td></tr>' . PHP_EOL;
		}
		
		
		$strData .= '</table>' . PHP_EOL;
		return $strData;
	}
}