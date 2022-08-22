<?php
session_start();
error_reporting(1);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {
    header("Location: admin.php");
    }
    else{
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Add Note </title>
      <?php include('includes/header.php');?>
<link href="../css/select2.min.css?1" rel="stylesheet" media="all">
</head>
<body>
<?php include('includes/leftbar.php');?>

  <ul class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Home</a></li>
<li class="breadcrumb-item active">Add Class Notes</li>
                                </ul>
                 <div class="container">
                                <h3 class="text-muted title">Publish Note</h3>


                                    <div class="card shadow mb-4 ">

                                        <div class="card-body">

<?php if($msg){
foreach($msg as $i=>$msgs) {?>
<div class="alert alert-success" role="alert">
<span class="far fa-check-circle"></span>
<strong>Great job! </strong><?php echo htmlentities($msgs); ?>
</div><?php } }
if($error){
foreach($error as $errors) {?>
<div class="alert alert-danger" role="alert">
<span class="far fa-times-circle"></span>
                                        <strong>Oh no! </strong> <?php echo htmlentities($errors); ?>
                                    </div>
                                    <?php } }?>
                                            <form enctype="multipart/form-data" class="form-horizontal" method="post">


<div class="mb-4 form-floating">


<select name="class" class="form-select clid" id="classid" onChange="getSubject(this.value);" required="required">
<option hidden selected value="">Select Class</option>
<?php $sql = "SELECT id,ClassName from tblclasses where ClassName!='Graduated' $condition1 order by ClassNameNumeric";
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
<label for="classid">Class</label>
                                                    </div>
<div class="mb-4 form-floating">

<select class="form-select" id-"session" name="session" required="">
<option hidden selected value="">Select Session</option>
<?php

$sql="SELECT id,SessionName from tblsessions $condition2 order by SessionName";
$query=$dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0) {
foreach($results as $result) {
?>

<option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->SessionName);?></option>
<?php }} ?>
</select>
<label for="session" class="control-label">Academic Session</label>
</div>

 <div class="mb-4 form-floating">


<select name="term" class="form-select" id="term" required="required">
<option hidden selected value="">Select Term</option>
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
<label for="term" class="control-label">Term</label>
                                                    </div>


                                                    <div class="mb-3">
                                                      <label for="formFileMultiple" class="form-label">PDF NOTE</label>
                                                      <input  name="note" class="form-control" type="file" id="formFileMultiple" multiple>
                                                    </div>




                                                        <button type="submit" name="submit" id="submit" class="mr-1 mt-3 btn btn-lg btn-primary">Publish Note</button>            <button type="reset" class="btn btn-lg mt-3  btn-success">Reset</button>
                                                    </div>

</div>
</div>


                <?php include('includes/scripts.php');?>
<script src="js/select2.min.js"></script>
<script>
$(document).ready(function() {
$('.select12').select2({placeholder: "Start typing here to search..." });
});
</script>

</body>
<?php include('includes/footer.php');?>
</html>
<?php  } ?>
