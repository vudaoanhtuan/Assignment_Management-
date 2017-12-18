<?php
	require_once("header.php");
	require_once("connection.php");
	require_once("function.php");
	require_once("viewlog.php");
?>

<?php
	$username = $_SESSION["username"];
	$student_id = $_SESSION["student_id"];
	if (isset($_GET['ass_id'])) {
		$ass_id = $_GET['ass_id'];
		$ass = getAssignment($ass_id);
		$subject = getSubject($ass["subject_id"]);

		$sql = "SELECT * FROM submit WHERE student_id=$student_id AND assignment_id=$ass_id ORDER BY id DESC";
		$query = mysqli_query($conn, $sql);

		
		echo '<center><h2>'.$subject["name"].'</h2></center>';
		echo '<center><h3>'.$ass["name"].'</h3></center>';
        echo '<table class="table table-striped table-bordered table-hover">';
        echo '<th>#</th>';
        echo '<th>Time</th>';
        echo '<th>Score</th>';
        // echo '<th>Log</th>';

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
			$time = $row["time"];

	    	$time = date( "m-d-Y H:i:s", strtotime($time));

			echo '<td>'.$count.'</td>';
			echo '<td>'.$time.'</td>';



		    if (trim($status) == "0")
			    echo '<td> <a data-toggle="modal" href="#myModal" onclick="getListLog('.$row["id"].')">' .$score. '</a></td>';
			if (trim($status) == "1")
				echo '<td> <a class="label label-danger" role="button" data-toggle="modal" href="#myModal" onclick="getError('.$row["id"].')"> Error </a> </td>';
			if (trim($status) == "w")
				echo "<td> Waitting </td>";
			if (trim($status) == "g")
				echo "<td> Gradding </td>";


			// echo '<td>'.$log.'</td>';


			echo '</tr>';
		}

		echo '</table>';
	}
	// hiện thị thông tin chung
	else {
		echo "<center><h3>Recent Submit</h3></center>";
		echo '<table class="table table-striped table-bordered table-hover">
			<th>#</th>
			<th>Assigment</th>
			<th>Subject</th>
			<th>Time</th>
			<th>Score</th>';


		$sql = "SELECT * FROM submit WHERE student_id=$student_id ORDER BY time DESC LIMIT 20";
		$query = mysqli_query($conn, $sql);

		$count = 0;

		while($row=mysqli_fetch_array($query)){
			echo "<tr>";
		    $student_id = $row["student_id"];
		    $sql2 = "SELECT username FROM student WHERE id=$student_id";
		    $query2 = mysqli_query($conn, $sql2);

		    $username = mysqli_fetch_array($query2)["username"];

		    $assignment_id = $row["assignment_id"];
		    $sql2 = "SELECT name FROM assignment WHERE id=$assignment_id";
		    $query2 = mysqli_query($conn, $sql2);

		    $assname = mysqli_fetch_array($query2)["name"];

		    $time = $row["time"];

		    $d = date( "m-d-Y H:i:s", strtotime($time));
		    $subject_name = getSubjectNameFromAssId($assignment_id);
		    $status = $row["status"];
		    $score = $row["score"];
		    $log = $row["log"];
		    $ass_id = $row["assignment_id"];

		    $log = str_replace("^", "\n", $log);
		    $count++;
		    echo "<td> $count </td>";
		    echo "<td><a href=\"score.php?ass_id=$ass_id\"> $assname </a></td>";
		    echo "<td> $subject_name </td>";
		    echo "<td> $d </td>";
		 //    if (trim($status) == "0")
			//     echo "<td> Done </td>";
			// else 
			// 	echo '<td> Error </td>';
		 //    echo "<td> $score </td>";

		    if (trim($status) == "0")
			    echo '<td> <a data-toggle="modal" href="#myModal" onclick="getListLog('.$row["id"].')">' .$score. '</a></td>';
			if (trim($status) == "1")
				echo '<td> <a class="label label-danger" role="button" data-toggle="modal" href="#myModal" onclick="getError('.$row["id"].')"> Error </a> </td>';
			if (trim($status) == "w")
				echo "<td> Waitting </td>";
			if (trim($status) == "g")
				echo "<td> Gradding </td>";

		    echo "</tr>";
		}

		echo '</table>';
	}


?>