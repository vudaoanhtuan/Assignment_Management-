<?php
	require_once("header.php");
	require_once("connection.php");
	require_once("function.php");
?>

<?php
	$username = $_SESSION["username"];
	$student_id = $_SESSION["student_id"];
	if (isset($_GET['ass_id'])) {
		$ass_id = $_GET['ass_id'];
		$sql = "SELECT * FROM submit WHERE student_id=$student_id AND assignment_id=$ass_id ORDER BY id DESC";
		$query = mysqli_query($conn, $sql);

		
		echo '<center><h3>'."Score".'</h3></center>';
        echo '<table class="table table-striped table-bordered table-hover">';
        echo '<th>#</th>';
        echo '<th>Assignment</th>';
        echo '<th>Subject</th>';
        echo '<th>Status</th>';
        echo '<th>Score</th>';
        echo '<th>Log</th>';

        $count = 0;

		while ($row = mysqli_fetch_array($query)) {
			$count++;
			echo '<tr>';

			$ass_id = $row['assignment_id'];
			$ass_name = getAssignmentName($ass_id);
			$subject_name = getSubjectNameFromAssId($ass_id);

			$status = $row['status'];
			$score = $row['score'];
			$log = $row['log'];

			echo '<td>'.$count.'</td>';
			echo '<td>'.$ass_name.'</td>';
			echo '<td>'.$subject_name.'</td>';
			echo '<td>'.$status.'</td>';
			echo '<td>'.$score.'</td>';
			echo '<td>'.$log.'</td>';


			echo '</tr>';
		}

		echo '</table>';
	}


?>