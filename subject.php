<?php
	require_once("header.php");
	require_once("connection.php");
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

		$count = 0;
		while ($row = mysqli_fetch_array($query)) {
			$count++;
			$ass_id = $row["id"];
			echo '<li class="list-group-item">'  . $count . ". ". '<a href=assignment.php?ass_id='.$ass_id .'>'. $row['name'] .'</a>'. '</li>';
		}

		echo '</ul>';

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