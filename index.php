<?php
    session_start();

    if(!isset($_SESSION['fname'])){
        header('location:login.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ==" crossorigin="anonymous" />

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/style1.css">
    <title>Profile</title>

</head>
<body>


<div class="container-fluid main_menu">
        <div class="row"> 
            <div class="col-md-10 col-12 mx-auto">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <a class="navbar-brand" href="/">Profile Page</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                  
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                          <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                      </ul>
                    </div>
                  </nav>
            </div>
        </div>
    </div>


<?php
    include 'conn.php';

    $firstname =  $_SESSION['fname'];
    $lastname = $_SESSION['lname'];
    $email = $_SESSION['email'];
    $oldpic = $_SESSION['pic'];
    $squery = "select * from signup WHERE email = '$email'"; 
    $query = mysqli_query($con,$squery);    
    $data = mysqli_fetch_array($query);
                        
?> 
	<div class="container mt-5">
     	<div class="row d-flex justify-content-center">
            <div class="col-md-10 mt-5 pt-5">
             	<div class="row main_div">
                 	<div class="col-sm-4 rounded-left">
        		        <div class="card-block text-center text-white mt-5">
                            <img src=" <?php echo $_SESSION['pic']; ?>" class="imgblock">
                    		<h2 class="font-weight-bold mt-4 imgbelowtext"> <?php echo "$firstname $lastname" ?> </h2>
                		</div>
            		</div>
            		<div class="col-sm-8 bg-white rounded-right">
                    	<h3 class="mt-3 text-center info">Information</h3>
                    
                        <div class="row mx-3">
                        	<div class="col-sm-6">
                            	<p class="font-weight-bold infoheading">Firstname:</p>
                           		<h4 class="infoinfo"> <?php echo $_SESSION['fname']; ?></h4>
                        	</div>
                        	<div class="col-sm-6">
                            	<p class="font-weight-bold infoheading">Lastname:</p>
                           		<h4 class="infoinfo"> <?php echo $_SESSION['lname']; ?> </h4>
                        	</div>
                    	</div>

                   		<div class="row mx-3 mt-2">
                        	<div class="col-sm-6">
                            	<p class="font-weight-bold infoheading">Email:</p>
                           		<h4 class="infoinfo"> <?php echo $_SESSION['email']; ?></h4>
                        	</div>
                        	<div class="col-sm-6">
                            	<p class="font-weight-bold infoheading">Phone:</p>
                           		<h4 class="infoinfo"><?php echo $_SESSION['contact']; ?></h4>
                        	</div>
                    	</div>
                    		
                        <div class="row mx-3 mt-2 mb-5">
                        	<div class="col-sm-6">
                            	<p class="font-weight-bold infoheading">DOB:</p>
                           		<h4 class="infoinfo"> <?php echo $_SESSION['DOB']; ?></h4>
                        	</div>                
                        </div>  
                            <div class="mb-5">
                                <a href="edit.php?id=<?php echo $data['id']; ?>" class="below-img-buttons">Edit Profile</a>
                                <a href="delete.php?id=<?php echo $data['id']; ?>" class="below-img-buttons2">Delete Account</a>   
                            </div>    
                        
              		</div>
             	</div>
            </div>
        </div>
	</div>

    <!-- Footer -->
    
    <footer>
        <p>Created By Anuj Darji</p>
    </footer>

</body>
</html>