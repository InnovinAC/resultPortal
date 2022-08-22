<?php
session_start();
error_reporting(1);
include('../includes/config.php');
// include('../includes/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
      <?php
      include "includes/header.php"; ?>
        <title>My Result Details - <?php echo getSiteName(); ?></title>

     <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">



<!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../images/apple-touch-icon.png?v=1.2">
<link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png?v=1.2">
<link rel="icon" type="image/png" sizes="16x16" href="../images/favicon-16x16.png?v=1.2">
<link rel="manifest" href="../images/site.webmanifest">
<!-- End Favicon -->

<link rel="designer" href="https://wa.me/2348054841869" >

            <link rel="apple-touch-icon" sizes="180x180" href="../images/apple-touch-icon.png?v=1.1">
<link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png?v=1.1">
<link rel="icon" type="image/png" sizes="16x16" href="../images/favicon-16x16.png?v=1.1">
<link rel="designer" href="https://wa.me/2348054841869" >
<link rel="manifest" href="../images/site.webmanifest">

    </head>

    <body class="mb-4">

   <div class='container-fluid'>
                        <section class="mt-4 section" id="printable">

                                <div class="shadow mx-2 card">



<div class="card-header border-2 border-bottom bg-white">

<img src="../img/logo.png" class="d-flex mx-auto mb-2" width="100" height="100">


                                                    <div class="text-center font-weight-bolder  text-22 text-lb"><?php echo strtoupper(getSiteName());?></div>
<div class="mb-2 text-lb text-center my-0"><?php echo getLocation();echo".";?></div>
<div class="text-lb text-18 text-center font-weight-bold my-0"><?php
// $query=$dbh->prepare("Select tblstudents.Classid from tblclasses where switch($display) { case

 echo strtoupper("student terminal report");?></div>
</div>
          <div class="card-body">
<?php
// code Student Data
$regnum=$_POST['regnum'];
$sessionid=$_POST['session'];
$termid=$_POST['term'];
$classid=$_POST['class'];
$pin = $_POST['pin'];
$_SESSION['regnum']=$regnum;
$_SESSION['classid']=$classid;

// Get student Id from registration number passed through the form on homepage
$getStudentId=$dbh->prepare("SELECT StudentId from tblstudents where RegNum=:regnum");
$getStudentId->bindParam(':regnum',$regnum,PDO::PARAM_STR);
$getStudentId->execute();
$fetchStudentId=$getStudentId->fetch();
$studentId=$fetchStudentId['StudentId'];

// check if pin is valid
$pinCheck = $dbh->prepare("select Pin,Trials from tblpins where Pin = :pin");
$pinCheck->bindParam(":pin",$pin,PDO::PARAM_STR);
$pinCheck->execute();
$fetchPin = $pinCheck->fetch();

if(($pinCheck->rowCount()) > 1) { // if the pin exists
  if($fetchPin['Trials'] > 0) { // if the number of trials have not been exceeded
    $trialsLeft = $fetchPin['Trials'];
  }
  else {
    $error[] = "Sorry, you have currently exhausted the number of trials assigned to this pin";
  }
}
else {
  $error[] = "Sorry, that pin does not exist. Kindly go back and check that you entered it correctly.";
}

// check if student is Blocked
$chkBlocked = $dbh->prepare("select Status from tblstudents where tblstudents.StudentId = :stid");
$chkBlocked->bindParam(":stid",$studentdId,PDO::PARAM_STR);
$chkBlocked->execute();


