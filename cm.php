<?php
    $t = "12/12/2017 9:16 AM";
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $time = date("Ymd\THis", strtotime($t));
    echo strtotime($t) . "<br>";
    echo time();

?>