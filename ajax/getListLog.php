<?php
	require_once("../connection.php");
	require_once("../function.php");
	if (isset($_GET["submit_id"])) {
		$submit_id =  $_GET["submit_id"];
		$submit = getSubmit($submit_id);
		$ass_id = $submit["assignment_id"];
		$std_id = $submit["student_id"];
		$time = $submit["time"];

		$ass = getAssignment($ass_id);
		$path = $ass["student_dir"] . "/" . $std_id . "/" . $time;
		$list = readScoreLog($path);
		for ($i=0; $i<count($list); $i++) {
			$name = trim($list[$i]["name"]);
			// if (trim($list[$i]["status"]) == "1")
			// 	$t = '<span role="button" class="label label-info" onclick="getLog('.$submit_id ."," ."'".$list[$i]["name"]."'".')">'.$list[$i]["name"].'</span>';
			// else 
			// 	$t = '<span role="button" class="label label-danger" onclick="getLog('.$submit_id .",".$list[$i]["name"].')">'.$list[$i]["name"].'</span>';
			if (trim($list[$i]["status"]) == "1")
				$type = "label-info";
			else
				$type = "label-danger";
			$t = "<span role=\"button\" class=\"label $type\" onclick=\"getLog($submit_id, '$name')\">$name</span>";
			echo $t." ";	
		}		
	}
?>