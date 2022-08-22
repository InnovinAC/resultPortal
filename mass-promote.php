<?php 
session_start();
error_reporting(0);
include('../includes/config.php');
if($_SESSION['alogin']=="" || $_SESSION['role']!=1)
    {   
    header("Location: admin.php"); 
    }
    
    else if($_SESSION['role']==1) {
if(isset($_POST['submit']))
{
	$query = $dbh->prepare("Select MAX(id) as max from tblclasses");
$query->execute();
$lastId= $query->fetch();

$sql="update tblstudents set ClassId=ClassId+1 where ClassId < :lastId";
$query1=$dbh->prepare ($sql);
$query1->bindParam(':lastId',$lastId['max'],PDO::PARAM_STR);
$query1->execute();
$msg="All Students have been promoted to the next class";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin | Mass Promote Students</title>
<?php
include('includes/header.php');


include('includes/leftbar.php');
?>
	<body>
<br>
<div class='container-fluid'>
   <div class="alert mb-50 alert-info"><i class="far fa-info-circle"></i> Clicking the button below will promote all students to the next class</div>
<form method="post" class='form-horizontal'>
<button onclick="return confirm('Are you sure you want to promote all students to the next class?')" type="submit" name="submit" class='btn-primary btn-lg'>Promote All Students To Next Class</button>
</form>
</div>	
<?php if($msg){ echo "<div class='alert alert-success'>$msg</div>"; } 

?>
	<br>
		<div class="mb-4 container">
			<a class="btn btn-orange" href="dashboard.php">Return to dashboard</a>
			</div>
	<?php include "includes/scripts.php"; ?>
	</body>
	<?php include "includes/footer.php"; ?>
	</html>
	
	<?php } ?>