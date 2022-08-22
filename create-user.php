<?php
session_start();
error_reporting(1);
include('../includes/config.php');

// Redirect to login page if not logged in
if(empty($_SESSION['alogin'])) {
header("Location: admin.php");
}

else if($_SESSION['role']!=1 && !empty($_SESSION['alogin']) ) {
include('includes/header.php');
include ('includes/leftbar.php');
echo "<div class='px-4 container-fluid'><div role='alert' class='px-3 alert mt-4 alert-info'>Sorry. You are not allowed to add new admin accounts. Please <a href='dashboard.php' class='alert-link text-underline font-weight-bold'>Go back to the dashboard</a>.</div></div>";
include('includes/scripts.php'); include('includes/footer.php'); }
else if((!empty($_SESSION['alogin']) && $_SESSION['role']=1)) {
include('includes/header.php');
include ('includes/leftbar.php');
if(isset($_POST['submit'])) {
$username = strtolower($_POST['username']);
$password = $_POST['password'];
$email = strtolower($_POST['email']);


if(strlen($username)<=2) {
$error[] ="<div class='alert alert-danger'><i class='far fa-times-circle'></i> Username must be more than 2 characters</div>";

}
$unameCheck=$dbh->prepare("SELECT id FROM admin where UserName=:username");
$emailCheck=$dbh->prepare("SELECT id FROM admin where Email=:email");
$unameCheck->execute(array(':username'=>$username));
$emailCheck->execute(array(':email'=>$email));
$count=$unameCheck->rowCount();
$count1=$emailCheck->rowCount();
if($count > 0) {
   $error[]="<div class='alert alert-danger'><i class='far fa-times-circle'></i> Username has already been taken.</div>"; }
   else if($count1 > 0) {
      $error[]="<div class='alert alert-danger'><i class='far fa-times-circle'></i> Email already exists.</div>"; }
else {
$username = strtolower($_POST['username']);
$password = md5($_POST['password']);
$role = $_POST['role'];
$email = strtolower($_POST['email']);
$class=$_POST['class'];

$sql1= "INSERT INTO admin(ClassId,Email,UserName,Password,Role) VALUES(:class,:email,:username,:password,2)";
$query1= $dbh->prepare($sql1);
$query1-> bindParam(':username',$username,PDO::PARAM_STR);
$query1->bindParam(':password',$password,PDO::PARAM_STR);
$query1->bindParam(':email',$email, PDO::PARAM_STR);
$query1->bindParam(':class',$class,PDO::PARAM_INT);
$query1->execute();
$lastInsertId=$dbh->lastInsertId();
if($lastInsertId) {
$msg="User account has been successfully created";
} else {
   $error[] = "<div class='alert alert-danger'><i class='far fa-times-circle'></i> Username/email address already exists</div>";
   }
   }
   }
   if(!empty($error)) {
$error=implode("",$error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin | Create New Teacher Account</title>
</head>
<body>
   <ul class="border border-muted breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard.php"><span class="far fa-home"></span> Dashboard</a></li>
      <li class="breadcrumb-item"><a href="create-user.php">Add New Teacher</a></li>
      </ul>

<div class="mt-5 container">


<?php if($msg) { ?><div role='alert' class='alert alert-success'>
<span class="far fa-check-circle"></span>
<strong>Great job!</strong> <?php echo htmlentities($msg);?> <a href='dashboard.php' class='alert-link text-underline font-weight-bold'>Return to dashboard</a>.</div>
<?php } else if(!empty($error)) { echo $error; } ?>
<div class="card-title h4 mb-4 text-info font-weight-bold">Create New Teacher</div>
<form autocomplete="off" method="post" class="px-3 form-floating">

  <div class="row">
    <div class="col-6">
<div class="form-floating mb-4">

<input required type="text" class="form-control" id="example" name="username" autocomplete="off" placeholder="Enter Username.">
<label for="username"><span class='fal fa-user'></span> Username:</label>
</div>
</div>

  <div class="col-6">
<div class="form-floating mb-4">

<input required type="email" class="form-control" name="email" id="email" placeholder="Enter email address">
<label for="email" ><span class='fal fa-envelope'></span> Email:</label>
</div>
</div>

  <div class="col-6">
<div class="form-floating">


<input required type="password" class="border-right-0 form-control" name="password" id="password" placeholder="Enter password.">


<label for="password"><span class='fal fa-key'></span> Password:</label>
</div>
<a href="#password" class="" id="toggle_pwd">Show Password</a>
</div>

  <div class="col-6">
						<div class="form-floating">

							<select required name="class" class="form-select" id="class">
								<option selected>Select Class</option>
								<?php
								$query=$dbh->prepare("select id, ClassName from tblclasses where ClassName != 'Graduated' order by ClassNameNumeric");
								$query->execute();
								$rows=$query->fetchAll(PDO::FETCH_OBJ);
								foreach($rows as $row) { ?>
									<option value="<?php echo $row->id; ?>"><?php echo  $row->ClassName; ?></option>
									<?php } ?>
										</select>
                    		<label for="class">Class</label>
										</div>
                  </div>
						<button type="submit" class="btn mx-auto w-25  btn-primary mb-2" name="submit">Create User</button>
<p class="pl-4"><a href="dashboard.php" class="h6">Back to dashboard --></a></p>

</div>
</div>
</body>
<?php include('includes/scripts.php'); include('includes/footer.php');?>
<script>$(function () {
            $("#toggle_pwd").click(function () {
                 var passInput=$("#password");
              if(passInput.attr('type')==='password') {
                document.getElementById("toggle_pwd").innerHTML = "Hide Password";
                 passInput.attr('type','text');
              }
              else {
                  document.getElementById("toggle_pwd").innerHTML = "Show Password";
                  passInput.attr('type','password');
              }

            });
        });
    </script>
</html>
<?php  }?>
