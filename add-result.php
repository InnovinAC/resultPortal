<?php
session_start();
error_reporting(1);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {
    header("Location: admin.php");
    }
    else{
if(isset($_POST['submit']))
{


$session=$_POST['session'];
$term=$_POST['term'];
$class=$_POST['class'];
$studentid=$_POST['studentid'];
$ca=$_POST['cas'];
$exam=$_POST['exams'];
$sid=$_POST['subjectid'];
$sumexam=array_sum($exam);
$sumca=array_sum($ca);
$total=$sumexam+$sumca;
$comment=$_POST['comment'];

$summarks=$total;
$howmany=count(array_filter($ca,function($x){ return !empty($x); })); // count only non-empty marks
$totalrequired=$howmany*100;
$average=($summarks/$totalrequired)*100;


// check if ratings alredy exist in database
$ratingCheck  = $dbh->prepare("select * from tblratings where StudentId=:stid && ClassId=:cid && SessionId=:sesid && TermId=:tid");
$ratingCheck->bindParam(':stid',$studentid,PDO::PARAM_STR);
$ratingCheck->bindParam(':cid',$class,PDO::PARAM_STR);
/* $resultCheck->bindParam(':sid',$sids,PDO::PARAM_STR); */
$ratingCheck->bindParam(':sesid',$session,PDO::PARAM_STR);
$ratingCheck->bindParam(':tid',$term,PDO::PARAM_STR);
$ratingCheck->execute();
$countRating=$ratingCheck->fetchAll();
if(!empty($countRating)) {
   $error[]= "Rating already exists in the database";
   } else {
     // if not, insert the ratings
   $rids = $_POST['RatingId'];

   foreach($rids as $i => $rid) {
   $rvals = $_POST['RatingValue'];
   $rval=$rvals[$i];
   $query4 = $dbh->prepare("Insert into tblratings(RatingId,ClassId,TermId,SessionId,RatingValue,StudentId) VALUES('$rid','$class','$term','$session','$rval','$studentid')");
   $query4->execute();
   $err=$query4->errorInfo();
   echo $err[2];
   }
   $lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
   $msg[] = "Ratings added successfully";
   }
   }




// check if average already exists
$resultCheck=$dbh->prepare("SELECT * from tblmarks where StudentId=:stid && ClassId=:cid && SessionId=:sesid && TermId=:tid");
$resultCheck->bindParam(':stid',$studentid,PDO::PARAM_STR);
$resultCheck->bindParam(':cid',$class,PDO::PARAM_STR);
/* $resultCheck->bindParam(':sid',$sids,PDO::PARAM_STR); */
$resultCheck->bindParam(':sesid',$session,PDO::PARAM_STR);
$resultCheck->bindParam(':tid',$term,PDO::PARAM_STR);
$resultCheck->execute();
$countResult=$resultCheck->fetchAll();
if(!empty($countResult)) {
   $error[]= "Average already exists in the database";
   } else {


    // update average if it already exists. otherwise insert a new one
/* $query3=$dbh->prepare("select average from tblmarks where StudentId=:stid && ClassId=:cid && SessionId=:sesid && TermId=:tid");
$query3->bindParam(':stid',$studentid,PDO::PARAM_STR);
$query3->bindParam(':cid',$class,PDO::PARAM_STR);
$query3->bindParam(':sesid',$session,PDO::PARAM_STR);
$query3->bindParam(':tid',$term,PDO::PARAM_STR);
$query3->execute();
$result3=$query3->fetch();
$count3=$result3->rowCount();
if($count3 > 0) {
   $newaverage=($average+$result3['average'])/2;
   $query4=$dbh->prepare("update tblmarks set average=:avg where StudentId=:stid && ClassId=:cid && SessionId=:sesid && TermId=:tid");
   $query4->bindParam(':avg',$newaverage,PDO::PARAM_STR);
   $query4->bindParam(':stid',$studentid,PDO::PARAM_STR);
$query4->bindParam(':cid',$class,PDO::PARAM_STR);
$query4->bindParam(':sesid',$session,PDO::PARAM_STR);
$query4->bindParam(':tid',$term,PDO::PARAM_STR);
   $query4->execute();
   $msg[]="New average recalculated";
   }
   else {

*/

$sql1="INSERT INTO tblmarks(StudentId,ClassId,SessionId,average,TermId) VALUES(:studentid,:class,:session,:avg,:term)";
$query1=$dbh->prepare($sql1);
$query1->bindParam(':studentid',$studentid,PDO::PARAM_STR);
$query1->bindParam(':class',$class,PDO::PARAM_STR);
$query1->bindParam(':session',$session,PDO::PARAM_STR);
$query1->bindParam(':avg',$average,PDO::PARAM_STR);
$query1->bindParam(':term',$term,PDO::PARAM_STR);
$query1->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg[]="Average computed successfully.";
}
}


