<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Form</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>


<?php

    include 'conn.php';
    if(isset($_POST['newpass']))
    {
        if(isset($_GET['token']))
        {
            $token = $_GET['token'];
            
            $pass= mysqli_real_escape_string($con,$_POST['pass']);
            $cpass= mysqli_real_escape_string($con,$_POST['re_pass']);
        
            $password = password_hash($pass, PASSWORD_BCRYPT);
            $cpassword = password_hash($cpass, PASSWORD_BCRYPT);

            if($pass === $cpass)
            {
                $updateQuery = "update signup set pass = '$password' where tokan='$token'";
                $query = mysqli_query($con, $updateQuery);
                
                if($query){
                        $_SESSION['msg']= "Password Changed Succesfully.";
                        header('location:login.php');

                }else{
                    $_SESSION['passmsg'] = "Your Password is Not Updated.";
                    header('location:reset_pass.php');
                }
            }
            else {
                $_SESSION['passmsg'] = "Your Password is Not Matching.";
            }
        }
        else
        {
            ?>
            <script>
                alert("Token Not found");
            </script>
            <?php
        }
    }
?>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Enter New Password</h2>
                        <p><?php
                        if(isset( $_SESSION['passmsg'])){
                            $_SESSION['passmsg'];
                        }
                        else{
                            $_SESSION['passmsg'] = "";
                        }
                          ?></p>
                        <form action="" method="POST" class="register-form" id="register-form" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Enter Password"/>
                            </div>

                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Confirm password"/>
                            </div>                    

                            <div class="form-group form-button">
                                <input type="submit" name="newpass" id="newpass" class="form-submit" value="Reset Your Password"/>
                            </div>
                        </form>

                    </div>
                    <div class="signup-image2">
                        <figure><img src="images/signup-image.jpg" alt="sign up image"></figure>
                        <a href="login.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>

        
    </div>
</body>
</html>