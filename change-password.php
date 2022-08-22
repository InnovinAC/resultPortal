<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {
    header("Location: admin.php");
    }
    else{
if(isset($_POST['submit']))
    {
$password=md5($_POST['password']);
$newpassword=md5($_POST['newpassword']);
$username=$_SESSION['alogin'];
$sql ="SELECT Password FROM admin WHERE UserName=:username and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update admin set Password=:newpassword where UserName=:username";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':username', $username, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
$msg="Your Password has been succesfully changed";
}
else {
$error="Your current password is incorrect.";
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Admin | Change Password</title>
<?php include('includes/header.php');?>


        <script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("Passwords do not match.");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>

    </head>
    <body>
            <?php include('includes/topbar.php');?>
<?php include('includes/leftbar.php');?>

   <ul class="breadcrumb">
            							<li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>

            							<li class="breadcrumb-item active"><a href="change-password.php">Change Password</a></li>
            						</ul>
                        <div class="container-fluid">

                                    <h3 class="h3 mb-5 text-info title">Admin Change Password</h2>
                        </div>
                            <div class="container-sm">

                                        <div class="card mb-5 border-primary shadow border-top-0 border-right-0 border-bottom-0 border-3">
                                            <div class="card-body">

           <?php if($msg){?>
<div class="alert alert-success" role="alert">
<span class="far fa-check-circle"></span>
 <strong>Great job! </strong><?php echo htmlentities($msg); ?>
</div>
 <?php }
else if($error){?>
    <div class="alert alert-danger" role="alert">
<span class="far fa-times-circle"></span>
                                            <strong>Something's wrong! </strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>


                                                <form class="form-floating" name="chngpwd" method="post" \ onSubmit="return valid();">
                                                    <div class="form-floating mb-4">


                                    <input type="password" placeholder="Current Password" name="password" class="form-control" required="required" id="success">
                                                          <label for="password">Current Password</label>
                                                	</div>


                                                       <div class="mb-4 form-floating">


                                                            <input type="password" name="newpassword" placeholder="New Password" required="required" class="form-control" id="success">
                                                     <label for="newpassword">New Password</label>
                                                    </div>
                                                     <div class="form-floating mb-4">
                                                            <input type="password" name="confirmpassword" placeholder="Confirm Password"  minimum="5" class="form-control" required="required" id="confirmpassword">
                                                      <label for="confirmpassword">Confirm Password</label>
                                                    </div>
  <div class="form-group">


                                                           <button type="submit" name="submit" class="btn btn-primary btn-lg">Change</button>
     </div>

  </form>
  </div>
            </div>
</div>


<?php include('includes/footer.php');?>



        <?php include('includes/scripts.php');?>


    </body>
</html>
<?php  } ?>
