<?php
session_start();
// error_reporting(0);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {
    header("Location: admin.php");
    }
    else{
    	$time=date("G");

        ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>School Portal | Dashboard</title>
        <?php  include('includes/header.php'); ?>
<style>
   #form1 { display:none} </style>

    </head>

    <body class="bg-white">

<?php include('includes/scripts.php'); ?>
        <?php include('includes/leftbar.php');
?>
                  <div class="container">
                                    <p class="h1 mb-3 text-muted font-weight-bold">Dashboard</p>
<div class="card animate__animated animate__lightSpeedInRight border border-dark shadow mb-5">
<div class="card-body">
<div class="text-left my-1">
<span style="font-size:15px"><i class='far fa-user-cog'> </i> <?php echo "Hi <span class='text-green'>".$_SESSION['alogin'].".</span><br> <span id='quote'></span> <span id='author'></span></span> "; ?></span>
</div>
</div>
</div>
<!-- Dashboard Row Start -->
                                    <div class="gy-4 mb-5 gx-4 row">

									<!-- Column for Registered Students Start -->
									<div class="col-sm-6 col-lg-4 col-md-6">
									<div class="border-secondary border border-1 animate__animated animate__zoomIn shadow card">


<?php
$class = $_SESSION['class'];
switch($_SESSION['role']) {
case 2: $condition="where ClassId = $class";
break;
case 1: $condition = "";
break;
}


$sql1 = "SELECT StudentId from tblstudents ".$condition."";

$query1 = $dbh->prepare($sql1);
$query1->execute();
$totalstudents=$query1->rowCount();
?>
<div class="card-body">
<h5 class="card-title">

                                            <span class="name text-16 text-muted"><small>TOTAL STUDENTS</small></span>
											<br>
											<span class="font-weight-bolder text-24 text-dark"><?php echo htmlentities($totalstudents);?></span>

<!-- <span class="text-indigo-dark mb-2 ml-2 bg-icon"><i class="fal fa-user"></i></span> -->
                                        </h5>
 <hr class="bg-success">
  <a class=" card-link" href="manage-students.php"><small>Manage</small></a>  <a class="card-link " href="add-students.php"><small>Add New</small></a>
  </div>

  </div>
  </div>
  <!-- Column for Registered Students End -->


  <!-- Column for Total Subjects Start -->

  <div class="col-sm-6 col-lg-4 col-md-6">
									<div class="border-secondary border border-1 animate__animated animate__zoomIn shadow card">

<?php
$sql ="SELECT id from  tblsubjects ";
$query = $dbh -> prepare($sql);
$query->execute();
$totalsubjects=$query->rowCount();
?>

<div class="card-body">
<h5 class="card-title">

											<span class="text-16 text-muted name"><small>TOTAL SUBJECTS</small></span>
											<br>
                                            <span class="font-weight-bolder text-24"><?php echo htmlentities($totalsubjects);?></span>


											</h5>
											<hr class="bg-vermillion">
  <a class="card-link" href="manage-subjects.php"><small>Manage</small></a>  <a class="card-link" href="create-subject.php"><small>Add New</small></a>

 </div>
  </div>
  </div>
  <!-- Column for Total Subjects End -->


  <div class="col-sm-6 col-lg-4 col-md-6">
									<div class="border-secondary border border-1 animate__animated animate__zoomIn shadow card">

<?php
if($_SESSION['role']!=1) {
   $condition1="&& ClassId =".$_SESSION['class']; }
if(!empty($condition1)) {
$sql4 ="SELECT id from tblsubjectcombination where status='1' $condition1";
}
else {
$sql4 ="SELECT id from tblsubjectcombination where status='1'";

}
$query4 = $dbh -> prepare($sql4);
$query4->execute();
$totalsubjectcombinations=$query4->rowCount();
?>
<div class="card-body">
<h5 class="card-title">
											<span class="text-muted text-16 name"><small>TOTAL SUBJECT COMBINATIONS</small></span>
											<br>
                                            <span class="text-24"><?php echo htmlentities($totalsubjectcombinations);?></span>


                                        </h5>
										<hr class="bg-navy">
										 <a class="card-link" href="manage-subjectcombination.php"><small>Manage</small></a>  <a class="card-link" href="add-subjectcombination.php"><small>Add New</small></a>
										</div>
  </div>
  </div>


<?php if($_SESSION['role']==1) { ?>


  <div class="col-sm-6 col-lg-4 col-md-6">
									<div class="border-secondary border border-1 animate__animated animate__zoomIn shadow card">

<?php
$sql5 ="SELECT id from tblsessions";
$query5 = $dbh -> prepare($sql5);
$query5->execute();
$totalsessions=$query5->rowCount();
?>
<div class="card-body">
<h5 class="card-title">
											<span class="text-16 text-muted name"><small>NUMBER OF SESSIONS</small></span>
											<br>
                                            </i></span>
                                            <span class="text-24 font-weight-bolder"><?php echo htmlentities($totalsessions);?></span>
                                             </h5>
											 <hr class="bg-orange">
                                     <a class="card-link" href="manage-sessions.php"><small>Manage</small></a>  <a class="card-link" href="create-session.php"><small>Add New</small></a>

 </div>
  </div>
  </div>

                                        <?php } ?>

                                  <!--      <a class="card dashboard-stat" href="manage-classes.php">
                                        <?php
$sql2 ="SELECT id from  tblclasses ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$totalclasses=$query2->rowCount();
if($totalclasses <= 1) {
$counter4="Class";
}
else {
$counter4="Classes";
}
?>
                                            <span class="number counter"><?php echo htmlentities($totalclasses);?></span>
                                            <span class="name">Total <?php echo"$counter4";?></span>
                                            <span class="text-danger mb-2 ml-2 bg-icon"><i class="fal fa-school"></i></span>
                                        </a> -->




                                  <!--    <a class="card dashboard-stat" href="manage-assignments.php">
                                        <?php
                                        /*
$sql3="SELECT  id from tblassignments $condition";
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);
$totalresults=$query3->rowCount();
if($totalresults <= 1) {
$counter5="Assignment";
}
else {
$counter5="Assignments";
} */
?>

                                            <span class="number counter"><?php echo htmlentities($totalresults);?></span>
                                            <span class="name">Published <?php echo"$counter5";?></span>
                                            <span class="mb-2 ml-2 text-navy bg-icon"><i class="fal fa-book-open"></i></span>
                                        </a> -->


										      <div class="col-sm-6 col-lg-4 col-md-6">
									<div class="border-secondary border border-1 animate__animated animate__zoomIn shadow card">

                                        <?php
                                        if($_SESSION['role']!=1) {
                                           $condition3="where ClassId=".$_SESSION['class']." && SessionId=".$_SESSION['session']; }

                                           if(!empty($condition3)) {
$sql3="SELECT distinct StudentId,TermId,SessionId,ClassId from tblresult $condition3";
}
else {

$sql3="SELECT distinct StudentId,TermId,SessionId,ClassId from tblresult";
}
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);
$totalresults=$query3->rowCount();