$resultCheck1=$dbh->prepare("SELECT * from tblresult where StudentId=:stid && ClassId=:cid && SessionId=:sesid && TermId=:tid");
$resultCheck1->bindParam(':stid',$studentid,PDO::PARAM_STR);
$resultCheck1->bindParam(':cid',$class,PDO::PARAM_STR);
/* $resultCheck->bindParam(':sid',$sids,PDO::PARAM_STR); */
$resultCheck1->bindParam(':sesid',$session,PDO::PARAM_STR);
$resultCheck1->bindParam(':tid',$term,PDO::PARAM_STR);
$resultCheck1->execute();
$countResult1=$resultCheck1->fetchAll();
if(!empty($countResult1)) {
   $error[]= "Result already exists in the database";
   } else {

     foreach($sid as $i => $sids) {
     $c=intval($ca[$i]);
     $exa=intval($exam[$i]);
     $tot=$c+$exa;
$sql="INSERT INTO  tblresult(StudentId,ClassId,SessionId,SubjectId,CA,Exam,Total,TermId) VALUES(:studentid,:class,:session,:sid,:ca,:exam,:total,:term)";


$query = $dbh->prepare($sql);

$query->bindParam(':studentid',$studentid,PDO::PARAM_STR);
$query->bindParam(':class',$class,PDO::PARAM_STR);$query->bindParam(':session',$session,PDO::PARAM_STR);
$query->bindParam(':sid',$sids,PDO::PARAM_STR);
$query->bindParam(':ca',$c,PDO::PARAM_STR);
$query->bindParam(':exam',$exa,PDO::PARAM_STR);
$query->bindParam(':total',$tot,PDO::PARAM_STR);
$query->bindParam(':term',$term,PDO::PARAM_STR);

$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg[]="Result published successfully.";

 }


else
{
$error="Something went wrong. Please try again.";
}



}

// }

}



$checkcomment=$dbh->prepare("select * from tblremarks where StudentId=:stid && TermId=:tid && SessionId=:sesid && ClassId=:cid");
$checkcomment->bindParam(':stid',$studentid,PDO::PARAM_STR);
$checkcomment->bindParam(':cid',$class,PDO::PARAM_STR);
$checkcomment->bindParam(':sesid',$session,PDO::PARAM_STR);
$checkcomment->bindParam(':tid',$term,PDO::PARAM_STR);
$checkcomment->execute();
$fetchcomment=$checkcomment->fetchAll();
if($fetchcomment){
$error[]="Teacher's comment already exists"; }
else {
$query2=$dbh->prepare("INSERT INTO tblremarks(comment,StudentId,ClassId,SessionId,TermId) VALUES(:comment,:stid,:cid,:sesid,:tid)");
$query2->bindParam(':comment',$comment,PDO::PARAM_STR);
$query2->bindParam(':stid',$studentid,PDO::PARAM_STR);
$query2->bindParam(':cid',$class,PDO::PARAM_STR);
$query2->bindParam(':sesid',$session,PDO::PARAM_STR);
$query2->bindParam(':tid',$term,PDO::PARAM_STR);
$query2->execute();
$lastInsertId1=$dbh->lastInsertId();
if($lastInsertId1) {
   $msg[]="Teacher's comment added successfully.";
   }
   else {
      $error[]="Comment could not be added or already exists";
      }
}}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Add Result </title>
      <?php include('includes/header.php');?>
