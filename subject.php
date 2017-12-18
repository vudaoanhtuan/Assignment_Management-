<?php
	require_once("header.php");
	require_once("connection.php");
	require_once("function.php");
?>

<?php
	if (isset($_GET["sub_id"])) {
		$subject_id = $_GET["sub_id"];

		$sql="SELECT name FROM subject WHERE id=".$subject_id;
		$query = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($query);

		echo '<center><h3>'.$row["name"].'</h3></center>';
		echo '<ul class="list-group">';

		$sql = "SELECT * FROM assignment WHERE subject_id=$subject_id";
		$query = mysqli_query($conn, $sql);


	    echo '<center><h3>'."Assignment".'</h3></center>';
	    echo '<table class="table table-striped table-bordered table-hover">';
	    echo '<th>#</th>';
	    echo '<th>Assignment</th>';
	    echo '<th>Status</th>';

	    $count = 0;

	 	while($row=mysqli_fetch_array($query)){
	        $count++;
	        $ass_id = $row['id'];
	        $ass_name = $row["name"];

	        $ass= getAssignment($ass_id);
	        date_default_timezone_set('Asia/Ho_Chi_Minh');

	        $start = strtotime($ass["start_time"]);
	        $end = strtotime($ass["end_time"]);

	        $now = time();

	        echo '<tr>';
	        echo '<td>'.$count.'</td>';
	        echo '<td><a href="?ass_id='.$ass_id.'">'.$ass_name.'</a></td>';
	         
	        if ($start > $now) 
	            echo "<td><span class=\"label label-primary\"> Incoming </span></td>";
	        else if ($now > $end) 
	            echo "<td><span class=\"label label-danger\"> Finished </span></td>";
	        else
	            echo "<td><span class=\"label label-success\"> Running </span></h4>";

	        echo '</tr>';
		}
		echo "</table>";



	} else {
		$sql = "SELECT * FROM subject";
		$query = mysqli_query($conn, $sql);

		echo '<center><h3>Subject</h3></center>';
		echo '<ul class="list-group">';
		
		$count = 0;
		while ($row = mysqli_fetch_array($query)) {
			$count++;
			$sub_id = $row['id'];
			echo '<li class="list-group-item">'  . $count . ". ". '<a href=?sub_id='.$sub_id .'>'. $row['name'] .'</a>'. '</li>';
		}

		echo '</ul>';
	}
?>