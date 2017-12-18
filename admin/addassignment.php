<?php
	require_once("header.php");
	require_once("../connection.php");
	require_once("../function.php");
?>
<link rel="stylesheet" type="text/css" href="../css/bootstrap-datetimepicker.css">
<?php
	if (isset($_POST["add_ass"])) {

    	// add database
    	$name = $_POST["ass_name"];
    	$compiler = $_POST["compiler"];
    	$checktype = $_POST["checktype"];
    	$description = $_POST["description"];
    	$subject_id = $_POST["subject"];
    	$limit_time = $_POST["limit_time"];
    	$limit_submit = $_POST["limit_submit"];
    	$start = $_POST["start"];
    	$end = $_POST["end"];
    	$class = $_POST["class"];

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

    	

    	$sql = "INSERT INTO assignment (subject_id, name, limit_time, compiler, note, diff, class_id, start_time, end_time, limit_submit) VALUES ('$subject_id', '$name', '$limit_time', '$compiler', '$description', '$diff', '$class', '$start', '$end', '$limit_submit') ";
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
    
		header("Location: uploadtest.php?ass_id=".$id);

	}

?>


<div class="container">
	<form class="form-group row" method="POST">
	  <div class="col-xs-6">
	    <label>Add Assignment</label>
	    <br>
	    <label>Title</label>
	    <input class="form-control" type="text" name="ass_name" required>


	    <br>
	    <label>Subject</label><br>
	    <select class="form-control" name="subject">
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

	    <label>Class</label><br>
	    <select class="form-control" name="class">
	    	<?php
	    		$sql = "SELECT * FROM class";
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
		<br>
	    <label>Compiler</label>
	    <input class="form-control" type="text" name="compiler" value="g++">
	  	<br>
	    <label>Time Limit</label>
	    <input class="form-control"  type="text" name="limit_time" value="1">
	  	
	  	<br>
	    <label>Submit Limit</label>
	    <input class="form-control"  type="text" name="limit_submit" value="20">

	    <br>
	    <label>Start</label>
	    <br>
	  	<div class="row">
	  	        <div class='col-sm-6'>
	  	            <div class="form-group">
	  	                <div class='input-group date' id='start'>
	  	                    <input type='text' class="form-control" name="start"/>
	  	                    <span class="input-group-addon">
	  	                        <span class="glyphicon glyphicon-calendar"></span>
	  	                    </span>
	  	                </div>
	  	            </div>
	  	        </div>
	  	</div>


	  	<br>
	    <label>End</label>
	    <br>
	  	<div class="row">
	  	        <div class='col-sm-6'>
	  	            <div class="form-group">
	  	                <div class='input-group date' id='end'>
	  	                    <input type='text' class="form-control" name="end"/>
	  	                    <span class="input-group-addon">
	  	                        <span class="glyphicon glyphicon-calendar"></span>
	  	                    </span>
	  	                </div>
	  	            </div>
	  	        </div>
	  	</div>

	  	<script type="text/javascript">
	  	    $(function () {
	  	        $('#start').datetimepicker();
	  	        $('#end').datetimepicker({
	  	            useCurrent: false //Important! See issue #1075
	  	        });
	  	        $("#start").on("dp.change", function (e) {
	  	            $('#end').data("DateTimePicker").minDate(e.date);
	  	        });
	  	        $("#end").on("dp.change", function (e) {
	  	            $('#start').data("DateTimePicker").maxDate(e.date);
	  	        });
	  	    });
	  	</script>



		<br>
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


	    <br>
	  	<button class="btn btn-primary" name="add_ass">Add</button>

	  </div>
	</form>

</div>


<script type="text/javascript" src="../js/collapse.js"></script>
<script type="text/javascript" src="../js/moment.js"></script>
<script type="text/javascript" src="../js/transition.js"></script>
<script type="text/javascript" src="../js/moment-with-locales.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.js"></script>



<!-- form add assignment -->
