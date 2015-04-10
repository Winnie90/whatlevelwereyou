<?php
class mysql {
	var $db_host;
	var $db_database;
	var $db_user;
	var $db_password;
	var $dbh;
	var $error_handle;
	var $error_last;
	var $error_log;

	/**
	*	PHP 4 THIS FUNCTION MUST BE SAME AS CLASS NAME,
	* 	PHP 5 USE __construct
	*/
	function mysql($db_host='localhost', $db_database='mysql', $db_user='root', $db_password='', $options=array()) {
		$this->db_host = $db_host;
		$this->db_database = $db_database;
		$this->db_user = $db_user;
		$this->db_password = $db_password;
		if(isset($options['error_log']) && $options['error_log']!='') {
			$this->error_log = $options['error_log'];
		}

	}

	function connect() {
		$this->dbh = mysql_connect($this->db_host, $this->db_user, $this->db_password)
			or $this->error('mysql::connect','Could not connect: '.mysql_error());
		mysql_select_db($this->db_database)
			or $this->error('mysql::connect','Can\'t use db: '.mysql_error());
	}

	function disconnect() {
		mysql_close($this->dbh);
	}

	function fetchToArray($sql_query) {
		$result_array=array();
		$result_resource = mysql_query($sql_query, $this->dbh)
			or $this->error('mysql::fetchToArray',mysql_error());
        var_dump($sql_query);
		if(!is_resource($result_resource)) {
			$this->error('mysql::fetchToArray', mysql_error().' for query: "'.$sql_query.'"');
		}
		while($result_row = mysql_fetch_array($result_resource, MYSQL_ASSOC)){
			array_push($result_array, $result_row);
		}
		return $result_array;
	}

	function query_to_array($sql_query) {
		return $this->fetchToArray($sql_query);
	}

	function fetchToList($sql_query){
		$result_array=array();
		$result_resource = mysql_query($sql_query, $this->dbh) or $this->error('mysql::query_to_list', mysql_error());
		if(!is_resource($result_resource)) {
			$this->error('mysql::query_to_list', mysql_error().' for query: "'.$sql_query.'"');
		}
		while($result_row = mysql_fetch_array($result_resource, MYSQL_ASSOC)){
			array_push($result_array, array_shift($result_row));
		}
		return $result_array;
	}

	function query_to_list($sql_query) {
		return $this->fetchToList($sql_query);
	}

	function fetchToHash($sql_query){
		$result_array=array();
		$result_resource = mysql_query($sql_query, $this->dbh)
			or $this->error('mysql::query_to_hash', mysql_error());
		while($result_row = mysql_fetch_array($result_resource)){
			$result_array[$result_row[0]] = $result_row[1];
		}
		return $result_array;
	}

	function query_to_hash($sql_query) {
		return $this->fetchToHash($sql_query);
	}

	function execute($sql_query){
		if(!isset($this->dbh) || $this->dbh=='') {
			$this->connect();
		}
		mysql_query($sql_query, $this->dbh) or
			$this->error('mysql::execute',mysql_error($this->dbh),mysql_errno($this->dbh));
		if(mysql_insert_id($this->dbh)!='') {
			return mysql_insert_id($this->dbh);
		} else{
			return mysql_affected_rows($this->dbh);
		}
	}

	function error($module, $message, $error_number=''){
		switch($this->error_handle) {
			default:
				print '<div class="_error">[MySql Error] An error has occurred in '.$module.' - '.$message.'</div>';
			break;
			case 'cache':
				$this->error_last = array('module'=>$module,'message'=>$message,'error_number'=>$error_number);
			break;
			case 'log':
				if(isset($this->error_log) && $this->error_log!='') {
					error_log(date('D M d H:i:s Y')." - [MySql Error] An error has occurred in $module - $message\n", 3, $this->error_log);
				}
			break;
		}
	}
}
?>