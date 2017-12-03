<?php 
session_start(); 
 
if (isset($_SESSION['student_id'])){
    unset($_SESSION['student_id']); // xóa session login
}


if (isset($_SESSION['username'])){
    unset($_SESSION['username']); // xóa session login
}

header('Location: index.php');

?>