<link href="../css/select2.min.css?1" rel="stylesheet" media="all">
        <script>
function getSubject(val) {
$.ajax({
        type: "POST",
        url: "get_subjects.php?htaccess=0",
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
  <li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Home</a></li>
    <li class="breadcrumb-item active">Student Result</li>
                                    </ul>
                     <div class="container">
                                    <h3 class="text-muted title">Publish Result</h3>


                                        <div class="card shadow mb-4 ">

                                            <div class="card-body">
                                              <?php if($_SESSION['role'] == 1) { ?>
<div class="alert alert-dismissable alert-orange"><span class=" fade close show far fa-times-circle" data-dismiss="alert"></span>
<span class="far fa-info-circle"></span>
Do ensure you have completely assigned subjects to their appropriate classes. If not, do so <a href="add-subjectcombination.php" class="alert-link text-underline">here</a>.
</div>

<?php } if(!empty($msg)){ ?>
<div class="alert alert-success" role="alert">
<span class="far fa-check-circle"></span>
 <strong>Great job! </strong><?php echo ("Result published successfully"); ?>
 </div><?php }
if(!empty($error)){ ?>
    <div class="alert alert-danger" role="alert">
<span class="far fa-times-circle"></span>
                                            <strong>Oh no! </strong> <?php echo("Result already exists"); ?>
                                        </div>
                                        <?php }?>
                                                <form class="form-horizontal" method="post">
<div class="mb-4 form-group">

<label for="student">Select Student</label>
                                                    <select name="studentid" style="height:50px !important" id="student" class="form-control select12" placeholder="Start typing..." required="required">
<option hidden selected value="">Select Student</option>
<?php if($_SESSION['role'] != 1) {
   $condition="where ClassId=".$_SESSION['class'];
   $condition1="&& id=".$_SESSION['class'];
   $condition2="where id=".$_SESSION['session']; }
?>
<?php $sql = "SELECT tblstudents.ClassId,tblstudents.StudentId,tblstudents.StudentName, tblclasses.ClassNameNumeric from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId $condition order by  tblclasses.ClassNameNumeric,tblstudents.StudentName";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{
  ?>
<option value="<?php echo htmlentities($result->StudentId); ?>"><?php echo htmlentities($result->StudentName); ?>&nbsp;</option>
<?php }} ?>

 </select>


                                                        </div>
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


<div class="form-group">
                                                        <label for="subject" class="control-label">Subjects</label>

                                         <div id="subject">

                                                   </div>
                                                    </div>


                                         <div class="mb-4 form-floating">

         <textarea name="comment" required style="height: 100px" class="form-control" placeholder="Start typing here..."></textarea>
         <label>Teacher's Comment</label>
            </div>
            <h3 class="h3 my-25">RATING</h3>

            <div class="row g-3">

            <?php
            $query= $dbh->prepare("select * from tblratingname");
            $query->execute();
            $ratings=$query->fetchAll(PDO::FETCH_OBJ);
            foreach($ratings as $rating) { ?>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="mb-3 form-floating">
            <input type="hidden" name="RatingId[]" value="<?php echo $rating->id; ?>">

            <select required name="RatingValue[]" class="form-select">
            <option hidden selected value="">-- SELECT --</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            </select>
            <label><?php echo $rating->RatingName; ?></label>
            </div>
          </div>
            <?php } ?>
          </div>
                                                            <button type="submit" name="submit" id="submit" class="mr-1 mt-3 btn btn-lg btn-primary">Publish Result</button>            <button type="reset" class="btn btn-lg mt-3  btn-success">Reset</button>
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
<?php } ?>
