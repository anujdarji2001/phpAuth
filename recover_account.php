<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forget Form</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>


<?php

    include 'conn.php';

    if(isset($_POST['fpass']))
    {   
        $email= mysqli_real_escape_string($con,$_POST['email']);

        $emailquery =  " select * from signup where email='$email' ";
        $query = mysqli_query($con,$emailquery);
        
        $emailcount = mysqli_num_rows($query);

        if($emailcount)
        {
            
            $userdata = mysqli_fetch_array($query);

            $fname = $userdata['fname'];
            $token = $userdata['tokan'];

            $subject = "Password Reset";
            $body = " Hi, $fname. Click here too Reset Your Password http://localhost/phpproject/reset_pass.php?token=$token ";
            $sender_email = "From: anujdarji2001@gmail.com";

            if(mail($email, $subject, $body, $sender_email))
            {
                $_SESSION['msg']="Check your mail to reset your password $email";
                header('location:login.php');
            }
            else{
                echo "Email sending failed...";
            }
        }else {
            ?>
            <script>    
                swal("Oopss!!", "Email Invalid", "error");
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
                        <h2 class="form-title">Forget Password</h2>
                        <form action="" method="POST" class="register-form" id="register-form" enctype="multipart/form-data">
                            
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Enter Email"/>
                            </div>

                            <div class="form-group form-button">
                                <input type="submit" name="fpass" id="fpass" class="form-submit" value="Send Email"/>
                            </div>
                        </form>

                    </div>
                    <div class="signup-image1">
                        <figure><img src="images/signup-image.jpg" alt="sign up image"></figure>
                        <a href="login.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>

        
    </div>
</body>
</html>