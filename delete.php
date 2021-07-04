<?php
    session_start();

    include 'conn.php';
    $ids = $_GET['id'];
    $deletequery =  " delete from signup where id={$ids} ";
    $query = mysqli_query($con,$deletequery);
    if(isset($_SESSION['msg'])) {
        $_SESSION['msg']= "Account Deleted.";
    }
    header('location:login.php');
?>