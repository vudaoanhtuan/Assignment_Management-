<?php
	require_once("connection.php");
	session_start();
?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">


 	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>




</head>

<body>

	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">
					Log in
				</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav nav-pills">
					<li><a href="index.php">Home</a></li>
					<li><a href="subject.php">Subject</a></li>
					<li><a href="assignment.php">Assignment</a></li>
					<li><a href="score.php">Score</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>


<?php
	if (isset($_POST["btn_reg"])) {
		//lấy thông tin từ các form bằng phương thức POST
		$username = $_POST["username"];
		$password = $_POST["password"];
		$name = $_POST["fullname"];
		$email = $_POST["email"];
		$class =$_POST["class"];
		//Kiểm tra điều kiện bắt buộc đối với các field không được bỏ trống
		if ($username == "" || $password == "" || $name == "" || $email == "") {
			   echo '<div class="alert alert-warning">
  					<strong>Warning!</strong> Thông tin không đầy đủ.
					</div>';
			}else{
					// Kiểm tra tài khoản đã tồn tại chưa
					$sql="select * from student where username=".$username;
				$kt=mysqli_query($conn, $sql);

				if(mysqli_num_rows($kt)  > 0){
					echo '<div class="alert alert-warning">
  						<strong>Warning!</strong> Tài khoản đã tồn tại.
						</div>';
				}else{
					//thực hiện việc lưu trữ dữ liệu vào db
    				$sql = "INSERT INTO student(
    					username,
    					password,
    					name,
					    email,
					    class_id
    					) VALUES (
    					'$username',
    					'$password',
					    '$name',
    					'$email',
    					'$class'
    					)";
				    // thực thi câu $sql với biến conn lấy từ file connection.php
						mysqli_query($conn,$sql);
			   		echo '	<div class="alert alert-success">
						  	<strong>Success!</strong> Đăng kí thành công.
							</div>';
					$_SESSION['student_id'] = mysqli_insert_id($conn);
					// echo $_SESSION['student_id'];
					$_SESSION["username"] = $username;
					header('Location: index.php');
				}
								    
				
		}
	}
?>
    <div class="container">    
<!-- Sigup here -->

        <div id="signupbox" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Sign Up</div>
                            <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="login.php">Sign In</a></div>
                        </div>  
                        <div class="panel-body" >
                            <form id="signupform" class="form-horizontal" role="form" method="POST" action="register.php">
                                
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                    
                                
                                  
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Username</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="username" placeholder="Last Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Full Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="fullname" placeholder="First Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email" placeholder="Email Address">
                                    </div>
                                </div>

                                <div class="form-group">
                                	<label class="col-md-3 control-label">Class</label>
                                	<div class="col-md-9 ">
	                                	<select class="form-control " name="class">
	                                		<?php
	                                			$sql = "SELECT * FROM class";
	                                			$query = mysqli_query($conn, $sql);
	                                			$row = mysqli_fetch_array($query);
	                                			echo '<option selected value="'.$row["id"].'">'.$row['name'].'</option>';
	                                			while ($row = mysqli_fetch_array($query)) {
	                                				echo '<option value="'.$row["id"].'">'.$row['name'].'</option>';
	                                			}

	                                		?>

	                                	</select>
	                                </div>
                                </div>
                                    

                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-signup" type="submit" class="btn btn-info" name="btn_reg"><i class="icon-hand-right"></i> &nbsp Sign Up</button>
                                    
                                    </div>
                                </div>

                                
                                
                            </form>
                         </div>
                    </div>


         </div> 
    </div>
    






	</body>
</html>