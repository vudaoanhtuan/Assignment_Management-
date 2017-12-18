<?php
	require_once("../connection.php");
	require_once("../function.php");
?>


<?php
	if (isset($_GET["ass_id"]) && isset($_GET["export"])) {


		$ass_id = $_GET["ass_id"];
		$ass = getAssignment($ass_id);
		$subject = getSubject($ass["subject_id"]);
		$class_id = $ass["class_id"];

		// creat file
		$time = date("Ymd\THis", time());
		$path = "../temp/$time.csv";
		$handle = fopen($path, "w");

		fwrite($handle, $subject["name"]."\n");
		fwrite($handle, $ass["name"]."\n");

		fwrite($handle, "#, Student, Score\n");


		$sql = "SELECT id, username FROM student WHERE class_id=$class_id";
		$query = mysqli_query($conn, $sql);

		$count = 0;

		while ($row = mysqli_fetch_array($query)) {
			$std_id = $row["id"];
			$std_username = $row["username"];
			$sql2 = "SELECT eval_score FROM submit WHERE assignment_id=$ass_id AND student_id=$std_id ORDER BY eval_score DESC LIMIT 1";
			$query2 = mysqli_query($conn, $sql2);
			$row2 = mysqli_fetch_array($query2);
			if ($row2 == NULL)
				$score = 0;
			else 
				$score = $row2["eval_score"];

			$count++;

			fwrite($handle, "$count, $std_username, $score \n");

		}

		fclose($handle);

		header("Content-type: application/pdf");
		header("Content-disposition: attachment;filename=\"score.csv\"");
		readfile($path);
		unlink($path);
	}



?>


