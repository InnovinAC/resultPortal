<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {   
    header("Location: admin.php"); 
    }
    else{
if(isset($_POST['update']))
{
$classname=$_POST['classname'];
$classnamenumeric=$_POST['classnamenumeric']; 
$cid=intval($_GET['classid']);
$sql="update  tblclasses set ClassName=:classname,ClassNameNumeric=:classnamenumeric where id=:cid ";
$query = $dbh->prepare($sql);
$query->bindParam(':classname',$classname,PDO::PARAM_STR);
$query->bindParam(':classnamenumeric',$classnamenumeric,PDO::PARAM_STR);
$query->bindParam(':cid',$cid,PDO::PARAM_STR);
$query->execute();
if($query->execute()) {
$msg="Class info has been updated successfully.";
}
else {
$error="An error occurred. Please try again.";
}}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <title>Admin | Update Class</title>
        <?php include('includes/header.php');?>
        
    </head>
    <body>
        
<?php include('includes/leftbar.php');?>    
               
 <ul class="border border-white breadcrumb">
            							<li class=" breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
            							<li class="breadcrumb-item"><a href="manage-classes.php">Classes</a></li>
            							<li class="breadcrumb-item active">Update Class</li>
            						</ul>
                        <div class="container-fluid">
                            
                                    <h2 class="h2 title">Update Class</h2>
</div>
               
                            <div class="container-fluid">

<div class="card">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h5 class="h5">Update Class Info</h5>
                                                
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

                                                <form method="post">
<?php 
$cid=intval($_GET['classid']);
$sql = "SELECT * from tblclasses where id=:cid";
$query = $dbh->prepare($sql);
$query->bindParam(':cid',$cid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>

                                                    <div class="form-group has-success">
                                                        <label for="success" class="control-label">Class Name</label>
                                                			<input type="text" name="classname" value="<?php echo htmlentities($result->ClassName);?>" required="required" class="form-control" id="success">
                                                            <span class="help-block">Eg- SS1, SS2,SS3 etc.</span>
                                                	
                                                	</div>
                                                       <div class="form-group has-success">
                                                        <label for="success" class="control-label">Class Name in Numeric</label>
                                                        
                                                            <input type="number" name="classnamenumeric" value="<?php echo htmlentities($result->ClassNameNumeric);?>" required="required" class="form-control" id="success">
                                                            <span class="help-block">Eg- 1,2,4,5 etc.</span>
                                                      
                                                    </div>
                                                     
                                                    <?php } ?>
  <div class="form-group has-success">

                                                        
                                                           <button type="submit" name="update" class="btn btn-success btn-lg">Update</button>
                                                   


                                                    
                                                </form>

                                              
   <?php }  else {  echo "<div class='alert alert-info'>
<span class='far fa-info-circle'></span>
Sorry, the selected class does not exist. <a class='alert-link text-underline' href='manage-classes.php'>Go back</a> and try again.</div>"; }?>
                                            </div>
                                        </div>
                             

                </div>
             
            </div>
     

        </div>
    

        <?php include('includes/footer.php'); include('includes/scripts.php');?>



        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
    </body>
</html>
<?php  } ?>
