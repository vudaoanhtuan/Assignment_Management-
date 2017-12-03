<?php
	require_once("header.php");
	require_once("../connection.php");
	require_once("../function.php");

	$sql = "SELECT priority FROM student WHERE id=".$_SESSION['student_id'];
	$query = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($query);
	$priority =  $row['priority'];
	if ($priority < 10)
		header('Location: ../index.php');
?>

<div class="container">
<!-- form add subject -->
	<form class="form-group row" method="POST" action="index.php">
	  <div class="col-xs-6">
	    <label>Add Subject</label>
	    <br>
	    <label>Title</label>
	    <input class="form-control" id="ex2" type="text" name="subject_name" required>
	  	<button class="btn btn-primary" name="add_subject">Add</button>
	  </div>
	</form>

<?php
	if (isset($_POST["add_subject"])) {
		$sub_name = $_POST["subject_name"];
		$sql = "INSERT INTO subject (name) VALUES ('$sub_name')";
		mysqli_query($conn, $sql);
		echo '	<div class="alert alert-success">
						  	<strong>Success!</strong> Done!.
							</div>';
	}
?>






	<form class="form-group row" method="POST" action="index.php">
	  <div class="col-xs-6">
	    <label>Add Assignment</label>
	    <br>
	    <label>Title</label>
	    <input class="form-control" type="text" name="ass_name" required>

	    <label>Subject</label><br>
	    <select class="custom-select" name="subject">
	    	<?php
	    		$sql = "SELECT * FROM subject";
	    		$query = mysqli_query($conn, $sql);
	    		$row = mysqli_fetch_array($query);
	    		echo '<option selected value="'.$row["id"].'">'.$row['name'].'</option>';
	    		while ($row = mysqli_fetch_array($query)) {
	    			echo '<option value="'.$row["id"].'">'.$row['name'].'</option>';
	    		}

	    	?>

	    </select><br>



	    <label>Description</label>
	    <textarea class="form-control" rows="3"  required name="description"></textarea>

	    <label>Compiler</label>
	    <input class="form-control" type="text" name="compiler" value="g++">
	  	
	    <label>Limit</label>
	    <input class="form-control"  type="text" name="limit" value="1">
	  	


	    <label>Config</label>
	    <br>
	    <label class="form-check-label">
	      <input class="form-check-input" type="radio" value="hard" name="checktype" checked>Hard check
	    </label>
	    <br>

	    <label class="form-check-label">
	      <input class="form-check-input" type="radio" value="soft" name="checktype">Check for:
	    </label>
		<br>

		<input class="form-check-input" type="checkbox" value="case" name="case"> Case-sensitive

		<div class="input-group">
		  <span class="input-group-addon">
		    <input type="checkbox" value="float" name="float"> Floating point
		  </span>
		  <input type="text" class="form-control" name="precision" value="6">
		</div>



	    <br>
	  	<button class="btn btn-primary" name="add_ass">Add</button>

	  </div>
	</form>

</div>

<?php
	if (isset($_POST["add_ass"])) {
		$name = $_POST["ass_name"];
		$compiler = $_POST["compiler"];
		$checktype = $_POST["checktype"];
		$description = $_POST["description"];
		$subject_id = $_POST["subject"];
		$limit_time = $_POST["limit"];

		if ($checktype == "hard")
			$diff = "100|6";
		else {
			$case = "0";
			$float = "0";
			$precision = "0";
			if (isset($_POST["case"]))
				$case = "1";
			if (isset($_POST["float"])) {
				$float = "1";
				$precision = $_POST["precision"];
			}
			$diff = "0" . $case . $float . "|" . $precision;
		}

		

		$sql = "INSERT INTO assignment (subject_id, name, limit_time, compiler, note, diff) VALUES ('$subject_id', '$name', '$limit_time',
										'$compiler', '$description', '$diff') ";
		$query = mysqli_query($conn, $sql);

		$id = mysqli_insert_id($conn);

		$student_dir = $data_dir . "/A" . fillLength($id, 11) . "/student";

		$testcase_dir = $data_dir . "/A" . fillLength($id, 11) . "/testcase";

		$sql = "UPDATE assignment SET student_dir = '$student_dir', testcase_dir = '$testcase_dir' WHERE id = '$id'";
		mysqli_query($conn, $sql);
		mkdir($data_dir . "/A" . fillLength($id, 11));
		mkdir($student_dir);
		mkdir($testcase_dir);
		echo '	<div class="alert alert-success">
						  	<strong>Success!</strong> Done!.
							</div>';
	}

?>


<!-- form add assignment -->
