<?php 
session_start();
error_reporting(0);
include('../includes/config.php');
// If not logged in, redirect to login page
if(empty($_SESSION['alogin']))
    {   
    header("Location: admin.php"); 
    }
    else{
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Admin | Delete Result</title>
<?php include('includes/header.php');?>
</head>
<body>
<?php include('includes/leftbar.php'); include('includes/scripts.php');?>
<div class="container-fluid">
<div class="mt-25 card">
<div class="cad-body">
<div class="card-title">
<p class="text-muted py-2 font-weight-bold text-center border-muted">Are you sure you want to delete the result of the student below?(NB: This action cannot be reversed afterwards).</p>
</div>
<?php 
// Of course we should assign variables to the IDs in URL
$stid=intval($_GET['stid']);
$tid=intval($_GET['tid']);
$cid=intval($_GET['cid']);
$sesid=intval($_GET['sesid']);?>
<?php if(isset($_POST['submits']))
{

// Code to delete result based on info from URL
$sql="DELETE FROM tblresult WHERE TermId=:tid and SessionId=:sesid and ClassId=:cid and StudentId=:stid";
$query = $dbh->prepare($sql);
$query1=$dbh->prepare("DELETE FROM tblmarks WHERE TermId=:tid and SessionId=:sesid and ClassId=:cid and StudentId=:stid");
$query2=$dbh->prepare("DELETE FROM tblremarks WHERE TermId=:tid and SessionId=:sesid and ClassId=:cid and StudentId=:stid");
$query3=$dbh->prepare("DELETE FROM tblratings WHERE TermId=:tid and SessionId=:sesid and ClassId=:cid and StudentId=:stid");
$query4=$dbh->prepare("DELETE FROM tblnextfees WHERE TermId=:tid and SessionId=:sesid and ClassId=:cid and StudentId=:stid");
$query->bindParam(':tid',$tid,PDO::PARAM_STR);
$query->bindParam(':sesid',$sesid,PDO::PARAM_STR);
$query->bindParam(':cid',$cid,PDO::PARAM_STR);
$query->bindParam(':stid',$stid,PDO::PARAM_STR);

$query1->bindParam(':tid',$tid,PDO::PARAM_STR);
$query1->bindParam(':sesid',$sesid,PDO::PARAM_STR);
$query1->bindParam(':cid',$cid,PDO::PARAM_STR);
$query1->bindParam(':stid',$stid,PDO::PARAM_STR);

$query2->bindParam(':tid',$tid,PDO::PARAM_STR);
$query2->bindParam(':sesid',$sesid,PDO::PARAM_STR);
$query2->bindParam(':cid',$cid,PDO::PARAM_STR);
$query2->bindParam(':stid',$stid,PDO::PARAM_STR);

$query3->bindParam(':tid',$tid,PDO::PARAM_STR);
$query3->bindParam(':sesid',$sesid,PDO::PARAM_STR);
$query3->bindParam(':cid',$cid,PDO::PARAM_STR);
$query3->bindParam(':stid',$stid,PDO::PARAM_STR);

$query4->bindParam(':tid',$tid,PDO::PARAM_STR);
$query4->bindParam(':sesid',$sesid,PDO::PARAM_STR);
$query4->bindParam(':cid',$cid,PDO::PARAM_STR);
$query4->bindParam(':stid',$stid,PDO::PARAM_STR);


$query->execute();
$query1->execute();
$query2->execute();
$query3->execute();
$query4->execute();
$msg="Result deleted successfully.";
}
?>

<?php if($msg) { echo "<div class='alert alert-success'>
<span class='far fa-check-circle'></span>
$msg <a class='text-underline alert-link' href='manage-results.php'>Go back</a></div>"; }?>
<!-- Form Start -->
<form method="post">
<?php
// Show student details(This will show the class indicated on the result instead of the student's current class)
$sql1 = "SELECT tblstudents.StudentName,tblsessions.SessionName,tblclasses.ClassName,tblstudents.RegNum,tblterms.TermName from tblresult join tblsessions on tblsessions.id=tblresult.SessionId join tblstudents on tblstudents.StudentId=tblresult.StudentId join tblclasses on tblclasses.id=tblresult.ClassId join tblterms on tblterms.id=tblresult.TermId where (tblresult.StudentId=:stid and tblresult.TermId=:tid and tblresult.SessionId=:sesid and tblresult.ClassId=:cid) limit 1";
$query1 = $dbh->prepare($sql1);
$query1->bindParam(':stid',$stid,PDO::PARAM_STR);
$query1->bindParam(':tid',$tid,PDO::PARAM_STR);
$query1->bindParam(':sesid',$sesid,PDO::PARAM_STR);
$query1->bindParam(':cid',$cid,PDO::PARAM_STR);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
$cnt1=1;
if($query1->rowCount() > 0)
{
foreach($results1 as $result1)
{   ?>                                               
<div class="container">
<table class="table table-bordered table-striped" width="100%">
      <tbody>
                                                    <tr>

                                                        <td><strong>Student Name</strong></td>
                                  <td> <?php echo htmlentities($result1->StudentName);?></td>
</tr>

                                     
     <tr>
                                                        <td><strong>Registration Number</strong></td>
                                  <td> <?php echo htmlentities($result1->RegNum);?></td>

                                          </tr>

                   <tr>
                                                        <td><strong>Class</strong></td>
                                   <td><?php echo htmlentities($result1->ClassName);?></td>
</tr>
 <tr>
                                                        <td><strong>Term</strong></td>
                                   <td><?php echo htmlentities($result1->TermName);?></td>
</tr>
<tr>
<td><strong>Academic Session</strong></td>
                                   <td><?php echo htmlentities($result1->SessionName);?></td>
</tr>
</tbody>
                                           </table>
                                           </div>
                                                    <?php }?>

                                                    
                                                    <div class="text-center ml-2 form-group">
                                                         
<button type="submit" name="submits" class="btn btn-danger">Delete Now</button>
<a class="btn btn-success" href="manage-results.php">Cancel</a>

                                                        </div>
                                                </form>

<?php }} if(!$results1 and !$msg){  echo"<div class='mx-2 alert alert-info'>
<span class='far fa-info-circle'></span>
The selected result does not exist or has already been deleted. Please <a href='manage-results.php' class='text-underline alert-link'>Go back</a> and select a valid result.</div>" ;}?>
</div>
</div>
</div>
</body>
<?php include('includes/footer.php');
?>
</html>
