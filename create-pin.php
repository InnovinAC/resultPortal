<?php
session_start();
// error_reporting(0);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {   
    header("Location: admin.php"); 
    }
    else{
if(isset($_POST['submit']))
{
$pin=$_POST['pin'];
$trial=$_POST['trial']; 
$sql="SELECT Pin from tblpins WHERE Pin=:pin";
$query=$dbh->prepare($sql);
$query->bindParam(':pin',$pin,PDO::PARAM_STR);
$query->execute();
if(!empty($query->fetchAll(PDO::FETCH_OBJ))) {
$error="The pin '$pin' already exists. Try again.";
}

else {
$sql="INSERT INTO  tblpins(Pin,Trials) VALUES(:pin,:trial)";
$query = $dbh->prepare($sql);
$query->bindParam(':pin',$pin,PDO::PARAM_STR);
$query->bindParam(':trial',$trial,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Pin created successfully.";
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
        <title>Admin | Create Pin</title>
        <?php include('includes/header.php');?>
        
    </head>
    <body>
   
<?php include('includes/leftbar.php');?> 
      <ul class="breadcrumb">
            							<li class="breadcrumb-item"><a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
            							<li class="breadcrumb-item"><a href="manage-pins.php">Pins</a></li>
            							<li class="breadcrumb-item active"><a href="create-pin.php">Create Pin</a></li>
            						</ul>
                        <div class="container-fluid">
                                    <h3 class="mb-5 title">Create New Pin</h3>
                             
                               </div>
                            <div class="container-sm">
                                        <div class="mb-5 card">
                                            <div class="card-body">
                                          
           <?php if(!empty($msg)){?>
<div class="alert alert-success" role="alert">
 <strong>Great job! </strong><?php echo htmlentities($msg); ?>
</div>
 <?php } 
else if(!empty($error)){?>
    <div class="alert alert-danger" role="alert">
                                            <strong>Oh crap! </strong> <?php echo htmlentities($error); ?>
                                      </div>
                                        <?php } ?>
 

 <form method="post" class="form-floating">
              <div class="form-floating mb-4">
                                                       
                                                		
                                                			<input type="text" name="pin" placeholder="eg 1xThuoFDB1@" class="form-control" required="required" id="pin">
                                                 <label for="pin">Enter Pin Name</label>
                                                	</div>
                                                       <div class="form-floating mb-4">
                                                        <label for="trials">Number of Allowed Usages</label>
                                                        
                                                            <input type="number" name="trial" placeholder="Eg 1,2,3 etc." required="required" class="form-control" id="trials">
                                                       <label for="trials">Number of Allowed Usages</label>
                                                    </div>
                                         
                                                      
                                                           <button type="submit" name="submit" class="btn btn-success btn">Submit</button>
                                                   


                                                    
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