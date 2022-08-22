<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {   
    header("Location: admin.php"); 
    }
    else{
       $sid=$_GET['sid'];
       
       // delete assignments
       // foreach($_POST
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Manage Assignments</title>
<?php include('includes/header.php'); ?>

    </head>
<body>
<?php include('includes/leftbar.php');?> 
    
  <ul class="breadcrumb">
            							<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                        
            							<li class="breadcrumb-item active"><a  href="manage-assignments.php" class="text-primary">Manage Assignments</a></li>
            						</ul>
<div class="container-fluid">
  
                                    <p class="h2 title text-center">Manage Assignments</p>
                                    <section id="printable">
                                       <div class="card">
                                          <div class="card-body">
                                             <div class="card-title"> View Assignments</div>
                                             <form class="mb-25 form-horizontal" method="get">
                                                <label class="control-label text-16">What Subject?</label>
                                            
<div class="input-group">
   <select required class="h-35 custom-select" name="sid">
                                                   <option value="" hidden selected><?php if(empty($sid)) { echo"Choose Subject"; } else { echo "Choose Another Subject"; }?> </option>
                                                   <?php 
                                                   if($_SESSION['role']!=1) {
                                                      $condition="where sc.Classid=".$_SESSION['class']; }
                                                   $query=$dbh->prepare("select sc.SubjectId, s.SubjectName from tblsubjectcombination sc join tblsubjects s on s.id=sc.SubjectId $condition order by s.SubjectName");
                                                   $query->execute();
                                                   $rows=$query->fetchAll(PDO::FETCH_OBJ);
                                                   foreach($rows as $row) { ?>
                                                      <option value="<?php echo $row->SubjectId;?>"><?php echo $row->SubjectName;?></option>
                                                      <?php } ?>
                                                         </select>
                                                        
                                                         <div class="input-group-append">
                                                            <button class="h-35 btn btn-primary" type="submit" >Go</button>
                                                   </div>
                                                   </div>
                                                   </form>
                                                   
                                                   
                                                   <?php
$sid=$_GET['sid'];
if(!empty($sid)) { ?>
   

      
   <?php
   if($_SESSION['role']!=1) {
      $condition="&& ClassId=".$_SESSION['class']." && SessionId=".$_SESSION['session']." && TermId=".$_SESSION['term']; }
   $query=$dbh->prepare("select Details,SubmissionDateTime,Topic from tblassignments where SubjectId='$sid' $condition order by SessionId desc,TermId desc,ClassId");
   $query->execute();
   $no=$query->rowCount();
   $rows=$query->fetchAll(PDO::FETCH_OBJ);
   ?>
         <p class="text-16">Showing Assignments For <b><?php echo getSubjectName(); echo "(". $no.")";?></b></p>
         <?php
   if(empty($rows)) { ?>
      
      <div class="alert alert-danger">Sorry, No assignments found</div>
      
      
      <?php
      } else {
   ?>
       <div class="row">
            <?php
   $cnt=1;
   foreach($rows as $row) {
      
?>
  <div class="col-12 col-md-6 col-lg-4 col-xl-3 ">
   <div class="card shadow-sm mb-4">
      <form method="get">
      <div class="card-header"><input type="checkbox" name="checkbox" class="custom-checkbox"> Assignment <?php echo $cnt;?></div>
      
      <div class="card-body">
         <p><b class="text-underline">Details:</b><div class="border rounded p-2"><?php echo $row->Details;?></div>
         <?php if(!empty($row->Topic)) {  echo "<br><b>Topic: </b>".$row->Topic; } ?>
</p>
         <hr>
<p><b>To be Submited on: </b> <?php echo date("d M, g:ia",strtotime($row->SubmissionDateTime));?>  </p>
</div>
</div>
</div>                               
<?php $cnt++;
}?>
      </div>
<form class="w-75 form-horizontal" name="action" method="post">
   <div class="form-group">
      <label class="control-label">With selected</label>
      <div class="input-group">
         <select required name="action-choice" class="custom-select">
            <option value="">Do nothing</option>
            <option value="del">Delete</option>
            </select>
            <div class="input-group-append">
               <button class="btn input-group-btn btn-danger" type="submit">Go</button>
               </form>
               </div>
               </div>
               </div>
               </form>
               
<?php }}?>
</div>
   </div>
   </div>
  
   </body>
   <?php include("includes/scripts.php");
   include("includes/footer.php");?>
   </html>
                                                         <?php /* $query=$dbh->prepare("Select * from tblassignments where. */ 
                                                         }?>
                                                      
                                                
                                
                      