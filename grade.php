<?php
	session_start();
	if (!isset($_SESSION['username'])) {
	     header('Location: login.php');
	}
	echo "User :";
	echo $_SESSION['username'] . "<br>";

	$dir = "D:/XAMPP/htdocs/dsa/Data/Student/" . $_SESSION['username'];

	if ($handle = opendir($dir)) {

		$count = 1;

	    while (false !== ($entry = readdir($handle))) {

	        if (strlen($entry) == 15) {
	        	echo "STT: " . $count . "<br>";
	        	$count++;

	        	echo "Thời gian: ";
	        	echo date( "Y-m-d H:i:s", strtotime($entry));
	        	echo "<br>";
	        	

	        	echo "Điểm: ";
	           

	            $subdir = $dir . "/" .$entry;

	            $log = $subdir."/pro.log";
	            $grade = $subdir."/grade.log";
	            $done = $subdir."/done";

	            if (!file_exists($done)) {
	            	echo "Đang chấm";
	            } else {
	            	if (file_exists($grade)) {
	            		$gradeStr = file_get_contents($grade);
	            		echo $gradeStr;
	            	} else {
	            		$logStr = file_get_contents($log);
	            		echo "Lỗi: " . $logStr;
	            	}
	            }

	            echo "<br><br>";
	        }
	    }

    	closedir($handle);
	}
?>