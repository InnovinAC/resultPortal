<?php 
session_start();
error_reporting(0);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {   
    header("Location: admin.php"); 
    }
    else{
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Admin | Delete Class</title>
<?php include('includes/header.php');?>
</head>
<body>
<?php include('includes/leftbar.php');?>
<?php include('includes/scripts.php');?>
<div class="container-fluid">
<div class="mt-25 card">
<div class="cad-body">
<div class="card-title">
<p class="h6 px-1 text-center text-muted font-weight-bold">Are you sure you want to delete the following?(NB: This action cannot be reversed afterwards.)</p>
</div>
<?php 
$cid=intval($_GET['classid']);
?>
<?php if(isset($_POST['submits']))
{

$sql="DELETE FROM tblclasses WHERE id=:cid";
$query = $dbh->prepare($sql);
$query->bindParam(':cid',$cid,PDO::PARAM_STR);
$query->execute();
$msg="Subject deleted successfully.";
}
?>

<?php if($msg) { echo "<div class='alert alert-info'>
<span class='far fa-check-circle'></span>
$msg <a class='text-underline alert-link' href='manage-classes.php'>Go back</a></div>"; }?>
<!-- Form Start -->
<form method="post">
<?php
$sql = "SELECT ClassName,ClassNameNumeric from tblclasses where id=:cid";
$query = $dbh->prepare($sql);
$query->bindParam(':cid',$cid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>                                         
      
                                     
<div class="container">
<table class="table table-bordered table-striped" width="100%">
      <tbody>
                                                    <tr>

                                                        <td><strong>Class Name</strong></td>
                                  <td> <?php echo htmlentities($result->ClassName);?></td>
</tr>


                   <tr>
                                                        <td><strong>Class Number</strong></td>
                                   <td><?php echo htmlentities($result->ClassNameNumeric);?></td>
</tr>
</tbody>
                                           </table>
                                           </div>
                                               
               
                                           
                                                    <?php }?>

                                                   
                                                    <div class="text-center form-group">
                                                         
<button type="submit" name="submits" class="btn btn-danger btn-lg">Delete Now</button>
<a class="btn btn-success btn-lg" href="manage-classes.php">Cancel</a>

                                                        </div>
                                                </form>

<?php }} if(!$results and !$msg){  echo"<div class='mx-2 alert alert-info'>
<span class='far fa-info-circle'></span>
The selected class does not exist or has already been deleted. <a href='manage-classes.php' class='text-underline alert-link'>Go back</a>.</div>" ;}?>
</div>
</div>
</div>
</body>
<?php include('includes/footer.php');
?>
</html>
