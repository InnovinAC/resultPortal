<?php
session_start();
error_reporting(1);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {
    header("Location: admin.php");
    }
    else{

$stid=intval($_GET['stid']);
$tid=intval($_GET['tid']);
$sesid=intval($_GET['sesid']);
$cid=intval($_GET['cid']);
if(isset($_POST['submit']))
{

$rowid=$_POST['id'];
$ca=$_POST['cas'];
$exam=$_POST['exams'];
$sid=$_POST['subjectid'];
$sumca=array_sum($ca);
$sumexam=array_sum($exam);
$total=$sumexam+$sumca;
$comment=$_POST['comment'];


$query=$dbh->prepare("update tblremarks set comment=:comment where StudentId=:studentid && ClassId=:classid && TermId=:termid && SessionId=:sessionid");
$query->bindParam(':comment',$comment,PDO::PARAM_STR);
$query->bindParam(':studentid',$stid,PDO::PARAM_STR);
$query->bindParam(':classid',$cid,PDO::PARAM_STR);$query->bindParam(':sessionid',$sesid,PDO::PARAM_STR);
$query->bindParam(':termid',$tid,PDO::PARAM_STR);
$query->execute();
$msg[]="Teacher's comment updated successfully";


// get the student's average and update it in the database
$summarks=$total; // sum of marks
$howmany=count(array_filter($ca,function($x){ return !empty($x); })); // count only non-empty marks
$totalrequired=$howmany*100;
$average=($summarks/$totalrequired)*100; // average gotten

$sql1="Update tblmarks set average=:avg where StudentId=:studentid && ClassId=:classid && TermId=:termid && SessionId=:sessionid";
$query1=$dbh->prepare($sql1);
$query1->bindParam(':studentid',$stid,PDO::PARAM_STR);
$query1->bindParam(':classid',$cid,PDO::PARAM_STR);$query1->bindParam(':sessionid',$sesid,PDO::PARAM_STR);
$query1->bindParam(':avg',$average,PDO::PARAM_STR);
$query1->bindParam(':termid',$tid,PDO::PARAM_STR);
$query1->execute();
if($query1->execute()) {
$msg[]="Average recalculated successfully.";
}
else {
   $error[]="An error occurred"; }


// update ratings
   $rids = $_POST['RatingId'];

   foreach($rids as $i => $rid) {
   $rvals = $_POST['RatingValue'];
   $rval=$rvals[$i];

   $query = $dbh->prepare("update tblratings set RatingValue = :rval where RatingId = :rid && ClassId = :cid &&  TermId=:tid && SessionId=:sesid && StudentId=:stid");
   $query->execute(["rval"=>$rval,":rid"=>$rid,":cid"=>$cid,":tid"=>$tid,":sesid"=>$sesid,":stid"=>$stid]);


}


// update result table for multiple subjects and marks
foreach($_POST['id'] as $count => $id){
$c=$ca[$count];
// $iid=$rowid[$count];

$exa=$exam[$count];
$tot=$c+$exa;
// for($i=0;$i<=$count;$i++) {

$sql="update tblresult  set CA=:c,Exam=:exa,Total=:tot where id=:iid";
$query2 = $dbh->prepare($sql);
$query2->bindParam(':c',$c,PDO::PARAM_STR);
$query2->bindParam(':exa',$exa,PDO::PARAM_STR);
$query2->bindParam(':tot',$tot,PDO::PARAM_STR);
$query2->bindParam(':iid',$id,PDO::PARAM_STR);
$query2->execute();


$msg="Result updated successfully.";
// }
}


}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
   <title>Admin |  Edit Student's Result</title>
 <?php include('includes/header.php');?>

    </head>
    <body>
      <?php include('includes/leftbar.php');?>

  <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>

                                        <li class="breadcrumb-item active">Result Info</li>
                                    </ul>
                     <div class="container">
                   <h3 class="h2 title">Student Result Info</h3>

                                </div>
                        <div class="container">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h5 class="h5 text-muted font-weight-bold">Update Result Information.</h5>
                                                </div>

<?php if($msg){?>
<div class="alert alert-success" role="alert">
<span class='far fa-check-circle'></span>
 <strong>Great job! </strong><?php echo htmlentities($msg); ?>
 </div><?php }
else if($error){?>
    <div class="alert alert-danger" role="alert">
<span class='far fa-times-circle'></span>
                                            <strong>Oh no! </strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>

                                                <form class="form-horizontal" method="post">

<?php

$ret = "SELECT tblresult.ClassId,tblstudents.Gender,tblstudents.StudentName,tblterms.TermName,tblsessions.SessionName,tblclasses.ClassName from tblresult join tblstudents on tblstudents.StudentId=tblresult.StudentId join tblclasses on tblclasses.id=tblresult.ClassId join tblterms on tblterms.id=tblresult.TermId join tblsessions on tblsessions.id=tblresult.SessionId  where tblresult.StudentId=:stid && tblresult.ClassId=:cid && tblresult.TermId=:tid && tblresult.SessionId=:sesid limit 1";
$stmt = $dbh->prepare($ret);
$stmt->bindParam(':stid',$stid,PDO::PARAM_STR);
$stmt->bindParam(':cid',$cid,PDO::PARAM_STR);
$stmt->bindParam(':tid',$tid,PDO::PARAM_STR);
$stmt->bindParam(':sesid',$sesid,PDO::PARAM_STR);
$stmt->execute();
$row=$stmt->fetch();
// $result=$stmt->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($stmt->rowCount() > 0)
{
   if($_SESSION['role'] != 1 && $_SESSION['class'] != $row['ClassId']) { ?>
                <div class="alert alert-warning"><i class="far fa-info-circle"></i> Sorry, you're not allowed to edit the result of a student who is not in your class. The selected student is currently in <b><?php echo $row['ClassName'];?></b>.</div>
                <?php } else {

// foreach($result as $row) {  ?>
<table class="table table-striped table-bordered">
<tr>
<td>Student Name</td>
<td><?php echo htmlentities($row['StudentName']);?></td>
</tr>
<tr>
<td>Gender</td>
<td><?php echo htmlentities($row['Gender']);?></td>
</tr>
<tr><td>Class</td>
<td><?php echo htmlentities($row['ClassName'])?></td>
</tr>
<tr><td>Term</td>
<td><?php echo htmlentities($row['TermName'])?></td>
</tr>
<tr><td>Session</td>
<td><?php echo htmlentities($row['SessionName'])?></td>
</tr>
</table>

<?php // } ?>


<div class="h4 mt-4  mb-2 text-muted">Subjects</div>
<?php


$sql = "SELECT distinct tblsubjects.SubjectName,tblresult.Total,tblresult.CA,tblresult.Exam,tblresult.id as resultid from tblresult join tblstudents on tblstudents.StudentId=tblresult.StudentId join tblsubjects on tblsubjects.id=tblresult.SubjectId join tblclasses on tblclasses.id=tblstudents.ClassId where tblstudents.StudentId=:stid && tblresult.TermId=:tid && tblresult.SessionId=:sesid && tblresult.ClassId=:cid";

$query2=$dbh->prepare("SELECT comment from tblremarks where StudentId=:stid && TermId=:tid && SessionId=:sesid && ClassId=:cid");
$query = $dbh->prepare($sql);

$query->bindParam(':stid',$stid,PDO::PARAM_STR);
$query->bindParam(':cid',$cid,PDO::PARAM_STR);
$query->bindParam(':tid',$tid,PDO::PARAM_STR);
$query->bindParam(':sesid',$sesid,PDO::PARAM_STR);

$query2->bindParam(':stid',$stid,PDO::PARAM_STR);
$query2->bindParam(':cid',$cid,PDO::PARAM_STR);
$query2->bindParam(':tid',$tid,PDO::PARAM_STR);
$query2->bindParam(':sesid',$sesid,PDO::PARAM_STR);
$query->execute();
$query2->execute();
$results2=$query2->fetch();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{ ?>
  <div class="row mb-4 g-3">

<?php
foreach($results as $result)
{?>
  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
 <div class="border mb-4 rounded border-dark shadow-sm py-4 px-3">

<div class="form-group">
<label for="default" class="control-label"><b class="text-underline"><?php echo htmlentities($result->SubjectName)?></b></label>
<input type="hidden" name="id[]" value="<?php echo htmlentities($result->resultid)?>">
<!-- <input type="number" min="0" max="100" name="marks[]" class="form-control" id="marks" value="<?php echo htmlentities($result->marks)?>" required="required" autocomplete="off"> -->
   <label>CA Score</label><input type="number" max="40" name="cas[]" value="<?php echo $result->CA;?>" class="form-control" placeholder="Enter marks out of 40" autocomplete="off">
<label>Exam Score</label><input type="number" max="60" min="0" name="exams[]" value="<?php echo $result->Exam;?>" class="form-control" placeholder="Enter marks out of 60" autocomplete="off"></p>
</div>

</div>
</div>



<?php } ?>
</div>
  <div class="form-floating mb-5">

         <textarea style="height: 100px" placeholder="Teacher's Comment" id="comment" name="comment"  rows="7" class="form-control" ><?php echo $results2['comment'];?></textarea>
          <label for="comment">Teacher's Comment</label>
            </div>


            <h3 class="h3 my-25">RATING</h3>

            <div class="row g-3">
            <?php
            $query= $dbh->prepare("select tblratings.RatingId,tblratingname.RatingName,tblratings.RatingValue from tblratings join tblratingname on tblratings.RatingId=tblratingname.id where tblratings.StudentId=:stid && tblratings.TermId =:tid && tblratings.ClassId=:cid && tblratings.SessionId =:sesid");
            $query->execute([":stid"=>$stid,":tid"=>$tid,":cid"=>$cid,":sesid"=>$sesid]);
            $ratings=$query->fetchAll(PDO::FETCH_OBJ);
            foreach($ratings as $r) {
            ?>

            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="mb-3 form-floating">
            <input type="hidden" name="RatingId[]" value="<?php echo $r->RatingId; ?>">

            <select required name="RatingValue[]" class="form-select">
            <option hidden value="">-- SELECT --</option>
            <option <?php if($r->RatingValue == "A") { echo "selected";}?> value="A">A</option>
            <option <?php if($r->RatingValue == "B") { echo "selected";}?> value="B">B</option>
            <option <?php if($r->RatingValue == "C") { echo "selected";}?> value="C">C</option>
            <option <?php if($r->RatingValue == "D") { echo "selected";}?> value="D">D</option>
            <option <?php if($r->RatingValue == "E") { echo "selected";}?> value="E">E</option>

            </select>
            <label><?php echo $r->RatingName; ?></label>
            </div>
          </div>
            <?php } ?>
          </div>
              <br>


                                                    <div class="form-group">

                                                            <button type="submit" name="submit" class="btn btn-lg btn-primary">Update</button>

                                                    </div>
                                                </form>

                                             <?php }}} else {  echo "<div class='alert alert-info'>
<span class='far fa-info-circle'></span>
Sorry, the selected result does not exist. <a class='alert-link text-underline' href='manage-results.php'>Go back</a> and try again.</div>"; }?>
                </div>

            </div>

        </div>
     <?php include('includes/scripts.php');?>

    </body>
<?php include('includes/footer.php');?>
</html>
<?php } ?>
