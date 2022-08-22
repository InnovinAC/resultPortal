<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['alogin'])=="" || $_SESSION['role']!=1)
    {
    header("Location: admin.php");
    }
    else{
if(isset($_POST['update']))
{
$subjectName=$_POST['subjectName'];
$sql="SELECT SubjectName from tblsubjects where SubjectName=:subjectname";
$query=$dbh->prepare($sql);
$query->bindParam(':subjectname',$subjectName,PDO::PARAM_STR);
$query->execute();
$data=$query->fetchAll();
if($data) {
$error="Subject already exists. Try again.";
}
else {
$sid=intval($_GET['subjectid']);
$subjectName=$_POST['subjectName'];
$sql="update tblsubjects set SubjectName=:subjectname where id=:sid";
$query = $dbh->prepare($sql);
$query->bindParam(':subjectname',$subjectName,PDO::PARAM_STR);
$query->bindParam(':sid',$sid,PDO::PARAM_STR);
$query->execute();
$msg="Subject Info updated successfully";
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Update Subject</title>
       <?php include('includes/header.php');?>

    </head>
    <body>
                   <?php include('includes/leftbar.php');?>

                                    <ul class="bg-white border-light breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="manage-subjects.php">Subjects</a></li>
                                        <li class="breadcrumb-item active">Update Subject</li>
                                    </ul>
                     <div class="container-fluid">
                               <h3 class="h2 title">Update Subject</h3>
                             </div>
                        <div class="container-fluid">

                                        <div class="card">
                                            <div class="card-body">


<?php if($msg){?>
<div class="alert alert-success" role="alert">
<span class='far fa-check-circle'></span>
 <strong>Well done! </strong><?php echo htmlentities($msg); ?>
 </div><?php }
else if($error){?>
    <div class="alert alert-danger" role="alert">
<span class='far fa-times-circle'></span>
                                            <strong>Something's wrong! </strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                <form class="form-floating" method="post">

 <?php
$sid=intval($_GET['subjectid']);
$sql = "SELECT SubjectName from tblsubjects where id=:sid";
$query = $dbh->prepare($sql);
$query->bindParam(':sid',$sid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
                                                    <div class="form-floating mb-4">


 <input type="text" name="subjectName" value="<?php echo htmlentities($result->SubjectName);?>" class="form-control" id="subjectName" placeholder="Subject Name" required="required">
 <label for="subjectName">Subject Name</label>
                                                        </div>


                                                    <?php }?>


                                                    <div class="form-group">
                                                            <button type="submit" name="update" class="btn btn-md btn-primary">Update</button>
                                                        </div>
                                                </form>

                                             <?php }  else {  echo "<div class='alert alert-info'>
<span class='far fa-info-circle'></span>
Sorry, the selected subject does not exist. <a class='alert-link text-underline' href='manage-subjects.php'>Go back</a> and try again.</div>"; }?>
            </div>

        </div>
</div>

    </body>
     <?php include('includes/scripts.php');  include('includes/footer.php');?>
</html>
<?php } ?>
