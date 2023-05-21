<?php 
echo "<pre>";
class logger {

	/**
	 * Set the directory of the log files.
	 * @param string $error_log_directory
	 */
	public $error_log_directory;

	/**
	 * Set the name of the log files.
	 * @param string $error_log_name
	 */
	public $error_log_name;

	/**
	 * Set the size in MegaBytes of the log files.
	 * @param string $error_log_size
	 */
	public $error_log_size;
	
	/**
	 * Set the amount of log files to keep before recycling them
	 * @param string $error_log_count
	 */
	public $error_log_count;
	
	/**
	 * Set the name of aplication to logguing
	 * @param string $error_log_count
	 */
	public $error_log_app;
		
	
	public function __construct(){
		$this->error_log_directory = 'Logs/';
		$this->error_log_name = 'error.log';
		$this->error_log_size = 5; // Valor en Mb
		$this->error_log_count = '10';
		$this->error_log_app = 'Unknown';
	}
	
	
	/**
	 * Determines whether the size of current log file is valid 
	 * @return boolean
	 */
	private function getLogSize(){
		try {
			if(filesize($this->error_log_name) <= ($this->error_log_size * 1000000)){
				return true;
			}else{
				return false;
			}
		} catch (Exception $e) {
		}
	}
	
	
	/**
	 * Sort Associative array by field
	 * @param array $arrIni
	 * @param string $col
	 * @param string Optional $order. By Default order is SORT_ASC
	 */
	private function arraySortBy(&$arrIni, $col, $order = SORT_ASC){
		try {
			$arrAux = array();
			foreach ($arrIni as $key=> $row)
			{
				$arrAux[$key] = is_object($row) ? $arrAux[$key] = $row->$col : $row[$col];
				$arrAux[$key] = strtolower($arrAux[$key]);
			}
			array_multisort($arrAux, $order, $arrIni);
		} catch (Exception $e) {
		}
	}
	
	
	/**
	 * Determines whether the current log file should be recycled
	 * @return boolean
	 */
	private function setLogName(){
		try {
			$logs_array = array_diff(scandir($this->error_log_directory), array('..', '.'));
			$index_array = array();
			$index = array();
			$element = array();
			foreach ($logs_array as $log){
				$name_array = explode('_',$log);
				if(count($name_array)>1){
					$index = explode('.', $name_array[1]);
					$index_date = filemtime($this->error_log_directory.$log);
					$element['index'] = $index[0];
					$element['index_date'] = $index_date;
					array_push($index_array, $element);
				} 
			}
			
			rsort($index_array);

			if ($index_array[0]['index']== $this->error_log_count){
				$this->arraySortBy($index_array,'index_date', SORT_ASC);
				$index_new = $index_array[0]['index'];
			}else{
				$index_new = $index_array[0]['index'] + 1;				
			}

			$name_new_array = explode('.',$this->error_log_name);
			$new_name = $name_new_array[0].'_'.$index_new.'.'.$name_new_array[1];
			rename($this->error_log_name, $new_name);
			return true;
		} catch (Exception $e) {
		}
	}
	
	
	/**
	 * Create a new log file
	 * @return boolean
	 */
	private function createLog($new = false){
		try {
			if (!$new){
				$this->setLogName();
			}
			$archivo = fopen($this->error_log_name, 'a+');
			fwrite($archivo, PHP_EOL);
			fwrite($archivo, '********************************************************************'.PHP_EOL);
			fwrite($archivo, 'LOG ERRORES:: '.$this->error_log_app.PHP_EOL);
			fwrite($archivo, '********************************************************************'.PHP_EOL);
			fwrite($archivo, PHP_EOL);
			fwrite($archivo, PHP_EOL);
			fclose($archivo);
			return true;
		} catch (Exception $e) {
		}
	}

	
	/**
	 * Write a new message in the log file
	 * @param string $error_log_msg
	 * @return boolean
	 */
	public function writeLog($error_log_msg){
		try {
			$this->error_log_name = $this->error_log_directory.$this->error_log_name;
			if (!is_dir($this->error_log_directory)) mkdir($this->error_log_directory);
			if (!file_exists($this->error_log_name)) $this->createLog(true);
			if (!$this->getLogSize()) $this->createLog();
			$file = fopen($this->error_log_name, 'a+');
			$error_log_msg = date('Y-m-d h:i:s').' ::-> '.$error_log_msg;
			fwrite($file, $error_log_msg.PHP_EOL);
			fclose($file);
			return true;
		} catch (Exception $e) {
		}
	}
	

	
	
	
}


	
	
	
	
	


?>