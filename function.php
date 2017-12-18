<?php
	require_once("connection.php");

	function getSubject($sub_id) {
		$sql = "SELECT * FROM subject WHERE id=".$sub_id;
		GLOBAL $conn;
		$query = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($query);
		return $row;
	}

	function getSubjectName($sub_id) {
		$row = getSubject($sub_id);
		return $row["name"];
	}

	function getSubjectFromAssId($ass_id) {
		$row = getAssignment($ass_id);
		return getSubject($row["subject_id"]);
	}

	function getSubjectNameFromAssId($ass_id) {
		$row = getAssignment($ass_id);
		return getSubjectName($row["subject_id"]);
	}


	function getAssignment($ass_id) {
		$sql = "SELECT * FROM assignment WHERE id=".$ass_id;
		GLOBAL $conn;
		$query = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($query);
		return $row;
	}

	function getAssignmentName($ass_id) {
		$row = getAssignment($ass_id);
		return $row["name"];
	}

	function getUser($username) {
		$sql = "SELECT * FROM student WHERE username=".$username;
		GLOBAL $conn;
		$query = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($query);
		return $row;
	}

	function getClass($class_id) {
		$sql = "SELECT * FROM class WHERE id=".$class_id;
		GLOBAL $conn;
		$query = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($query);
		return $row;
	}


	function fillLength($str, $len) {
		while (strlen($str) < intval($len)) {
			$str = "0" . $str;
		
		}
		return $str;
	}

	function getSubmit($submit_id) {
		$sql = "SELECT * FROM submit WHERE id=".$submit_id;
		GLOBAL $conn;
		$query = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($query);
		return $row;
	}

	function readScoreLog($path_to_submit_dir) {
		$handle = fopen($path_to_submit_dir."/score.log", "r");
		$line = fgets($handle);
	    while (($line = fgets($handle)) !== false) {
	        $t = explode(" ", $line);
	        $res[] = array("name" => $t[0], "status" => $t[1]);
	    }
	    fclose($handle);
	    return $res;
	}

	function readLogFile($path_to_log_file) {
		$handle = fopen($path_to_log_file, "r");
		if (filesize($path_to_log_file) > 0)
			$contents = fread($handle, filesize($path_to_log_file));
		else
			$contents = "";
		fclose($handle);
		return $contents;
	}

	function recursiveRemove($dir) {
	    $structure = glob(rtrim($dir, "/").'/*');
	    if (is_array($structure)) {
	        foreach($structure as $file) {
	            if (is_dir($file)) recursiveRemove($file);
	            elseif (is_file($file)) unlink($file);
	        }
	    }
	    rmdir($dir);
	}

?>