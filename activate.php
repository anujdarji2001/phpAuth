<?php
    session_start();

    include 'conn.php';
    
    if(isset($_GET['token'])){
        $token = $_GET['token'];
        $updateQuery = "update signup set status = 'active' where tokan='$token'";
        $query = mysqli_query($con, $updateQuery);
        if($query){
            if(isset($_SESSION['msg'])) {
                $_SESSION['msg']= "Account Verified";
                header('location:login.php');
            }
            else {
                $_SESSION['msg']= "You are logged out.";
                header('location:login.php');
            }
        }
        else {
            $_SESSION['msg']= "Account Not Updated.";
                header('location:signup.php');
        }
    }
?>