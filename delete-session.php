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
<title>Admin | Delete Session</title>
<?php include('includes/header.php');?>
</head>
<body>
<?php include('includes/leftbar.php');?>
<?php include('includes/scripts.php');?>
<div class="container-fluid">
<div class="mt-25 card">
<div class="card-body">
<div class="card-title">
<p class="h6 text-center border-muted border-bottom">Are you sure you want to delete the following?(This cannot be undone.)</p>
</div>

<?php if(isset($_POST['submits']))
{


$sesid=intval($_GET['sesid']);
$sql="DELETE FROM tblsessions WHERE id=:sesid";
$query = $dbh->prepare($sql);
$query->bindParam(':sesid',$sesid,PDO::PARAM_STR);
$query->execute();
$msg="Session deleted successfully.";
}
?>

<?php if($msg) { echo "<div class='alert alert-success'>
<span class='far fa-check-circle'></span>
$msg <a class='text-underline alert-link' href='manage-sessions.php'>Go back</a></div>"; }?>
<!-- Form Start -->
<form method="post">
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
                                                    <div class="ml-2 form-group">
                                                        <label for="default" class="control-label font-weight-bold h5">Session Name:</label>
                                   <?php echo htmlentities($result->SessionName);?>
                                                        </div>



                                                    <?php }?>

                                                    <hr>
                                                    <div class="ml-2 form-group">
                                             <a class="btn btn-info" href="manage-sessions.php">Cancel</a>
<button type="submit" name="submits" class="btn btn-danger">Delete Now</button>


                                                        </div>
                                                </form>

<?php }} if(!$result and !$msg){  echo"<div class='mx-2 alert alert-info'>
<span class='far fa-info-circle'></span>
Session does not exist or has already been deleted. <a href='manage-sessions.php' class='text-underline alert-link'>Go back</a>.</div>" ;}?>
</div>
</div>
</div>
</body>
<?php include('includes/footer.php');
?>
</html>
