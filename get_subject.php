<?php
include('../includes/config.php');

// Code for Subjects
if(!empty($_POST["classid"])) 
{
 $cid1=intval($_POST['classid']);
 if(!is_numeric($cid1)){
 
  echo htmlentities("Invalid Class");exit;
 }
 else{
 $status=0;	
 $stmt = $dbh->prepare("SELECT tblsubjects.SubjectName,tblsubjects.id FROM tblsubjectcombination join  tblsubjects on  tblsubjects.id=tblsubjectcombination.SubjectId WHERE tblsubjectcombination.ClassId=:cid and tblsubjectcombination.status!=:stts order by tblsubjects.SubjectName");
$stmt->execute(array(':cid' => $cid1,':stts' => $status));
$rows=$stmt->fetchAll(PDO::FETCH_OBJ); ?>
<select required name="subject" class="bg-light form-control">
<?php if(empty($stmt->rowCount())) { ?>
<option value=""><i class="far fa-frown"></i> No subject(s) found</option></select>
<div class="alert alert-info" role="alert">Please <a href="add-subjectcombination.php" class="alert-link text-underline">click here</a> to assign subjects to <
<?php
} else { ?>
   <option value="" hidden>Choose Subject</option>
 <?php foreach($rows as $row)
 { ?>
  
<option name="subjectid" value="<?php echo htmlentities($row->id); ?>"><?php echo htmlentities($row->SubjectName); ?></option>
  
<?php  } }
?> 
   </select>
<?php 
}}
?>