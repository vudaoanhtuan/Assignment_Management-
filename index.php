<?php
	require_once("header.php");
?>

<table class="table table-striped table-bordered table-hover">
	<th>Username</th>
	<th>Assigment</th>
	<th>Time</th>
	<th>Status</th>
	<th>Score</th>
	<th>Log</th>

<?php
	
	require_once("connection.php");

	$sql = "SELECT COUNT(*) FROM submit";
	$query = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($query);
	$count = $row[0];
	$start = max(0, $count - 20);

	$sql = "SELECT * FROM submit ORDER BY time DESC LIMIT $start, 20";
	$query = mysqli_query($conn, $sql);

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
	    $status = $row["status"];
	    $score = $row["score"];
	    $log = $row["log"];
	    echo "<td> $username </td>";
	    echo "<td> $assname </td>";
	    echo "<td> $time </td>";
	    echo "<td> $status </td>";
	    echo "<td> $score </td>";
	    echo "<td> $log </td>";

	    echo "</tr>";
	}


?>

</table>



<?php
	require_once("footer.php");
?>