?>
<div class="card-body">
<h5 class="card-title">

											<span class="text-muted text-16 name"><small>PUBLISHED RESULTS</small></span>
											<br>
                                            <span class="text-24 font-weight-bolder"><?php echo htmlentities($totalresults);?></span>


											</h5>
											<hr class="bg-muted">
                                     <a class="card-link" href="manage-results.php"></small>Manage</small></a>  <a class="card-link" href="add-result.php"><small>Add New</small></a>

                                        </div>
  </div>
  </div>
                       <?php if($_SESSION['role']==1){ ?>


				<!--	    <div class="col-sm-6 col-lg-4 col-md-6">
									<div class="shadow card">

                                        <?php
$sql8="SELECT id from tblpins";
$query8 = $dbh -> prepare($sql8);
$query8->execute();
$results8=$query8->fetchAll(PDO::FETCH_OBJ);
$totalpins=$query8->rowCount();
if($totalpins <= 1) {
$counter7="Pin";
}
else {
$counter7="Pins";
}
?>

<div class="card-body">
<h5 class="card-title">
											<span class="text-16 text-muted name"><small>ACTIVE PINS</small></span>
											<br>
                                            <span class="text-24 font-weight-bolder"><?php echo htmlentities($totalpins);?></span>

                                 </h5>
								 <hr>
                                         <a class="card-link" href="manage-pins.php"></small>Manage</small></a>  <a class="card-link" href="create-pin.php"><small>Add New</small></a>
										</div>
  </div>
  </div> -->


                                                 <div class="col-sm-6 col-lg-4 col-md-6">
									<div class="border-secondary border border-1 animate__animated animate__zoomIn shadow card">
                                        <?php
$sql7="SELECT id from admin where Role!=1";
$query7 = $dbh -> prepare($sql7);
$query7->execute();
$results7=$query7->fetchAll(PDO::FETCH_OBJ);
$totalusers=$query7->rowCount();
?>
<div class="card-body">
<h5 class="card-title">
											<span class="text-16 text-muted name"><small>TOTAL TEACHER ACCOUNTS</small></span>
											<br>
                                            <span class="text-24 font-weight-bolder"><?php echo htmlentities($totalusers);?></span>

                                             </h5>
											 <hr>
                                         <a class="card-link" href="manage-users.php"></small>Manage</small></a>  <a class="card-link" href="create-user.php"><small>Add New</small></a>
										</div>
  </div>
  </div>



                                        <?php } ?>
										</div>

 </div>



