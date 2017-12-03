<?php
	session_start();
	if (!isset($_SESSION['student_id'])) {
	     header('Location: login.php');
	}
?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">


 	<link rel="stylesheet" href="/dsa2/css/bootstrap.min.css">
	<script src="/dsa2/js/jquery.min.js"></script>
	<script src="/dsa2/js/bootstrap.min.js"></script>




</head>


<body>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">
					Log in as: 
					<?php
			                		echo $_SESSION["username"];
			                	?>
				</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav nav-pills">
					<li><a href="../index.php">Home</a></li>
					<li><a href="../subject.php">Subject</a></li>
					<li><a href="../assignment.php">Assignment</a></li>
					<li><a href="../score.php">Score</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li><a href="../logout.php">Logout</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>

