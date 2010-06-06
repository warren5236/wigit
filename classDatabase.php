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
		
		$strData .= '<form method="post">' . PHP_EOL;
		$strData .= '<table class="inputTable">';
		$strData .= '<tr><th>Host</th><td><input type="text" name="host"></td></tr>' . PHP_EOL;
		$strData .= '<tr><th>User</th><td><input type="text" name="username"></td></tr>' . PHP_EOL;
		$strData .= '<tr><th>Password</th><td><input type="password" name="password"></td></tr>' . PHP_EOL;
		$strData .= '<tr><th>Database</th><td><input type="text" name="database"></td></tr>' . PHP_EOL;
		$strData .= '<tr><td colspan="2"><input type="submit" name="extraAction" value="Build Pages From Database"></td></tr>' . PHP_EOL;
		$strData .= '</table>';
		$strData .= '</form>' . PHP_EOL;
		
		return $strData;
	}
	
	public function extraAction(){
		global $DATA_DIR;
		
		$strHost = $_POST['host'];
		$strUsername = $_POST['username'];
		$strPassword = $_POST['password'];
		$strDB = $_POST['database'];
		
		// connect to the database
		mysql_connect($strHost, $strUsername, $strPassword) or die ('Unable to connect to database');
		mysql_select_db($strDB) or die ('Unable to select database');
		
		// pull out the tables
		$strQuery = 'SHOW TABLES';
		$qryResult = mysql_query($strQuery) or die('Error while attempting to get tables: ' . mysql_error());
		
		$strDatabasePage = 'classDatabase' . PHP_EOL;
		
		// loop through the results
		while($arrRow = mysql_fetch_array($qryResult)){
			$strDatabasePage .= '|' . $arrRow[0] . '||' . PHP_EOL;
		}
		
		// save the database page
		file_put_contents($DATA_DIR . '/' . getPage(), $strDatabasePage);
	}
}