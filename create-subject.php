<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {   
    header("Location: admin.php"); 
    }
    else{

$subjectname=ucfirst($_POST['subjectname']);
if(isset($_POST['submit']))
{

$sql="SELECT SubjectName FROM tblsubjects WHERE SubjectName=:subjectname";
$query = $dbh->prepare($sql);
$query->bindParam(':subjectname',$subjectname,PDO::PARAM_STR);
$query->execute();

if($query->rowCount() > 0) {
$error="The subject <b>".$subjectname."</b> already exists in the database.";
}
else{
$subjectname=ucfirst($_POST['subjectname']);
$sql="INSERT INTO  tblsubjects(SubjectName) VALUES(:subjectname)";
$query = $dbh->prepare($sql);
$query->bindParam(':subjectname',$subjectname,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Subject Created successfully.";
}
else 
{
$error="Something went wrong. Please try again.";
}

}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <title>Admin | Create Subject </title>
        <?php include('includes/header.php');?>
        
    </head>
    <body>
     
                   <?php include('includes/leftbar.php');?>  
       

  <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="manage-subjects.php">Subjects</a></li>
                                        <li class="breadcrumb-item active"><a href="create-subject.php">Create Subject</a></li>
                                    </ul>    
                     <div class="container-fluid">
                                    <h2 class="title">Subject Creation</h2>
                        </div>
                        <div class="container-fluid">
                           
                <div class="card">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h5 class="h5">Create Subject</h5>
                                            </div>
                                           
<?php if($msg){?>
<div class="alert alert-success" role="alert">
<span class="far fa-check-circle"></span>
 <strong>Great job! </strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger" role="alert">
<span class="far fa-times-circle"></span>
                                            <strong>Oh crap!</strong> <?php echo $error; ?>
                                        </div>
                                        <?php } ?>
                                                <form class="form-floating" method="post">
                                                    <div class="mb-4 form-floating">
                                                        
                                                     
 <input type="text" name="subjectname" class="form-control" id="subjectName" placeholder="Subject Name" required="required">
 <label for="subjectName">Subject Name</label>
                                                       
                                                    </div>
                                                    

                                                    
                                             
                                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                      
                                                   
                                                </form>

                                           
                                        
                </div>
           
            </div>
        </div>
     
      
    </body>
<?php include('includes/scripts.php'); include('includes/footer.php'); ?>
</html>
<?php } ?>
