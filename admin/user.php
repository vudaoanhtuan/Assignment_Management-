<?php
    require_once("header.php");
    require_once('../connection.php');
    require_once("../function.php");
?>

<?php
    $sql = "SELECT priority FROM student WHERE id=".$_SESSION["student_id"];
    $query = mysqli_query($conn, $sql);
    $info = mysqli_fetch_array($query);

    $priority = $info['priority'];


    $sql="SELECT * FROM assignment";
    $query=mysqli_query($conn, $sql);

    if(mysqli_num_rows($query) == 0){
        echo "Không có dữ liệu";
    }

    else {


        echo '<center><h3>'."Student".'</h3></center>';
        echo '<table class="table table-striped table-bordered table-hover">';
        echo '<th>#</th>';
        echo '<th>Username</th>';
        echo '<th>Fullname</th>';
        echo '<th>Class</th>';
        echo '<th>Priority</th>';


        $sql = "SELECT * FROM student WHERE priority < 10";
        $query = mysqli_query($conn, $sql);

        $count = 0;

    	while($row=mysqli_fetch_array($query)){
            $username = $row["username"];
            $fullname = $row["name"];
            $class_id = $row["class_id"];
            $class = getClass($class_id);
            $class = $class["name"];
            $priority = $row["priority"];
            echo '<tr>';

            $count++;
            echo "<td> $count </td>";
            echo "<td><a href=\"edituser.php?username=$username\">$username</a></td>";
            echo "<td> $fullname </td>";
            echo "<td> $class </td>";
            echo "<td>  $priority </td>";

            echo '</tr>';
        }

        echo '</table>';

    }


?>