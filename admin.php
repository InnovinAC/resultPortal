<?php
session_start();
error_reporting(0);
include('../includes/config.php');


// Redirect to dashboard if already logged in
if(!empty($_SESSION['alogin'])) {
header("Location: dashboard.php");
}
// get current session and current term
$query=$dbh->prepare("select Value from tblsettings where SettingName='curSession'");
$query1=$dbh->prepare("select Value from tblsettings where SettingName='curTerm'");
$query->execute();
$query1->execute();
$getSession=$query->fetch();
$getTerm=$query1->fetch();




// Action On submit
if(isset($_POST['login']))
{
$uname=$_POST['username'];
$email=$_POST['username'];
$password=md5($_POST['password']);

// Certainly we must check if username/email and password exists
$sql ="SELECT ClassId,Role,UserName,Password FROM admin WHERE (UserName=:uname || Email=:email) and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetch();
if($query->rowCount() > 0)
{

// Store current Term, current Session, Session Class, Session Username, Session Role and redirect to dashboard if  login is successful
$_SESSION['alogin']= $_POST['username'];
$_SESSION['role'] = $results['Role'];
$_SESSION['class']= $results['ClassId'];
$_SESSION['session'] =$getSession['Value'];
$_SESSION['term']=$getTerm['Value'];

header("location: dashboard.php");

} else{
    $error="Your username/email and/or password is incorrect.";

}}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin Login - Result Portal</title>
     <?php include('includes/header.php');?>
     <link href="./../css/additional.css" rel="stylesheet" media="all" />
    </head>
<body>

<div class="mt-4 container-lg">
 <img src="./../img/logo.png" class="mb-4 mx-auto d-flex" width="20%" height="20%">


                                                <div class="card">
        <div class="card-body">


                                                        <p class="h2 mb-4 card-title text-muted font-weight-bold">Admin Login</p>

                     <?php if($error) {
  echo "<div class='alert alert-danger'>
<span class='far fa-times-circle'></span>
$error</div>";                      } ?>

                                                    <form class="form-floating" method="post">
<div class="mb-4 form-floating"><input type="text" class="form-control" placeholder="Enter Username" aria-label="Username" aria-describedby="basic-addon1" id="inputEmail" name="username">
<label for="inputEmail">Enter Email/Username</label>
 </div>
           <div class="form-floating">
 <input  type="password" class="form-control border-left-0" placeholder="Enter Password" aria-label="Password" aria-describedby="basic-addon2" id="inputPassword" name="password">
 <label for="inputPassword">Enter Password</label>
 </div>
 <br>
                                                    			<button style="height:35px" type="submit" name="login" class="btn btn-primary">Sign In</button>
                                                    		</div>

<a class="text-teal-dark text-underline d-flex mx-auto py-3  font-weight-light" href="index.php">Return to homepage</a>
</div>
  </div>
                                                                                         </div>

<?php include('includes/scripts.php');?>
<br>
<br>
      <?php include('includes/footer.php');?>
    </body>
</html>
