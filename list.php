<?php
Nộp bài
Đăng xuất
    session_start();
    if (!isset($_SESSION['username'])) {
         header('Location: login.php');
    }
    echo "User :";
    echo $_SESSION['username'] . "<br>";



    require("config.php");


    $path = trim($studentDir) . "/" . trim($_SESSION['username']);

    $arr = scandir($path);

    $list;

    foreach ($arr as $key => $value) {
        if (strlen($value) == 15)
            $list[] = $value;
    }

    rsort($list);

    $count = 1;

    foreach ($list as $key => $value) {
        echo "STT: " . $count . "<br>";
        $count++;

        echo "Thời gian: ";
        echo date( "Y-m-d H:i:s", strtotime($value));
        echo "<br>";
        

        echo "Điểm: ";
        

        $subdir = $path . "/" .$value;

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

    


?>