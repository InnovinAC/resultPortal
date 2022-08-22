<?php
session_start();
error_reporting(0)
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {   
    header("Location: admin.php"); 
    }
    else {
       if
       
       
       
       
       
       
       
       
       
       
       <!DOCTYPE html>
<html lang="en">
    <head>
        
        <title>Admin | Create Assignment </title>
        <?php include('includes/header.php');?>
        <link href="../plugins/summernote/summernote-lite.min.css" rel="stylesheet"> 
       <link href="../plugins/summernote/summernote-bs4.min.css" rel="stylesheet"> 
           <script>
function getSubject(val) {
$.ajax({
        type: "POST",
        url: "get_subject.php",
        data:'classid='+val,
        success: function(data){
            $("#subject").html(data);
            
        }
        });
}
    </script>
    </head>
    <body>
     
                   <?php include('includes/leftbar.php');?>  
       

  <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="manage-assignments.php">Assignments</a></li>
                                        <li class="breadcrumb-item active"><a href="create-assignment.php">Create Assignment</a></li>
                                    </ul>    
                     <div class="container-fluid">
                                    <h2 class="title">Assignment Creation</h2>
                        </div>
                        <div class="container-fluid">
                           
                <div class="card">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h5 class="text-muted font-weight-bolder h5">Create Assignment.</h5>
                                            </div>
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
                                                    <div class="form-group">
                                                        <label for="summernote" class="control-label">Assignment Details<span class="text-vermillion">*</span></label>
                                                     
 <textarea class="summernote" name="details" id="summernote" required></textarea>
      
                                                    </div>
                                     
                       <div class="form-group">
<label for="clasdid" class="control-label">Class<span class="text-vermillion">*</span></label>
 
 <select name="class" class="bg-light form-control clid" id="classid" onChange="getSubject(this.value);" required="required">
<option value="">Select Class</option>
<?php $sql = "SELECT id,ClassName from tblclasses order by ClassNameNumeric";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp;</option>
<?php }} ?>
 </select>
                                                        </div>
   <div class="form-group">
<label for="session" class="control-label">Academic Session<span class="text-vermillion">*</span></label>
<select class="bg-light form-control" name="session" required="" id="session">
<option value="">Select Academic Session</option>
<?php

$sql="SELECT id,SessionName from tblsessions order by SessionName";
$query=$dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0) {
foreach($results as $result) {
?>

<option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->SessionName);?></option>
<?php }} ?>
</select>
</div>
 
     <div class="form-group">
<label for="default" class="control-label">Term<span class="text-vermillion">*</span></label>
 
 <select name="term" class="bg-light form-control" required="required">
<option value="">Select Term</option>
<?php $sql = "SELECT id,TermName from tblterms order by TermName";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
<option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->TermName); ?>&nbsp;</option>
<?php }} ?>
 </select>
                                                        </div>

                                           
<div class="form-group">
                                                        <label for="subject" class="control-label">Subject<span class="text-danger">*</span></label>
                                                      
                                         <div id="subject">
                                                    
                                                   </div>
                                                    </div>
<div class="form-group">
   <label class="control-label" for="topic">Topic</label>
   <input class="form-control" id="topic" name="topic" type="text">
      </div>
      <em><b>NB:</b> Fields marked with <span class="text-vermillion">*</span> are required.</em><br><br>
      <div class="form-group">
                                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                            </div>                            
                       
                </form>
                </div>
           
            </div>
        </div>
     
    </body>
<?php include('includes/scripts.php');?>
<script src="../plugins/summernote/summernote-lite.min.js"></script>
<!-- <script src="../plugins/summernote/summernote-bs4.min.js"></script> -->

<script> jQuery(document).ready(function(){
$('#summernote').summernote({
                    height: 250,                 // set editor height
                    placeholder: 'Start typing here...',  // placeholder
                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor
                    focus: false                // set focus to editable area after initializing summernote
                }); });</script>
<?php include('includes/footer.php'); ?>
</html>
<?php } ?>