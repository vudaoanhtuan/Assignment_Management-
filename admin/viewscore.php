<?php
	require_once("header.php");
	require_once("../connection.php");
	require_once("../function.php");
?>


<?php
	if (isset($_GET["ass_id"])) {
		$ass_id = $_GET["ass_id"];
		$ass = getAssignment($ass_id);
		$subject = getSubject($ass["subject_id"]);
		$class_id = $ass["class_id"];

		echo '<center><h2>'.$subject["name"].'</h2></center>';
		echo '<center><h3>'.$ass["name"].'</h3></center>';

		echo "<center> <a href=\"export.php?ass_id=$ass_id&export=true\" class=\"btn btn-primary\" role=\"button\">Export</a> <center> <br>";
		echo '	<table class="table table-striped table-bordered table-hover">
				<th>#</th>
				<th>Student</th>
				<th>Final Score</th>';

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

			echo "<tr>";
			echo "<td>$count</td>";
			echo "<td>$std_username</td>";
			echo "<td>$score</td>";
			echo "</tr>";

		}


		echo '</table>';
	} 
	else {

	    echo '<center><h3>'."Assignment".'</h3></center>';
	    echo '<table class="table table-striped table-bordered table-hover">';
	    echo '<th>#</th>';
	    echo '<th>Assignment</th>';
	    echo '<th>Subject</th>';

	    $count = 0;


	    $sql="SELECT * FROM assignment";
	    $query=mysqli_query($conn, $sql);

	 	while($row=mysqli_fetch_array($query)){
	         $count++;
	     	$subject_id = $row["subject_id"];
	         $ass_id = $row['id'];
	         $subject_name = getSubjectName($subject_id);
	         $ass_name = $row["name"];
	         echo '<tr>';
	         echo '<td>'.$count.'</td>';
	         echo '<td><a href="viewscore.php?ass_id='.$ass_id.'">'.$ass_name.'</a></td>';
	         

	         echo '<td><a href="subject.php?sub_id='.$subject_id.'">'.$subject_name.'</td>';
	         echo '</tr>';
			}



	     echo '</table>';
	}



?>