// Get Student Details
$stmt = $dbh->prepare("SELECT distinct tblstudents.Gender,tblresult.TermId,tblresult.SessionId,tblterms.TermName,tblsessions.SessionName,tblresult.ClassId,tblresult.StudentId,tblstudents.StudentName,tblstudents.RegNum,tblstudents.StudentId,tblstudents.Status,tblclasses.ClassName from tblresult join tblterms on tblterms.id=tblresult.TermId join tblsessions on tblsessions.id=tblresult.SessionId join tblclasses on tblclasses.id=tblresult.ClassId join tblstudents on tblstudents.StudentId=tblresult.StudentId where tblstudents.RegNum=:regnum && tblresult.ClassId=:classid && tblresult.TermId=:termid && tblresult.SessionId=:sessionid");
$stmt->bindParam(':regnum',$regnum,PDO::PARAM_STR);
$stmt->bindParam(':classid',$classid,PDO::PARAM_STR);
$stmt->bindParam(':termid',$termid,PDO::PARAM_STR);
$stmt->bindParam(':sessionid',$sessionid,PDO::PARAM_STR);
$stmt->execute();

$resultss=$stmt->fetchAll(PDO::FETCH_OBJ);
$cnt=1;

if(($stmt->rowCount()) > 0)
{
foreach($resultss as $row)
{   ?>


<table style="-webkit-print-color-adjust: exact;color-adjust:exact;" class="table table-hover table-bordered table-striped" border width="100%" cellspacing="0">
<!--
   <img style="display: block;border:1px solid grey;margin-left: auto;margin-top:4px;margin-buttom:4px;margin-right: auto;" width="200" class=" border my-4 rounded d-flex mx-auto img-fluid" src="students/<?php echo $row->Image; ?>"> -->


<tr style="background-color:#87ceeb !important;-webkit-print-color-adjust: exact;">
<td><strong>Student Name</strong></td>
<td><?php echo htmlentities($row->StudentName);?></td>
</tr>
<tr>
<td><strong>Registration Number</strong></td>
<td><?php echo htmlentities($row->RegNum);?></td>
</tr>
<tr style="background-color:#87ceeb">
<td><strong>Gender</strong></td>
<td><?php echo htmlentities($row->Gender);?></td>
</tr>
<tr>
<td><strong>Class</strong></td>
<td><?php echo htmlentities($row->ClassName);?></td>
</tr>
<tr style="background-color:#87ceeb">
<td><strong>Term</strong></td>
<td><?php echo htmlentities($row->TermName);?></td>
</tr>
<tr>
<td><strong>Academic Session</strong></td>
<td><?php echo htmlentities($row->SessionName);?></td>
</tr>
</table>

<br>

<?php } ?>
<div class="table-responsive">
          <table class="table-lb bg-white border-primary table table-responsive-md table-striped table-hover table-bordered" border="" cellspacing="0" width="100%">
                                                <thead class="border-primary">
                                                        <tr class="border-lb" style="text-align: center">
                                                          <!--  <th class="border-primary" style="text-align: center">S/N</th> -->
                                                            <th class="text-16 bg-primary text-white font-weight-bold" style="text-align: center"> SUBJECT NAME</th>
                                                            <th style="text-align: center">C.A.T(40)</th>
                                                   <th style="text-align: center">Exam(60)</th>
         <th style="text-align: center">Total(100)</th>
<th style="text-align: center">Grade</th>
<th style="text-align: center">Remark</th>
                                                        </tr>
                                               </thead>




                                                	<tbody class="border-primary" >
<?php
// Code for result
$sql1="SELECT tblstudents.RegNum, tblresult.ClassId,tblsubjects.SubjectName,tblresult.SubjectId,tblresult.Total,tblresult.CA,tblresult.Exam from tblresult join tblstudents on tblstudents.StudentId=tblresult.StudentId join tblsubjects on tblsubjects.id=tblresult.SubjectId WHERE tblresult.ClassId=:classid && tblresult.TermId=:termid && tblresult.SessionId=:sessionid && tblstudents.RegNum=:regnum";


$query1= $dbh -> prepare($sql1);
$query1->bindParam(':regnum',$regnum,PDO::PARAM_STR);
$query1->bindParam(':classid',$classid,PDO::PARAM_STR);
$query1->bindParam(':termid',$termid,PDO::PARAM_STR);
$query1->bindParam(':sessionid',$sessionid,PDO::PARAM_STR);
$query1->execute();
$results = $query1 -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;

if($query1->rowCount()>0)
{
foreach($results as $result){

    ?>
       <tr>
<?php
$markcheck = "SELECT Total FROM tblresult";?>
<!-- <td style="text-align: center"><?php echo htmlentities($cnt);?></td> -->
<td style="text-align: center"><?php echo htmlentities($result->SubjectName);?></td>
<td style="text-align: center"><?php echo htmlentities($result->CA);?></td>
<td style="text-align: center"><?php echo htmlentities($result->Exam);?></td>

<td style="text-align: center"><?php echo htmlentities($totalmarks=$result->Total);?></td>
<td style="text-align: center"><?php if($totalmarks>=80) { echo "A"; } elseif($totalmarks<80 && $totalmarks>=60) { echo "B"; } elseif($totalmarks<60 && $totalmarks>=50) { echo "C"; } elseif($totalmarks<50 && $totalmarks>=45) { echo "D"; } elseif($totalmarks<45 && $totalmarks>= 40) { echo "E"; } else { echo "F"; } ?> </td>
<td style="text-align: center"><?php if($totalmarks>=70) { echo "Excellent"; } elseif($totalmarks<70 && $totalmarks>=60) { echo "Very Good"; } elseif($totalmarks<60 && $totalmarks>=50) { echo "Good"; } elseif($totalmarks<50 && $totalmarks>=45) { echo "Fair"; } elseif($totalmarks<45 && $totalmarks>= 40) { echo "Bad"; } else { echo "Fail"; } ?></td>
                                                		</tr>
<?php
$totlcount+=$totalmarks;
$cnt++;}
?>
<tr>
<th scope="row" colspan="5" style="text-align: center">Total Marks</th>
<td style="text-align: center"><b><?php echo htmlentities($totlcount); ?></b> out of <b><?php echo htmlentities($outof=($cnt-1)*100); ?></b></td>
                                                        </tr>
<tr>
<th scope="row" colspan="5" style="text-align: center">Average</th>
<td style="text-align: center"><b><?php echo  htmlentities(round($totlcount*(100)/$outof, 2));
$average=round($totlcount*(100)/$outof,2);?> %</b></td>
</tr>

<tr>
<th scope="row" colspan="5" style="text-align: center">Grade</th>
<td style="text-align: center"><b><?php
 /* $rank=$dbh->prepare("SELECT FIND_IN_SET(average, (
SELECT GROUP_CONCAT( average ORDER BY average DESC )
FROM tblmarks where ClassId=:classid && TermId=:termid && SessionId=:sessionid)
) AS rank
FROM tblmarks where StudentId=:studentid && ClassId=:classid && TermId=:termid && SessionId=:sessionid ORDER BY average DESC");
$rank->bindParam(':classid',$classid,PDO::PARAM_INT);
$rank->bindParam(':termid',$termid,PDO::PARAM_INT);
$rank->bindParam(':sessionid',$sessionid,PDO::PARAM_INT);
$rank->bindParam(':studentid',$studentId,PDO::PARAM_INT);

$rank->execute();
$getRank=$rank->fetch();


function ordinal_suffix($n, $return_n = true) {
  $n_last = $n % 100;
  if (($n_last > 10 && $n_last < 14) || $n == 0) {
    $suffix = "th";
  } else {
    switch(substr($n, -1)) {
      case '1':    $suffix = "st"; break;
      case '2':    $suffix = "nd"; break;
      case '3':    $suffix = "rd"; break;
      default:     $suffix = "th"; break;
    }
  }
  return $return_n ? $n . $suffix : $suffix;
}


     echo ordinal_suffix($getRank['rank']), ' '; */
     ?>

<?php if($average>=80) { echo "A"; } elseif($average<80 && $average>=60) { echo "B"; } elseif($average<60 && $average>=50) { echo "C"; } elseif($average<50 && $average>=45) { echo "D"; } elseif($average<45 && $average>= 40) { echo "E"; } else { echo "F"; } ?>

 </b></td>


</tr>
<?php $query=$dbh->prepare("select comment from tblremarks where StudentId=:studentid && ClassId=:classid && TermId=:termid && SessionId=:sessionid");
$query->bindParam(':classid',$classid,PDO::PARAM_INT);
$query->bindParam(':termid',$termid,PDO::PARAM_INT);
$query->bindParam(':sessionid',$sessionid,PDO::PARAM_INT);
$query->bindParam(':studentid',$studentId,PDO::PARAM_INT);
$query->execute();
$comment=$query->fetch();
?>
<tr>
<th scope="row" colspan="5" style="text-align: center">Teacher&apos;s Comment</th>

<td style="text-align: center"><?php echo $comment['comment'];?></td>
</tr>

 <?php } else { ?>
<div class="alert alert-warning" role="alert">
                                            <strong>We apologize.</strong> Your result has not been published yet. Check back later.</div>
 <?php }
?>


                                                	</tbody>
                                                </table>
                                                <br>
                                                <table class="table table-striped table-bordered">
<!-- I did not use <thead></thead> so it would not affect how the print out looks like -->
                                                <tr><th class="text-center" colspan="6">RATINGS</th></tr>

                                                <tr><th>Behaviour</th><th>A</th><th>B</th><th>C</th><th>D</th><th>E</th></tr>

                                                <tbody>

                                                <?php
                                                $query= $dbh->prepare("select tblratings.RatingId,tblratingname.RatingName,tblratings.RatingValue from tblratings join tblratingname on tblratings.RatingId=tblratingname.id where tblratings.StudentId=".$studentId." && tblratings.TermId =".$termid. " && tblratings.ClassId=".$classid." && tblratings.SessionId = ".$sessionid);
            $query->execute();
            $ratings=$query->fetchAll(PDO::FETCH_OBJ);
            foreach($ratings as $r) {
            ?>
            <tr>
            <td><?php echo $r->RatingName;?></td>
            <td><?php if(($r->RatingValue)=='A') { echo "<i class='far fa-check-circle'></i>"; } ?></td>
                                                  <td><?php if(($r->RatingValue)=='B') { echo "<i class='far fa-check-circle'></i>"; } ?></td>
                                                  <td><?php if(($r->RatingValue)=='C') { echo "<i class='far fa-check-circle'></i>"; } ?></td>
                                                  <td><?php if(($r->RatingValue)=='D') { echo "<i class='far fa-check-circle'></i>"; } ?></td>
                                                  <td><?php if(($r->RatingValue)=='E') { echo "<i class='far fa-check-circle'></i>"; } ?></td> </tr>
                                                  <?php } ?>
                                                  </tbody>
                                                  </table>
                                                  <br>
                                                   <table class="table table-striped table-bordered">
                                                      <thead>
                                                         <tr><th class="text-center" scope="row" colspan="2">GRADES</th></tr>

                                                         <tr>
                                                            <td>Grade</td>
                                                            <td>Score</td>
                                                            </tr>

                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                               <td>A</td><td>80-100</td></tr>
                                                               <tr>
                                                               <td>B</td><td>60-79</td></tr>
                                                               <tr>
                                                               <td>C</td><td>50-59</td></tr>
<tr>
                                                               <td>D</td><td>45-49</td></tr>
                                                               <tr>
                                                               <td>E</td><td>40-44</td></tr>
                                                               <tr>
                                                               <td>F</td><td>0-39</td></tr>
</tbody>
</table>
                              </section>
<?php include('includes/printtext.php');?>
<a class='btn btn-success mt-2' href='index.php'>Back Home</a>
<?php
 } else
 {?>
<div class="alert alert-danger" role="alert"><strong>Oh No!</strong>
<?php
echo "Invalid registration number or wrong class/term/session. Please go back and try again.";?> </div>
<?php
echo "<a class='btn btn-success' href='index.php'>Back Home</a>";
 }
?>
</div>
</div>
    <?php include('includes/scripts.php');?>
 <?php include('includes/printscript.php');?>
   </div>
    </body>
<?php include('includes/footer.php');?>
</html>
