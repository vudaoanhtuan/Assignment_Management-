<?php
	require_once("header.php");
	require_once("../connection.php");
	require_once("../function.php");
?>
<link rel="stylesheet" type="text/css" href="../css/bootstrap-datetimepicker.css">

<?php
	if (isset($_GET["ass_id"])) {
		$ass_id = $_GET["ass_id"];
		
		$assignment = getAssignment($ass_id);
	} else {
		header("Location: ../assignment.php");
	}


?>

<div class="container">
	<form class="form-group row" method="POST" action="edit.php">
	  <div class="col-xs-6">
	    <label>Edit Assignment</label>
	    <br>
	    <label>Title</label>
	    <br>
	    <input class="form-control" type="text" name="ass_name" required value=<?php echo '"' . $assignment['name']. '"'; ?> >
	    <br>
	    <label>Subject</label><br>
	    <select class="form-control" name="subject">
	    	<?php
	    		$subject = getSubjectFromAssId($ass_id);
	    		$sql = "SELECT * FROM subject";
	    		$query = mysqli_query($conn, $sql);	        		
	    		while ($row = mysqli_fetch_array($query)) {
	    			if ($row['id'] == $subject['id'])
	    				echo '<option selected value="'.$row["id"].'">'.$row['name'].'</option>';
	    			else 
	    				echo '<option value="'.$row["id"].'">'.$row['name'].'</option>';
	    		}

	    	?>

	    </select><br>

	    <label>Class</label><br>
	    <select class="form-control" name="class">
	    	<?php
	    		$sql = "SELECT * FROM class";
	    		$query = mysqli_query($conn, $sql);
	    		while ($row = mysqli_fetch_array($query)) {
	    			if ($row['id'] == $assignment['class_id'])
	    				echo '<option selected value="'.$row["id"].'">'.$row['name'].'</option>';
	    			else 
	    				echo '<option value="'.$row["id"].'">'.$row['name'].'</option>';
	    		}

	    	?>

	    </select><br>



	    <label>Description</label>
	    <textarea class="form-control" rows="3"  required name="description"><?php echo $assignment["note"];  ?></textarea>

	    <label>Student Directory</label>
	    <input class="form-control" type="text" name="student_dir" value=<?php echo  '"' . $assignment["student_dir"]. '"'; ?>>
	    
	    <label>Testcase Directory</label>
	    <input class="form-control"  type="text" name="testcase_dir" value=<?php echo  '"' .$assignment["testcase_dir"]. '"';  ?>>
	    



	    <label>Compiler</label>
	    <input class="form-control" type="text" name="compiler" value=<?php echo  '"' . $assignment["compiler"]. '"'; ?>>
	  	
	    <label>Limit</label>
	    <input class="form-control"  type="text" name="limit" value=<?php echo  '"' .$assignment["limit_time"]. '"';  ?>>
	  	
	    <label>Start</label>
	    <br>
	  	<div class="row">
	  	        <div class='col-sm-6'>
	  	            <div class="form-group">
	  	                <div class='input-group date' id='start'>
	  	                    <input type='text' class="form-control" name="start"  value=<?php echo  '"' .$assignment["start_time"]. '"';  ?>  />
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
	  	                    <input type='text' class="form-control" name="end" value=<?php echo  '"' .$assignment["end_time"]. '"';  ?>  />
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

	    <label>Config</label>
	    <br>
	    <label class="form-check-label">
	      <input class="form-check-input" type="radio" value="hard" name="checktype" <?php if ($assignment["diff"][0] == "1") echo "checked"; ?> >Hard check
	    </label>
	    <br>

	    <label class="form-check-label">
	      <input class="form-check-input" type="radio" value="soft" name="checktype">Check for:
	    </label>
		<br>

		<input class="form-check-input" type="checkbox" value="case" name="case"   <?php  if ($assignment["diff"][1] == "1") echo "checked"; ?>      > Case-sensitive

		<div class="input-group">
		  <span class="input-group-addon">
		    <input type="checkbox" value="float" name="float" <?php if ($assignment["diff"][2] == "1") echo "checked"; ?>   > Floating point
		  </span>
		  <input type="text" class="form-control" name="precision" value=<?php echo  '"' .$assignment["diff"][4]. '"'; ?>>
		</div>

		<input type="hidden" name="ass_id" value=<?php echo '"'.$ass_id.'"';  ?>>



	    <br>
	  	<button class="btn btn-primary" name="edit_ass">Edit</button>

	  </div>
	</form>
</div>

<?php

	if (isset($_POST["edit_ass"])) {
		$name = $_POST["ass_name"];
		$compiler = $_POST["compiler"];
		$checktype = $_POST["checktype"];
		$description = $_POST["description"];
		$subject_id = $_POST["subject"];
		$limit_time = $_POST["limit"];
		$student_dir = $_POST["student_dir"];
		$testcase_dir = $_POST["testcase_dir"];
		$ass_id = $_POST["ass_id"];

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

		

		$sql = "UPDATE assignment SET name='$name', compiler='$compiler', note='$description', subject_id='$subject_id', limit_time='$limit_time', student_dir='$student_dir', testcase_dir='$testcase_dir', diff='$diff' WHERE id='$ass_id' ";
		$query = mysqli_query($conn, $sql);
		

	}

?>

<script type="text/javascript" src="../js/collapse.js"></script>
<script type="text/javascript" src="../js/moment.js"></script>
<script type="text/javascript" src="../js/transition.js"></script>
<script type="text/javascript" src="../js/moment-with-locales.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.js"></script>