</div>



    </body>
    <?php if($_SESSION['role']==1) { ?>
    <div class="border  border-1 mb-4 rounded mx-2 p-2">
    	<i class="fal text-vermillion fa-info-circle"></i> &nbsp;<a  href="#form1" id="formButton" class="text-primary" >Click here to quickly check a student's result</a>.
    </div>
    <div  class="container mb-4" id="form1">
       <div class="card shadow-sm">
       <div class="card-body">
          <div class="card-title text-center">
						<p class="h3 text-muted font-weight-bold mb-2">Result Checker</p>
					  </div>
          <form class="form-floating" action="result" method="post">
						<div class="mb-4 form-floating">
						  <input type="text" class="form-control" id="regnum" required="required" placeholder="Enter Your Reg Number" autocomplete="on" name="regnum">
						   <label for="regnum">Registration Number:</label>
						</div>


						<div class="form-floating mb-4">

						  <select name="class" class="form-select" id="Class" required>
						 <option value="" disabled selected hidden>-- Select --</option>

							<?php
// Get class list in numerical order
 $sql = "SELECT id,ClassName from tblclasses where ClassName!='Graduated' order by ClassNameNumeric";
							$query = $dbh->prepare($sql);
							$query->execute();
							$results=$query
->fetchAll(PDO::FETCH_OBJ);
							if($query->rowCount() > 0)
							{
							foreach($results as $result)
							{   ?>
							<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->ClassName); ?></option>
	<?php }}?>
</select>
   <label for="Class">Class:</label>
</div>
<div class="mb-4 form-floating">
						  <select name="term" class="form-select" id="term" required>
							<option value="" disabled selected hidden>Select Term</option>
							<?php
// Get terms list
 $sql = "SELECT id,TermName from tblterms order by TermName";
							$query = $dbh->prepare($sql);
							$query->execute();
							$results=$query
->fetchAll(PDO::FETCH_OBJ);
							if($query->rowCount() > 0)
							{
							foreach($results as $result)
							{   ?>
							<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->TermName); ?></option>
	<?php }}?>
</select>
						  <label for="term">Term:</label>
</div>
<div class="form-floating mb-4">

						  <select name="session" class="form-select" id="session" required>
							<option disabled selected hidden value="">Select Academic Session</option>
							<?php
// Get class list in numerical order
 $sql = "SELECT id,SessionName from tblsessions order by SessionName";
							$query = $dbh->prepare($sql);
							$query->execute();
							$results=$query
->fetchAll(PDO::FETCH_OBJ);
							if($query->rowCount() > 0)
							{
							foreach($results as $result)
							{   ?>
							<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->SessionName); ?></option>
	<?php }}?>
</select>
<label for="session">Academic Session:</label>
</div>
						<div class="form-group mb-4">

							<button type="submit" class="btn btn-primary float-right">Check Result</button>
						</div>
  </form>

             </div>
             </div>
             </div>
    <?php }?>

    <div class="border mb-5  border-2 rounded mx-2 p-2">
    	<i class="fal text-vermillion fa-info-circle"></i> &nbsp;<a class="text-primary" href="https://wa.me/2348054841869">Click to report an issue/make a request</a>.
    </div>

    <script>
    $(document).ready(function() {
  $("#formButton").click(function() {
    $("#form1").toggle();
  });
  $("#smile").click(function() {
     $("#smile").toggleClass("fa-smile fa-laugh");
$("#smile").toggleClass("fa-rotate-0 fa-rotate-45"); });
});</script>


<script>
const text=document.getElementById("quote");
const author=document.getElementById("author");

const getNewQuote = async () =>
{
    //api for quotes
    var url="https://type.fit/api/quotes";

    // fetch the data from api
    const response=await fetch(url);
    console.log(typeof response);
    //convert response to json and store it in quotes array
    const allQuotes = await response.json();

    // Generates a random number between 0 and the length of the quotes array
    const indx = Math.floor(Math.random()*allQuotes.length);

    //Store the quote present at the randomly generated index
    const quote=allQuotes[indx].text;

    //Store the author of the respective quote
    const auth=allQuotes[indx].author;

    if(auth==null)
    {
        author = "Anonymous";
    }

    //function to dynamically display the quote and the author
    text.innerHTML=quote;
    author.innerHTML="~ "+auth;


}
getNewQuote();
</script>
<?php include('includes/footer.php');?>
</html>
<?php } ?>
