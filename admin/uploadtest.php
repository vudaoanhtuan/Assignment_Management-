<?php
    require_once("header.php");
    require_once("../connection.php");
    require_once("../function.php");
    if (!isset($_GET["ass_id"])) {
        header('Location: assignment.php');
    } else {
        $ass_id = $_GET["ass_id"];
        $ass = getAssignment($ass_id);
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Upload testcase</title>
    <link rel="stylesheet" href="">
</head>
<body>



<form class="container" method="post" enctype="multipart/form-data">

    <div class="col-xs-8">
        <center><h3>
            <?php
                echo $ass["name"];
            ?> 
        </h3></center>



        <label>
            Choose file to upload
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
            echo "Error!";
        else{

            $upload_file = "../temp/".$_FILES['fileUpload']['name'];

            move_uploaded_file($_FILES['fileUpload']['tmp_name'], $upload_file);
    

            // giải nén
            $path = $ass["testcase_dir"];

            // xóa file cũ
            recursiveRemove($path);

            $zip = new ZipArchive;
            $res = $zip->open($upload_file);
            if ($res === TRUE) {
                $zip->extractTo($path);
                $zip->close();
                echo ' <div class="alert alert-success">
                            <strong>Success!</strong> Testcase uploaded!.
                            </div>';
            } else {
                echo ' <div class="alert alert-danger">
                            <strong>Success!</strong> File not found!.
                            </div>';
            }

           


        }



    }
?>


</body>
</html>

