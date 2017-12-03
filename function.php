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

	function fillLength($str, $len) {
		while (strlen($str) < intval($len)) {
			$str = "0" . $str;
		
		}
		return $str;
	}


?>