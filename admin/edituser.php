<?php
	require_once("../connection.php");
	require_once("../function.php");
	require_once("header.php");
?>

<?php
	if (isset($_GET["username"])) {
		$username = $_GET["username"];
		$user = getUser($username);
	} else {
		header("Location: user.php");
	}
?>

<?php
	if (isset($_POST["edit"])) {
		$class = $_POST["class"];
		$priority = $_POST["priority"];
		$username = $_POST["username"];

		$sql = "UPDATE student SET priority='$priority', class_id='$class' WHERE username='$username'";
		mysqli_query($conn, $sql);
		echo ' <div class="alert alert-success">
                            <strong>Success!</strong> Updated!.
                            </div>';
        header("Location: user.php");
	}
?>


<div class="container">
	<form class="form-group row" method="POST">
	  	<div class="col-xs-6">
		    <label>User Information</label>
		    <br>
		    <label>Name</label>
		    <input class="form-control" type="text" name="_username" value= <?php echo "$username"  ?> readonly>


		    <label>Class</label><br>
		    <select class="form-control" name="class">
		    	<?php
			    	$sql = "SELECT * FROM class";
			    	$query = mysqli_query($conn, $sql);
			    	while ($row = mysqli_fetch_array($query)) {
			    		if ($row['id'] == $user['class_id'])
			    			echo '<option selected value="'.$row["id"].'">'.$row['name'].'</option>';
			    		else 
			    			echo '<option value="'.$row["id"].'">'.$row['name'].'</option>';
			    	}

		    	?>

		    </select><br>

		    <label>Priority</label><br>
		    <select class="form-control" name="priority">
		    	<?php
			    	
			    	for ($pri=0; $pri<10; $pri++) {
			    		if ($pri == $user['priority'])
			    			echo '<option selected value="'.$pri.'">'.$pri.'</option>';
			    		else 
			    			echo '<option value="'.$pri.'">'.$pri.'</option>';
			    	}

		    	?>

		    </select><br>
		    <input type="hidden" name="username" value=<?php echo "$username";  ?>>
	
	  		<button class="btn btn-primary" name="edit">Edit</button>

		</div>
	</form>
</div>


