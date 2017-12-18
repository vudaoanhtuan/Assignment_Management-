<?php
	require_once("header.php");
	require_once("../connection.php");
	require_once("../function.php");
?>

<div class="container">
<!-- form add subject -->
	<form class="form-group row" method="POST">
	  <div class="col-xs-6">
	    <label>Add Subject</label>
	    <br>
	    <label>Title</label>
	    <input class="form-control" id="ex2" type="text" name="subject_name" required>
	  	<button class="btn btn-primary" name="add_subject">Add</button>
	  </div>
	</form>
</div>

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

