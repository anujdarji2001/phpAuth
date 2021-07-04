<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php

    include 'conn.php';

    if(isset($_POST['signin']))
    {
        
        $email= mysqli_real_escape_string($con,$_POST['email']);
        $pass= mysqli_real_escape_string($con,$_POST['pass']);
        
        $emailquery =  " select * from signup where email='$email' and status='active' ";
        $query = mysqli_query($con,$emailquery);
        
        $emailcount = mysqli_num_rows($query);

        if($emailcount)
        {
            $email_pass = mysqli_fetch_assoc($query);

            $db_pass = $email_pass['pass'];

            $_SESSION['fname'] = $email_pass['firstname'];
            $_SESSION['lname'] = $email_pass['lastname'];
            $_SESSION['email'] = $email_pass['email'];
            $_SESSION['contact'] = $email_pass['contact'];
            $_SESSION['DOB'] = $email_pass['DOB'];
            $_SESSION['pic'] = $email_pass['pic'];

            $pass_decode = password_verify($pass,$db_pass);
            
            if($pass_decode)
            {
                ?>
                   <script>
                        swal("Yeahhh" ,"Login Successfully.😊", "success").then(function() {
                        window.location = "index.php";})
                    </script>     
                    <?php
            }else{
                    ?>
                    <script>
                        swal("Oopss!!", "Password Incorrect.", "error");
                    </script>
                    <?php
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

    <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing in image"></figure>
                        <a href="signup.php" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign in</h2>
                        <form action="" method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email material-icons-name"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Password"/>
                            </div>

                            <div>
                                <p class="bg-success text-white "> <?php 
                                if(isset($_SESSION['msg'])){
                                    echo $_SESSION['msg'];
                                }
                                else {
                                    echo $_SESSION['msg'] = 'You are Logged out Sucessfully.';
                                }
                                ?></p>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>

                            <a href="recover_account.php">Forgot password?</a>
                        </form>
                        <div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>