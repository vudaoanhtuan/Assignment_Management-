<?php
	require_once("../connection.php");
	require_once("../function.php");
	if (isset($_GET["submit_id"]) && isset($_GET["log_id"])) {
		$submit_id =  $_GET["submit_id"];
		$log_id = $_GET["log_id"];

		$submit = getSubmit($submit_id);
		$ass_id = $submit["assignment_id"];
		$std_id = $submit["student_id"];
		$time = $submit["time"];

		$ass = getAssignment($ass_id);
		$path = $ass["student_dir"] . "/" . $std_id . "/" . $time . "/" . "output";

		$path_std_output = $path . "/" . $log_id;
		$path_log = $path . "/" . $log_id . ".log";

		$std_output_content = readLogFile($path_std_output);
		$log_content = readLogFile($path_log);
		
		if (trim($_GET["type"]) == "std")
			echo $std_output_content;
		else
			echo $log_content;
	}
?>