<?php
    require_once("header.php");
    require_once('connection.php');
    require_once("function.php");
?>

<?php

if (!isset($_GET["ass_id"])) {
	$sql="SELECT * FROM assignment";
    $query=mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) == 0){
    	echo "Không có dữ liệu";
	}
	else {
        echo '<center><h3>'."Assignment".'</h3></center>';
        echo '<table class="table table-striped table-bordered table-hover">';
        echo '<th>#</th>';
        echo '<th>Assignment</th>';
        echo '<th>Subject</th>';

        $count = 0;

    	while($row=mysqli_fetch_array($query)){
            $count++;
        	$subject_id = $row["subject_id"];
            $ass_id = $row['id'];
            $subject_name = getSubjectName($subject_id);
            $ass_name = $row["name"];
            echo '<tr>';
            echo '<td>'.$count.'</td>';
            echo '<td><a href="?ass_id='.$ass_id.'">'.$ass_name.'</a></td>';
            echo '<td><a href="subject.php?sub_id='.$subject_id.'">'.$subject_name.'</td>';
            echo '</tr>';
   		}



        echo '</table>';

	}
} else {
    $sql="SELECT * FROM assignment WHERE id=".$_GET["ass_id"];
    $ass_id = $_GET["ass_id"];
    $query=mysqli_query($conn, $sql);
    $row=mysqli_fetch_array($query);

    $subject_id = $row["subject_id"];
    $name = $row["name"];
    $note = $row["note"];

    echo '<center><h3>'. $name .'</h3></center>';

    echo '<h4>Đề bài: </h4>';
    echo $note;



    // echo '<div class="btn-group">';
    echo '<br>';
    echo '<center>';
    echo '<a href="submit.php?ass_id='.$ass_id.'"><button type="button" class="btn btn-primary">Nộp bài</button></a> ';
    echo '<a href="score.php?ass_id='.$ass_id.'"><button type="button" class="btn btn-primary">Các lần nộp</button></a>';  
    echo '</center>';
    // echo '</div>';

}


?>