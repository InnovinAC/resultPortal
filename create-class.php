<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {   
    header("Location: admin.php"); 
    }
    else{
if(isset($_POST['submit']))
{
$classname=ucwords($_POST['classname']);
$classnamenumeric=$_POST['classnamenumeric']; 
$sql="SELECT ClassName from tblclasses WHERE ClassName=:classname";
$sql1="SELECT ClassNameNumeric from tblclasses WHERE ClassNameNumeric='$classnamenumeric'";
$query=$dbh->prepare($sql);
$query->bindParam(':classname',$classname,PDO::PARAM_STR);
$query1=$dbh->prepare($sql1);
$query->execute();
$query1->execute();
if(!empty($query->fetchAll(PDO::FETCH_OBJ))) {
$error="The class '$classname' already exists. Try again.";
}
else if(!empty($query1->fetchAll(PDO::FETCH_OBJ))) {
$error="The class number: '$classnamenumeric' already exists. To avoid conflicts, please choose another.";
}
else {
$sql="INSERT INTO  tblclasses(ClassName,ClassNameNumeric) VALUES(:classname,:classnamenumeric)";
$query = $dbh->prepare($sql);
$query->bindParam(':classname',$classname,PDO::PARAM_STR);
$query->bindParam(':classnamenumeric',$classnamenumeric,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Class created successfully.";
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
        <title>Admin | Create Class</title>
        <?php include('includes/header.php');?>
        
    </head>
    <body>
   
<?php include('includes/leftbar.php');?> 
      <ul class="breadcrumb">
            							<li class="breadcrumb-item"><a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
            							<li class="breadcrumb-item"><a href="manage-classes.php">Classes</a></li>
            							<li class="breadcrumb-item active"><a href="create-class.php">Create Class</a></li>
            						</ul>
                        <div class="container-fluid">
                                    <h2 class="title">Create Student Class</h2>
                             
                               </div>
                            <div class="container-fluid">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h5 class="h5">Create Student Class</h5>

                                                </div>
                                          
           <?php if($msg){?>
<div class="alert alert-success" role="alert">
 <strong>Great job! </strong><?php echo htmlentities($msg); ?>
</div>
 <?php } 
else if($error){?>
    <div class="alert alert-danger" role="alert">
                                            <strong>Oh crap! </strong> <?php echo htmlentities($error); ?>
                                      </div>
                                        <?php } ?>
 

 <form method="post">
              <div class="form-group has-success">
                                                        <label for="success" class="control-label">Class Name</label>
                                                		
                                                			<input type="text" name="classname" placeholder="Eg- 9th Grade etc." class="form-control" required="required" id="success">
                                                
                                                	</div>
                                                       <div class="form-group has-success">
                                                        <label for="success" class="control-label">Class Number</label>
                                                        
                                                            <input type="number" name="classnamenumeric" placeholder="Eg 1,2,3 etc." required="required" class="form-control" id="success">
                                                     
                                                    </div>
                                         
                                                      
                                                           <button type="submit" name="submit" class="btn btn-success btn-lg">Submit</button>
                                                   


                                                    
                                                </form>

                                              
                                            </div>
                                       
                                    </div>
                           
                                </div>

                 
        </div>

<?php include('includes/footer.php');?> 
     
<?php include('includes/scripts.php');?> 

    </body>
</html>
<?php  } ?>
