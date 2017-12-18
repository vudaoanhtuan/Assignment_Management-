<?php
    require_once("header.php");
    require_once("connection.php");
    require_once("function.php");
    if (!isset($_GET["ass_id"])) {
        header('Location: assignment.php');
    } else {
        $ass= getAssignment($_GET["ass_id"]);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $start = strtotime($ass["start_time"]);
        $end = strtotime($ass["end_time"]);

        $now = time();
        if (!($start < $now && $now < $end))
            header('Location: assignment.php');
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>upload file- toidicode.com</title>
    <link rel="stylesheet" href="">
</head>
<body>



<form class="container" method="post" enctype="multipart/form-data">

    <div class="col-xs-8">
        <center><h3>
            <?php
                echo getAssignmentName($_GET["ass_id"]);
            ?> 
        </h3></center>



        <label>
            Choose file to submit
        </label>
        <div class="input-group">    
            <label class="btn btn-default input-group-addon">
                Browse <input type="file" name="fileUpload" style="display: none" onchange='$("#path").val($(this).val());'>
            </label>

            <input type="text" id="path" class="form-control" disabled>
        </div>
        <br>
        <input type="submit" class="btn btn-primary" name="up" value="Upload">
        <input type="hidden" name="ass_id" value=<?php echo '"'. $_GET["ass_id"] .'"'; ?> >
    </div>

</form>



<?php 


    if(isset($_POST['up']) && isset($_FILES['fileUpload'])){
        if($_FILES['fileUpload']['error']>0)
            echo "Upload lỗi rồi!";
        else{

            $sql="SELECT * FROM assignment WHERE id=".$_GET["ass_id"];
            $query=mysqli_query($conn, $sql);
            $row=mysqli_fetch_array($query);

            $student_dir = $row["student_dir"];


            $std_dir = $student_dir."/".$_SESSION["student_id"];

            if (!is_dir($std_dir))
                mkdir($std_dir);

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $time = date("Ymd\THis", time());
            $time_dir = $std_dir."/".$time;

            mkdir($time_dir);

            $upload_file = $time_dir."/".$_FILES['fileUpload']['name'];

            move_uploaded_file($_FILES['fileUpload']['tmp_name'], $upload_file);
            echo "upload thành công <br/>";
    

            // giải nén
            

            $zip = new ZipArchive;
            $res = $zip->open($upload_file);
            if ($res === TRUE) {
                $zip->extractTo($time_dir);
                $zip->close();
                echo "Done";

                // tạo file xml

                
                $objects = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($time_dir),
                    RecursiveIteratorIterator::SELF_FIRST
                );
                foreach ($objects as $file => $object) {
                    $basename = $object->getBasename();
                    if ($basename == '.' or $basename == '..') {
                        continue;
                    }
                    if ($object->isDir()) {
                        continue;
                    }

                    $f = $object->getPathname();
                    $f = substr($f, strlen($time_dir) + 1, strlen($f) - strlen($time_dir) - 1);

                    $fileData[] = $f;
                }

                // mở file
                $xmlPath = $time_dir . "/pro.xml";
                $xml = fopen($xmlPath, "w");
                fwrite($xml, "<?xml version=\"1.0\"?>\n");
                fwrite($xml, "<project>\n");

                fwrite($xml, "\t<header>\n");
                foreach ($fileData as $key => $value) {
                    if (strpos($value, ".h") !== false || strpos($value, ".hpp") !== false)
                        fwrite($xml, "\t\t<file>".$value."</file>\n");
                }
                fwrite($xml, "\t</header>\n");

                fwrite($xml, "\t<source>\n");
                foreach ($fileData as $key => $value) {
                    if (strpos($value, ".c") !== false || strpos($value, ".cpp") !== false)
                        fwrite($xml, "\t\t<file>".$value."</file>\n");
                }
                fwrite($xml, "\t</source>\n");
                    
                fwrite($xml, "</project>");

                fclose($xml);

                // insert submit log to database
                
                $ass_id = $_POST["ass_id"];
                $std_id = $_SESSION["student_id"];


                $sql = "INSERT INTO submit(assignment_id, student_id, time, status) VALUES ( '$ass_id', '$std_id', '$time', 'w')";

                mysqli_query($conn,$sql);

                $sql = "SELECT * FROM student WHERE id=".$std_id;
                $query = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($query);
                $priority = $row["priority"];
                
                require_once("socket.php");

                $data = $ass_id."|".$std_id."|".$time."|".$priority;
                echo $data;

                sent_data($data);

                // sent data to socket

                 // header('Location: index.php');

                header('Location: score.php?ass_id=' . $_GET["ass_id"]);

            } else {
                echo 'Khong tim thay file';  
            }

           


        }



    }
?>


</body>
</html>

