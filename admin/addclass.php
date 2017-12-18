<?php
	require_once("header.php");
	require_once("../connection.php");
	require_once("../function.php");
?>

<div class="container">
<!-- form add subject -->
	<form class="form-group row" method="POST">
	  <div class="col-xs-6">
	    <label>Add Class</label>
	    <br>
	    <label>Name</label>
	    <input class="form-control" id="ex2" type="text" name="name" required>.

	    <label>Description</label>
	    <textarea class="form-control" rows="3" name="description"></textarea>

	  	<button class="btn btn-primary" name="add_class">Add</button>
	  </div>
	</form>
</div>

<?php
	if (isset($_POST["add_class"])) {
		$class_name = $_POST["name"];
		$des = $_POST["description"];
		$sql = "INSERT INTO class (name, note) VALUES ('$class_name', '$des')";
		mysqli_query($conn, $sql);
		echo '	<div class="alert alert-success">
						  	<strong>Success!</strong> Done!.
							</div>';
	}
?>

