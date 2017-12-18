<?php
	require_once("../connection.php");
	require_once("../function.php");
	if (isset($_GET["submit_id"])) {
		$submit_id =  $_GET["submit_id"];
		$submit = getSubmit($submit_id);
		$time = $submit["time"];
		$std_id = $submit["student_id"];
		$ass = getAssignment($submit["assignment_id"]);
		$std_dir = $ass["student_dir"];



		$log = $submit["log"];
		$log = str_replace("\n", "<br>", $log);

		$path = $std_dir . "/" . $std_id . "/" . $time . "/";
		
		$log = str_replace($path, "", $log);



		echo $log;
	}
?>