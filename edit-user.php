<?php
session_start();
error_reporting(0);
include('../includes/config.php');
    $aid=intval($_GET['aid']);
if(empty($_SESSION['alogin']))
    {
    header("Location: admin.php");
    }

    else if($_SESSION['role']==1){

       if(isset($_POST['changeClass'])) {
          $class=$_POST['class'];
          $sql="update  admin set ClassId=:class where id=:aid";
$query = $dbh->prepare($sql);

$query->bindParam(':class',$class,PDO::PARAM_INT);
$query->bindParam(':aid',$aid,PDO::PARAM_INT);
$query->execute();
$msg="Teacher class changed successfully";
 if($query->execute()== false) {

   $error = "An unexpected error occured.";
   }
}



if(isset($_POST['update']))
{


$username=$_POST['username'];
$email=$_POST['email'];
$role=$_POST['role'];

$sql="update  admin set Role=:role, UserName=:username,Email=:email where id=:aid";
$query = $dbh->prepare($sql);
$query->bindParam(':username',$username,PDO::PARAM_STR);
$query->bindParam(':role',$role,PDO::PARAM_STR);
$query->bindParam(':aid',$aid,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->execute();
$msg="User Info updated successfully";
 if($query->execute()== false) {

   $error = "Try again. It's possible that the email/username already exists.";
   }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Update User Details</title>
       <?php include('includes/header.php');?>

    </head>
    <body>
                   <?php include('includes/leftbar.php');?>

                                    <ul class="bg-white border-light breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="manage-users.php">Users</a></li>
                                        <li class="breadcrumb-item active">Update User Details</li>
                                    </ul>
                     <div class="container-fluid">
                               <h2 class="h2 title">Update User</h2>
                             </div>
                        <div class="container-fluid">

                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h5 class="h5">Update User Details</h5>
                                                </div>


<?php if($msg){?>
<div class="alert alert-success" role="alert">
<span class='far fa-check-circle'></span>
 <strong>Well done! </strong><?php echo htmlentities($msg); ?>
 </div><?php }
else if($error) { ?>
    <div class="alert alert-danger" role="alert">
<span class='far fa-times-circle'></span>
                                           <strong>Something's wrong</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>

                                                <form class="form-horizontal" method="post">

 <?php

$sql = "SELECT tblclasses.id,tblclasses.ClassName,admin.ClassId,admin.Role,admin.UserName,admin.Email from admin join tblclasses on tblclasses.id=admin.ClassId where admin.id=:aid";
$query = $dbh->prepare($sql);
$query->bindParam(':aid',$aid,PDO::PARAM_STR);
$query->execute();

$result=$query->fetch();


if($result['Role'] == 1) { echo "<div class='alert alert-info'><i class='far fa-info-circle'></i> Sorry. You are not allowed to edit an administrator's account. Kindly <a href='dashboard.php' class='alert-link text-underline'>return to dashboard</a>.</div>";  }
else if($query->rowCount() > 0)
{


?>

                                                    <div class="form-group">
                                                        <label for="default" class="control-label">Username</label>

 <input type="text" name="username" value="<?php echo htmlentities($result['UserName']);?>" class="form-control" id="default" placeholder="Username" required="required">

                                                        </div>
                                                        <div class="form-group">
                                                        	<label class="control-label">Email Address</label>
                                                        	<input type="email" placeholder="Enter Email" name="email" value="<?php echo $result['Email'];?>" class="form-control" required>

                             </div>

                             <div class="form-group">
                                <label class="control-label">Class</label>
                  <input type="hidden" value="<?php echo $result['ClassId']; ?>" name="classid">
<input type="text" class="form-control" readonly value="<?php echo $result['ClassName'];?>">
</div>


<div class="form-group">
							<label for="role" class="control-label">User Role</label>





									<label class="radio-inline">
								<input type="radio" name="role" value="2" <?php if($result['Role'] == 2) { echo "checked"; }?>>Teacher
							</label>
						</div>



                                                    <div class="form-group">
                                                            <button type="submit" name="update" class="btn btn-md btn-primary">Update</button>
                                                        </div>
                                                </form>

<hr>

   <br><br>
      <div class="alert alert-info"><i class="fal fa-info-circle"></i> Use this form below to change the teacher's class</div>
      <br>
         <form class="form-horizontal" method="post">
                <div class="form-group">
							<label for="class" class="control-label">Class</label>
							<select required name="class" class="form-control" id="class">
								<option value="">Select Class</option>
								<?php
								$query=$dbh->prepare("select id, ClassName from tblclasses order by ClassNameNumeric");
								$query->execute();
								$rows=$query->fetchAll(PDO::FETCH_OBJ);
								foreach($rows as $row) { ?>
									<option value="<?php echo $row->id; ?>"><?php echo  $row->ClassName; ?></option>
									<?php } ?>
										</select>
										</div>

										<div class="form-group">
                                                            <button type="submit" name="changeClass" class="btn btn-md btn-primary">Change Class</button>
                                                        </div>
                                             <?php } else if($query->rowCount <= 0) {  echo "<div class='alert alert-info'>
<span class='far fa-info-circle'></span>
Sorry, the selected user does not exist. <a class='alert-link text-underline' href='manage-users.php'>Go back</a> and try again.</div>"; }?>
            </div>

        </div>
</div>

    </body>
     <?php include('includes/scripts.php');  include('includes/footer.php');?>
</html>
<?php }
else {
echo "Sorry you are not authorised to view this page. Go <a href='dashboard.php'> Back to the Dashboard</a>"; }?>
