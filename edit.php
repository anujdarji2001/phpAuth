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
    $ids = $_GET['id'];
    $selectquery =  " select * from signup where id={$ids} ";
    $query = mysqli_query($con,$selectquery);
    $data = mysqli_fetch_array($query);

    if(isset($_POST['signup']))
    {
        
        $fname= mysqli_real_escape_string($con,$_POST['first_name']);
        $lname= mysqli_real_escape_string($con,$_POST['last_name']);
        $email= mysqli_real_escape_string($con,$_POST['email']);
        $contact= mysqli_real_escape_string($con,$_POST['contact']);
        $DOB= mysqli_real_escape_string($con,$_POST['DOB']);
        
        $imgold= $_POST['img_old'];
        $dbemail=$data['email'];

        $file = $_FILES['photo'];   
        $filename = $file['name'];
        
        $emailquery =  " select * from signup where email='$email' ";
        $query = mysqli_query($con,$emailquery);
        
        $emailcount = mysqli_num_rows($query);

        $token = bin2hex(random_bytes(15));

                
                
                if($dbemail != $email && $emailcount==0)
                {
                    if($filename=='')
                    {
                        $updatequery = "UPDATE `signup` SET `firstname`='$fname',`lastname`='$lname',email='$email', `contact`='$contact',`DOB`='$DOB', tokan='$token' WHERE id = '$ids'";
                        $iquery = mysqli_query($con,$updatequery);          
                    }
                    else
                    {
                        $filepath = $file['tmp_name'];
                        $fileerror = $file['error'];    
                        $destfile ='upload/'.$filename;
                        move_uploaded_file($filepath,$destfile);       
                        $updatequery = "UPDATE `signup` SET `firstname`='$fname',`lastname`='$lname',email='$email', `contact`='$contact',`DOB`='$DOB', pic='$destfile', tokan='$token' WHERE id = '$ids'";
                        $iquery = mysqli_query($con,$updatequery);      
                    }

                    $updateQuery = "UPDATE `signup` SET `status`='inactive' WHERE `id`='$ids'";
                    $query = mysqli_query($con, $updateQuery);

                    $subject = "Email Activation";
                    $body = " Hi, $fname. Click here too activate your account http://localhost/phpproject/activate.php?token=$token";
                    $sender_email = "From: 2001vedant@gmail.com";
                    
                    if(mail($email, $subject, $body, $sender_email))
                    {
                        $_SESSION['msg']="Check your mail to activate your account $email";
                        header('location:login.php');
                    }
                    else{
                        echo "Email sending failed...";
                    }
                }
                else if($email==$dbemail)
                {
                    if($filename=='')
                    {
                        $updatequery = "UPDATE `signup` SET `firstname`='$fname',`lastname`='$lname',email='$email', `contact`='$contact',`DOB`='$DOB', tokan='$token' WHERE id = '$ids'";
                        $iquery = mysqli_query($con,$updatequery);          
                    }
                    else
                    {
                        $filepath = $file['tmp_name'];
                        $fileerror = $file['error'];    
                        $destfile ='upload/'.$filename;
                        move_uploaded_file($filepath,$destfile);       
                        $updatequery = "UPDATE `signup` SET `firstname`='$fname',`lastname`='$lname',email='$email', `contact`='$contact',`DOB`='$DOB', pic='$destfile', tokan='$token' WHERE id = '$ids'";
                        $iquery = mysqli_query($con,$updatequery);      
                    }
                    $_SESSION['msg']="Account Updated";
                    header('location:login.php');
                }
                else{
                    ?>
                    <script>
        
                        swal("Invalid", "Email Already Exisits.", "error").then(function() {
                        window.location = "login.php";})
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
                        <h2 class="form-title">Update Profile</h2>
                        <form action="" method="POST" class="register-form" id="register-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="first_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="first_name" id="first_name" placeholder="First Name" value = "<?php echo $_SESSION['fname']; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="last_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="last_name" id="last_name" placeholder="Last Name"  value = "<?php echo $_SESSION['lname']; ?>"/>
                            </div>

                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Enter Email"  value = "<?php echo $_SESSION['email']; ?>"/>
                            </div>

                            <div class="form-group">
                                <label for="Conact_no"><i class="zmdi zmdi-phone"></i></label>
                                <input type="number" name="contact" id="contact" placeholder="Enter Contact No."  value = "<?php echo $_SESSION['contact']; ?>"/>
                            </div>

                            <div class="form-group">
                                <label for="Date_of_birth"><i class="zmdi zmdi-calendar-check"></i></label>
                                <input type="date" name="DOB" id="DOB" placeholder="Enter Date Of Birth"  value = "<?php echo $_SESSION['DOB']; ?>"/>
                            </div>

                            <div class="form-group">    
                                <label for="re-pass"><i class="zmdi zmdi-folder-person"></i></label>
                                <input type="file" name="photo" id="photo">
                                <input type="hidden" name="img_old" value ="<?php echo $data['pic']; ?>">
                            </div>

                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Update"/>
                            </div>
                        </form>

                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sign up image"></figure>
                        <a href="reset_pass.php?token=<?php echo $data['tokan']; ?>" class="signup-image-link">Change Password</a><br>
                    </div>
                </div>
            </div>
        </section>

        
    </div>
</body>
</html>