<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up Form</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>


<?php

    include 'conn.php';

    if(isset($_POST['signup']))
    {
        $fname= mysqli_real_escape_string($con,$_POST['first_name']);
        $lname= mysqli_real_escape_string($con,$_POST['last_name']);
        $email= mysqli_real_escape_string($con,$_POST['email']);
        $contact= mysqli_real_escape_string($con,$_POST['contact']);
        $DOB= mysqli_real_escape_string($con,$_POST['DOB']);
        $pass= mysqli_real_escape_string($con,$_POST['pass']);
        $cpass= mysqli_real_escape_string($con,$_POST['re_pass']);
        $file = $_FILES['photo'];   
        $filename = $file['name'];
        $filepath = $file['tmp_name'];
        $fileerror = $file['error'];

         $password = password_hash($pass, PASSWORD_BCRYPT);
         $cpassword = password_hash($cpass, PASSWORD_BCRYPT);

         $token = bin2hex(random_bytes(15));
        
        $emailquery =  " select * from signup where email='$email' ";
        $query = mysqli_query($con,$emailquery);
        
        $emailcount = mysqli_num_rows($query);

        if($emailcount > 0)
        {
            ?>
                <script>    
                swal("Oopss!!", "Email already exsits", "error");
            </script>         
            <?php
        }else {
            if($pass === $cpass)
            {

                if($fileerror == 0) {
                    $destfile ='upload/'.$filename;
                    move_uploaded_file($filepath,$destfile);             

                    $insertquery = "insert into signup (firstname , lastname ,  email , contact, DOB, pass , cpass , pic , tokan , status) values ('$fname','$lname','$email','$contact', '$DOB','$password','$cpassword' , '$destfile' , '$token', 'inactive')"; 
                    $iquery = mysqli_query($con,$insertquery);      
                }
                if($iquery)
                {
                    $subject = "Email Activation";
                    $body = " Hi, $fname. Click here too activate your account http://remotemysql.com/phpproject/activate.php?token=$token ";
                    $sender_email = "From: 2001vedant@gmail.com";

                    if(mail($email, $subject, $body, $sender_email))
                    {
                        $_SESSION['msg']="Check your mail to activate your account $email";
                        header('location:login.php');
                    }
                    else{
                        echo "Email sending failed...";
                    }

                }else{
                        ?>
                        <script>
                            swal("Oopss!!", "Something went wrong.Inserted properly.", "error");
                        </script>
                        <?php
                }
            }
            else {
                ?>
                <script>
                        swal("Oopss!!", "Password Incorrect.", "error");
                </script>        
            <?php
            }
        }
    }
?>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form action="" method="POST" class="register-form" id="register-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="first_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="first_name" id="first_name" placeholder="First Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="last_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="last_name" id="last_name" placeholder="Last Name" required/>
                            </div>

                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Enter Email" required/>
                            </div>

                            <div class="form-group">
                                <label for="Conact_no"><i class="zmdi zmdi-phone"></i></label>
                                <input type="number" name="contact" id="contact" placeholder="Enter Contact No." required/>
                            </div>

                            <div class="form-group">
                                <label for="Date_of_birth"><i class="zmdi zmdi-calendar-check"></i></label>
                                <input type="date" name="DOB" id="DOB" placeholder="Enter Date Of Birth" required/>
                            </div>

                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Enter Password" required/>
                            </div>

                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Confirm password" required/>
                            </div>                    

                            <div class="form-group">    
                                <label for="re-pass"><i class="zmdi zmdi-folder-person"></i></label>
                                <input type="file" name="photo" id="photo">
                            </div>

                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>

                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sign up image"></figure>
                        <a href="login.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>
  
    </div>
</body>
</html>