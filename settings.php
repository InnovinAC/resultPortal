<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['alogin'])=="" || $_SESSION['role']!=1) // if username is empty or user is not an admin
    {

    header("Location: admin.php"); // redirect to login page
    }

    else{
       if(isset($_POST['submit'])) {
       $session=$_POST['session'];
       $term=$_POST['term'];
       $query=$dbh->prepare("Update tblsettings set Value=:session where SettingName='curSession'");
       $query1=$dbh->prepare("Update tblsettings set Value=:term where SettingName='curTerm'");
       $query->bindParam(':session',$session,PDO::PARAM_STR);
              $query1->bindParam(':term',$term,PDO::PARAM_STR);
       $query->execute();
       $query1->execute();

       if($query->execute() && $query1->execute()) {
          $msg= "Settings changed successfully.";
$_SESSION['session']=$_POST['session'];  // update the session variabe as well.
$_SESSION['term']=$_POST['term']; // do the same update for the term session variable.
       } else {
             $error="An unexpected error occurred. Try again.";
             }




       }




       ?>
       <!Doctype HTML>
          <html lang="en">
             <head>
                   <title>Admin |  Change Settings</title>
 <?php include('includes/header.php');?>

    </head>
    <body>
      <?php include('includes/leftbar.php');?>

  <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>

                                        <li class="breadcrumb-item active"><a href="settings.php">Settings</a></li>
                                    </ul>
                     <div class="container-fluid">
                   <h2 class="h2 title"><i class="far fa-cog"></i> Change Settings</h2>

                                </div>
                        <div class="container-fluid">
                                        <div class="card">
                                            <div class="card-body">
                                             <label class="control-label">Current Session</label>

                                             <?php $query=$dbh->prepare("Select SessionName from tblsessions where id=".$_SESSION['session']);
                                             $query1=$dbh->prepare("select TermName from tblterms where id=".$_SESSION['term']);
                                             $query->execute();
                                             $query1->execute();
                                             $curTerm=$query1->fetch();
                                             $curSession=$query->fetch();
                                             ?>

                                                <?php if($msg) { ?>
                                                   <div class="alert alert-success" role="alert"><i class="far fa-check-circle"></i> Good job! <?php echo $msg; ?></div> <?php } else if($error) { ?>
                                                                <div class="alert alert-danger" role="alert"><i class="far fa-times-circle"></i>
Sorry! <?php echo $error; ?></div> <?php } ?>

                                                <br><div class="mb-4">Current Session is <?php echo "<b>".$curSession['SessionName']."</b>"; ?>. Current Term is <b><?php echo $curTerm['TermName']; ?></b> .Use the below form to change it.</div>
                                                <form class="form-horizontal" method="post">
                                                   <div class="mb-4 form-floating">

                                                   <select required name="session" class="form-select">
                                                      <option hidden selected value="">Select Session</option>
                                                      <?php
                                                      $query=$dbh->prepare("SELECT id,SessionName from tblsessions order by SessionName asc");
                                                      $query->execute();
                                                      $result=$query->fetchAll(PDO::FETCH_OBJ);
                                                      foreach($result as $row) {
                                                         ?>
                                                            <option value="<?php echo $row->id; ?>"><?php echo $row->SessionName; ?></option>
                                                            <?php } ?>
                                                               </select>
                                                                  <label>Session</label>
                                                               </div>


                                                               <div class="form-floating mb-4">

                                                                  <select name="term" class="form-select">
                                                                     <option value="" hidden selected>Select Term</option>
                                                                     <?php
                                                      $query=$dbh->prepare("SELECT id,TermName from tblterms order by TermName asc");
                                                      $query->execute();
                                                      $result=$query->fetchAll(PDO::FETCH_OBJ);
                                                      foreach($result as $row) {
                                                         ?>
                                                            <option value="<?php echo $row->id; ?>"><?php echo $row->TermName; ?></option>
                                                            <?php } ?>
                                                               </select>
                                                                 <label class="control-label">Term</label>
                                                               </div>

                                                                  <button type="submit" name="submit" class="btn btn-primary">Change Settings</button>
                                                </div>


                                                </div>
                                                </div></div>

                                                </body>
                                                <?php include('includes/scripts.php'); include('includes/footer.php'); ?>
                                                </html>

                                                <?php } ?>
