<?php
	include_once('conf.php');
	$_db_connections = array();
	
	function db_connection($dbid = 'default'){
		global $_db_conf;
		global $_db_connections;

		if(isset($_db_connections[$dbid])){
			$con = $_db_connections[$dbid];
		} else {
			$db = $_db_conf['dbs']['default'];
			$con = mysqli_connect('localhost', $db['user'], $db['pass'],'wb');
			if($con)
				$_db_connections[$dbid] = $con;
		}
		$con or die(mysql_error());
		return $con;
	}
	
	function db_query($q, $con = null, $dbid = 'default'){
		if ($con == null){
			$con = db_connection($dbid);
		}
		$rs = mysqli_query($con,$q);
		return $rs;
	}
		
	function db_num_rows($rs){
		return mysql_num_rows($rs);
	}
	function db_fetch_row($qrs){
		$row = $qrs->fetch_assoc();
		return $row;
		}
	function db_fetch_one_row($qrs, $con = null, $dbid = 'default'){
		if(is_string($qrs))
			$qrs = db_query($qrs, $con, $dbid);
			
		return $qrs ? mysql_fetch_array($qrs) : false;
	}
	
	
	function db_fetch_n_rows($qrs, $n = null, $con = null, $dbid = 'default'){
		if(is_string($qrs))
			$qrs = db_query($qrs, $con, $dbid);
		
		if($qrs){
			$rows = array();
			for($i = 0; $n !== null && $i < $n && $row = db_fetch_one_row($qrs) ; $i++)
				$rows[] = $row;
			return $rows;
		}
		return false;
	}
	
	function db_fetch_scalar($qrs, $con = null, $dbid = 'default'){
		$row = db_fetch_one_row($qrs, $con, $dbid);
		return ($row !== false) ? $row[0] : false;
	}

	function db_error($dbid = 'default'){
		if(isset($_db_connections[$dbid])){
			$con = $_db_connections[$dbid];
			return mysql_error($con);
		}
		return "Connection with id '$dbid' is not open";
	}
	
	function db_close($dbid = 'default'){
		if(isset($_db_connections[$dbid])){
			mysql_close($_db_connections[$dbid]);
		}
	}
?>