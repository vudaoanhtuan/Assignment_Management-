<?php
	require_once("header.php");
	require_once("function.php");
?>

<table class="table table-striped table-bordered table-hover">
	<th>#</th>
	<th>Username</th>
	<th>Assigment</th>
	<th>Subject</th>
	<th>Time</th>
	<th>Score</th>
	<!-- <th style="width: 200px;">Log</th> -->

<?php
	
	require_once("connection.php");


	$sql = "SELECT * FROM submit ORDER BY time DESC LIMIT 20";
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

	    $log = str_replace("^", "\n", $log);
	    $count++;
	    echo "<td> $count </td>";
	    echo "<td> $username </td>";
	    echo "<td> $assname </td>";
	    echo "<td> $subject_name </td>";
	    echo "<td> $d </td>";
	    if (trim($status) == "0")
		    echo "<td> $score </td>";
		if (trim($status) == "1")
			echo '<td> Error </td>';
		if (trim($status) == "w")
			echo "<td> Waitting </td>";
		if (trim($status) == "g")
			echo "<td> Gradding </td>";
	    // echo "<td> $log </td>";

	    echo "</tr>";
	}


?>

</table>



<?php
	require_once("footer.php");
?>