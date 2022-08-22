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

$sesname=$_POST['year1']."/".$_POST['year2'];
$sql="SELECT SessionName FROM tblsessions WHERE SessionName=:sesname";
$query = $dbh->prepare($sql);
$query->bindParam(':sesname',$sesname,PDO::PARAM_STR);
$query->execute();
$data=$query->fetchAll();
if(!empty($data)) {
$error="An academic session already exists with that name. Try again.";
}
else{
$sesname=$_POST['year1']."/".$_POST['year2'];
$sql="INSERT INTO tblsessions(SessionName) VALUES(:sesname)";
$query = $dbh->prepare($sql);
$query->bindParam(':sesname',$sesname,PDO::PARAM_STR);
$query->execute();
$error1=$query->errorInfo();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Session Created successfully.";
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

        <title>Admin | Create Session </title>
        <?php include('includes/header.php');?>

    </head>
    <body>

                   <?php include('includes/leftbar.php');?>


  <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="manage-sessions.php">Sessions</a></li>
                                        <li class="breadcrumb-item active"><a href="create-session.php">Create Session</a></li>
                                    </ul>
                     <div class="container-fluid">
                                    <h2 class="title">Session Creation</h2>
                        </div>
                        <div class="container-fluid">

                <div class="card">
                                            <div class="card-body">

                                                <div class="card-title">
                                                    <h5 class="text-muted font-weight-bolder h5">Create Session.</h5>
                                            </div>
                                           <?php if($_SESSION['role']!=1) { ?>
                                              <div class="alert alert-warning"><i class="far fa-info-circle"></i> Sorry, you are not allowed access to this page. Kindly <a href="dashboard.php" class="alert-link text-underline">return to dashboard</a>.</div> <?php }  else {?>
<?php if($msg){?>
<div class="alert alert-success" role="alert">
<span class="far fa-check-circle"></span>
 <strong>Great job! </strong><?php echo htmlentities($msg); ?>
 </div><?php }
else if($error){?>
    <div class="alert alert-danger" role="alert">
<span class="far fa-times-circle"></span>
                                            <strong>Oh crap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>

                                                <form class="form-horizontal" method="post">
                                                  <div class="row mb-3 g-3">
                                                      <div class="col-6">
                                                    <div class="form-floating">



 <select   name="year1" class="form-select" placeholder="eg 2019/2020" required="required">
 <option hidden selected value="">Select year 1</option>
 <?php

for($date=(date('Y')-4);$date<=(date('Y')+10);$date++) { ?>
    <option value="<?php echo $date; ?>"><?php echo $date;?></option>
    <?php } ?>
       </select>
<label for="default" >Session Name(<small>Eg 2019/2020</small>)</label>
       </div>

     </div>

  <div class="col-6">
    <div class="form-floating">

           <select   name="year2" class="form-select" placeholder="eg 2019/2020" required="required">
 <option hidden selected value="">Select year 2</option>
 <?php

for($date1=(date('Y')-4);$date1<=(date('Y')+10);$date1++) { ?>
    <option value="<?php echo $date1; ?>"><?php echo $date1;?></option>
    <?php } ?>
       </select>
       <label for="default" >Session Name(<small>Eg 2019/2020</small>)</label>
       </div>

      </div>


                                                    </div>

                                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>


                                                </form>
                                                <?php } ?>
                </div>

            </div>
        </div>


    </body>
<?php include('includes/scripts.php'); include('includes/footer.php'); ?>

</html>
<?php } ?>
