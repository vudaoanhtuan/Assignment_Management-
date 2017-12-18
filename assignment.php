<?php
    require_once("header.php");
    require_once('connection.php');
    require_once("function.php");
?>

<?php
    $sql = "SELECT priority FROM student WHERE id=".$_SESSION["student_id"];
    $query = mysqli_query($conn, $sql);
    $info = mysqli_fetch_array($query);

    $priority = $info['priority'];

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
        echo '<th>Status</th>';
        echo '<th>Subject</th>';

        $count = 0;




    	while($row=mysqli_fetch_array($query)){
            $count++;
        	$subject_id = $row["subject_id"];
            $ass_id = $row['id'];
            $subject_name = getSubjectName($subject_id);
            $ass_name = $row["name"];

            $ass= getAssignment($ass_id);
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $start = strtotime($ass["start_time"]);
            $end = strtotime($ass["end_time"]);

            $now = time();

            echo '<tr>';
            echo '<td>'.$count.'</td>';
            echo '<td><a href="?ass_id='.$ass_id.'">'.$ass_name.'</a></td>';
            
            if ($start > $now) 
                echo "<td><span class=\"label label-primary\"> Incoming </span></td>";
            else if ($now > $end) 
                echo "<td><span class=\"label label-danger\"> Finished </span></td>";
            else
                echo "<td><span class=\"label label-success\"> Running </span></h4>";

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

    date_default_timezone_set('Asia/Ho_Chi_Minh');

    $start = strtotime($row["start_time"]);
    $end = strtotime($row["end_time"]);

    $now = time();



    $subject_id = $row["subject_id"];
    $name = $row["name"];
    $note = $row["note"];

    echo '<center><h3>'. $name .'</h3></center>';
    echo '<center>';
    if ($start > $now) 
        echo "<h4><span class=\"label label-primary\"> Incoming </span></h4>";
    else if ($now > $end) 
        echo "<h4><span class=\"label label-danger\"> Finished </span></h4>";
    else
        echo "<h4><span class=\"label label-success\"> Running </span></h4>";
    echo '</center>';

    echo "  <div class=\"container\">
                <div class=\"panel panel-primary\">
                    <div class=\"panel-heading\">Requirement</div>
                    <div class=\"panel-body\"> $note</div>
                </div>
            </div>";




    // echo '<div class="btn-group">';
    echo '<br>';
    echo '<center>';
    if ($start < $now && $now < $end)
        echo '<a href="submit.php?ass_id='.$ass_id.'"><button type="button" class="btn btn-primary">Submit</button></a> ';
    if ($start < $now)
        echo '<a href="score.php?ass_id='.$ass_id.'"><button type="button" class="btn btn-primary">Recent submit</button></a>';  
    echo '</center>';
    // echo '</div>';

}


?>