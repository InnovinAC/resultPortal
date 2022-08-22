<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {
    header("Location: admin.php");
    }
    else{

$stid=intval($_GET['stid']);
// Code to update student information
if(isset($_POST['submit']))
{
$studentname=$_POST['fullname'];
$regnum=$_POST['regnum'];
$gender=$_POST['gender'];
$classid=$_POST['class'];
$status=$_POST['status'];
$sql="update tblstudents set StudentName=:studentname,RegNum=:regnum,Gender=:gender,Status=:status where StudentId=:stid";
$query = $dbh->prepare($sql);
$query->bindParam(':studentname',$studentname,PDO::PARAM_STR);
$query->bindParam(':regnum',$regnum,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':stid',$stid,PDO::PARAM_STR);
$query->execute();

if($query->execute()){
$msg="Student info updated successfully.";
}

else{
$error="An unexpected error has occurred. Please try again.";
}
}

/* Code to change student class on submit */
if($_POST['newclass'] != 0) {
if(isset($_POST['submits'])) {
$newclass=$_POST['newclass'];
$sql="update tblstudents set ClassId=:newclass where StudentId=:stid";
$query=$dbh->prepare($sql);
$query->bindParam(':stid',$stid,PDO::PARAM_STR);
$query->bindParam(':newclass',$newclass,PDO::PARAM_STR);
$query->execute();
if($query->execute()){
$msg="Student class changed successfully.";
}


else{
$error="An unexpected error has occurred. Please try again.";
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Admin | Edit Student Details</title>
        <?php include('includes/header.php');?>
        <link rel="stylesheet" href="../css/jquery.fancybox.min.css">
    </head>
    <body>
       <?php include('includes/leftbar.php');?>
<ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>

<li class="breadcrumb-item"><a href="manage-students.php">Students</a></li>
                                        <li class="breadcrumb-item active">Edit Student</li>
                                    </ul>
                     <div class="container-fluid">

                                    <h2 class="title">Student Admission</h2>

                        </div>
                        <div class="container-fluid">
      <div class="card">
      <div class="card-body">
       <div class="card-title">
      <h5 class="text-muted font-weight-bold">Fill The Student Info.</h5>
                                            </div>

<?php if($msg){?>
<div class="alert alert-success" role="alert">
<span class='far fa-check-circle'></span>
 <strong>Great job! </strong><?php echo htmlentities($msg); ?>
 </div><?php }
else if($error){?>
    <div class="alert alert-danger" role="alert">
<span class='far fa-times-circle'></span>
                                            <strong>Oh crap! </strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                <form class="form-floating" method="post">
<?php

$sql = "SELECT tblstudents.ClassId,tblstudents.StudentId,tblstudents.Image,tblstudents.StudentName,tblstudents.RegNum,tblstudents.RegDate,tblstudents.StudentId,tblstudents.Status,tblstudents.Gender,tblclasses.ClassName from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId where tblstudents.StudentId=:stid";
$query = $dbh->prepare($sql);
$query->bindParam(':stid',$stid,PDO::PARAM_STR);
$query->execute();
$result=$query->fetch();
$cnt=1;
if($query->rowCount() > 0)
{

   // if not school admin and not class teacher, say this
         if($_SESSION['role'] != 1 && $_SESSION['class'] != $result['ClassId']) { ?>
                <div class="alert alert-warning"><i class="far fa-info-circle"></i> Sorry, you're not allowed to edit the information of a student whom is not in your class. The selected student is currently in <b><?php echo $result['ClassName'];?></b>.</div>
                <?php } else { ?>


<div class="form-floating mb-4">
   <a href="students/<?php echo htmlentities($result['Image']);?>" data-fancybox data-caption="<?php echo $result['StudentName'];?>">
	<img class="border border-primary w-50 d-flex mx-auto p-2" src="students/<?php echo htmlentities($result['Image']);?>" alt="" />
</a>
   <span><a href="edit-student-image.php?stid=<?php echo $result['StudentId']; ?>" class="text-primary text-underline">Change Image</a></span>
      </div>
<div class="form-floating mb-4">
<input type="text" name="fullname" class="form-control" id="fullanme" value="<?php echo htmlentities($result['StudentName'])?>" required="required" autocomplete="on">
<label for="fullname">Full Name</label>
</div>

<div class="form-floating mb-4">
<input type="text" name="regnum" class="form-control" id="regnum" value="<?php echo htmlentities($result['RegNum'])?>" maxlength="20" required="required" autocomplete="on">
<label for="regnum">Registration Number</label>
</div>



<h6>Gender</h6>
<?php  $gndr=$result['Gender'];
?>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="gender" value="Male" required="required" id="male" <?php switch($gndr) { case 'Male': echo 'checked';
  break; }?>>
<label for="male" class="form-check-label">Male</label>
</div>

<div class="form-check form-check-inline">
 <input class="form-check-input" type="radio" name="gender" value="Female" id="female" required="required" <?php switch($gndr) { case 'Female': echo 'checked';
   break; }?>>
 <label for="female" class="form-check-label">Female</label>
</div>

<div class="form-check form-check-inline">
  <input id="other" type="radio" name="gender" value="Other" required="required" <?php switch($gndr) { case 'Other': echo 'checked';
    break; }?>>
  <label for="other" class="form-check-label">Other</label>
</div>







                                                    <div class="form-floating my-4">


<input type="text" name="classname" class="form-control" id="classname" value="<?php echo htmlentities($result['ClassName'])?>" readonly>
<label for="classname">Current Class</label>
</div>


<div class="form-floating mb-4">


<input class="form-control" id="date" readonly value="<?php echo date('d M, Y g:i a', strtotime(htmlentities($result['RegDate']))) ;?>" type="text">
<label for="date">Reg Date: </label>
</div>


<h6>Status</h6>
<?php  $stats=$result['Status'];

?>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" id="active" name="status" value="1" required="required" <?php switch($stats) { case 1: echo 'checked';
  break; }?>>
<label for="active" class="form-check-label">Active</label>
</div>

<div class="form-check form-check-inline">
 <input class="form-check-input" type="radio" name="status" value="0" id="blocked" required="required" <?php switch($stats) { case 0: echo 'checked';
   break; }?>>
<label for="blocked" class="form-check-label">Blocked</label>

</div>




                                                    <div class="form-group my-4">
                                                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                                        </div>

                                                </form>
<br>
   <?php if($_SESSION['role']==1) { ?>

<hr class="border border-danger border-3">
   <div role="alert" class="alert alert-info"><i class="far fa-info-circle"></i> Use this form to change <b><?php echo $result['StudentName'];?>'s</b> class</div>
<form name="second" class="form-floating" method="post">

<?php
$sql1="SELECT id,ClassName from tblclasses order by ClassNameNumeric";
$query1=$dbh->prepare($sql1);
$query1->execute();
$reslts=$query1->fetchAll(PDO::FETCH_OBJ);
?>
<div class="form-floating mb-4">
<select required placeholder="select class" class="form-select" name="newclass">
<option value="" disabled hidden selected>Select Class</option>
<?php
if($query1->rowCount() > 0)
{
foreach($reslts as $reslt)
{  ?>
<option required value="<?php echo htmlentities($reslt->id);?>"><?php echo htmlentities($reslt->ClassName);?></option>
<?php }
?>
</select>
<?php } ?>
<label>Change Student Class</label>

                                                        </div>
   <div class="form-group">
                                                            <button type="submit"  class="btn btn-primary" name="submits">Change Class</button>
                                                        </div>

</form>
<?php } ?>
</div>

                                    <?php }} else {  echo "<div class='alert alert-info'>
<span class='far fa-info-circle'></span>
Sorry, the selected student does not exist. <a class='alert-link text-underline' href='manage-students.php'>Go back</a> and try again.</div>"; }?>
                    </div>
                </div>
            </div>

        </div>

    </body>
 <?php
 include('includes/scripts.php'); ?>
 <script src="../js/jquery.fancybox.min.js"></script>
 <?php
 include('includes/footer.php');?>
</html>
<?php } ?>
