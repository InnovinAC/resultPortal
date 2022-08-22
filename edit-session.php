<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['alogin'])=="" || $_SESSION['role'] != 1)
    {   
    header("Location: admin.php"); 
    }
    else{
if(isset($_POST['update']))
{
$sesname=$_POST['sesname'];
$sql="SELECT SessionName from tblsessions where SessionName=:sesname";
$query=$dbh->prepare($sql);
$query->bindParam(':sesname',$sesname,PDO::PARAM_STR);
$query->execute();
$data=$query->fetchAll();
if($data) {
$error= "Session $sesname already exists. Try again.";
} 
else {
$sesid=intval($_GET['sesid']);
$sesname=$_POST['sesname'];
$sql="update  tblsessions set SessionName=:sesname where id=:sesid";
$query = $dbh->prepare($sql);
$query->bindParam(':sesname',$sesname,PDO::PARAM_STR);
$query->bindParam(':sesid',$sesid,PDO::PARAM_STR);
$query->execute();
$msg="Session info updated successfully.";
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Update Session</title>
       <?php include('includes/header.php');?>
      
    </head>
    <body>
                   <?php include('includes/leftbar.php');?>

                                    <ul class="bg-white border-light breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="manage-sessions.php">Sessions</a></li>
                                        <li class="breadcrumb-item active">Update Session</li>
                                    </ul>
                     <div class="container-fluid">
                               <h2 class="h2 title">Update Session</h2>
                             </div>
                        <div class="container-fluid">
                           
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title">
                                               
                                                </div>
                                          
                                       
<?php if($msg){?>
<div class="alert alert-success" role="alert">
<span class='far fa-check-circle'></span>
 <strong>Good one! </strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger" role="alert">
<span class='far fa-times-circle'></span>
                                            <strong>Oh no! </strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                <form class="form-horizontal" method="post">

 <?php
$sesid=intval($_GET['sesid']);
$sql = "SELECT SessionName from tblsessions where id=:sesid";
$query = $dbh->prepare($sql);
$query->bindParam(':sesid',$sesid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>                                               
                                                    <div class="form-group">
                                                        <label for="default" class="control-label">Session Name</label>
                                   
 <input type="text" name="sesname" value="<?php echo htmlentities($result->SessionName);?>" class="form-control" id="default" placeholder="Subject Name" required="required">
                                                        </div>
                             

                                           
                                                    <?php }?>

                                                    
                                                    <div class="form-group">
                                                            <button type="submit" name="update" class="btn btn-md btn-primary">Update</button>
                                                        </div>
                                                </form>

                                             <?php }  else {  echo "<div class='alert alert-info'>
<span class='far fa-info-circle'></span>
Sorry, the selected session does not exist. <a class='alert-link text-underline' href='manage-sessions.php'>Go back</a> and try again.</div>"; }?>
            </div>
     
        </div>
</div>
        
    </body>
     <?php include('includes/scripts.php');  include('includes/footer.php');?>
</html>
<?php } ?>
