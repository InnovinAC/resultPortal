<?php
session_start();
error_reporting(1);
include('../includes/config.php');

if(empty($_SESSION['alogin']))
    {
    header("Location: admin.php");
    }
    else {
/* if(isset($_FILES['image'])){

      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

      $extensions= array("jpeg","jpg","png");
      if(empty($file_name)) {
         $error[]="<div class='alert alert-danger'><i class='far fa-times-circle'></i>No image selected</div>"; }
      if(in_array($file_ext,$extensions)=== false){
         $error[]="<div class='alert alert-danger'><i class='far fa-times-circle'></i>Image extension not allowed, please choose a JPEG or PNG file.</div>";

      }

      if($file_size > 153600) {
         $error[]="<div class='alert alert-danger'><i class='far fa-times-circle'></i> File size must not exceed 150KB</div>";
      }

      if(empty($error)==true) {
         $file_name="".$_POST['fullname']."(".$_POST['gender'].").".$file_ext;
         move_uploaded_file($file_tmp,"students/".$file_name);
         $msg[] = "<div class='alert alert-success'><i class='far fa-check-circle'></i> Image Uploaded Successfully</div>";
      }else{
         // print_r($errors);
      }
   */


if(isset($_POST['submit'])) {
$studentname=ucwords($_POST['fullname']);
$regnum=$_POST['regnum'];
$gender=$_POST['gender'];
$classid=$_POST['class'];
$dob=$_POST['dob'];
$status=1;
// $image= $file_name;
echo $image;
$sql="SELECT StudentName,Gender from tblstudents where StudentName=:studentname && Gender=:gender";
$sql1="SELECT RegNum from tblstudents where RegNum=:regnum";
$query=$dbh->prepare($sql);
$query1=$dbh->prepare($sql1);
$query->bindParam(':studentname',$studentname,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query1->bindParam(':regnum',$regnum,PDO::PARAM_STR);
$query->execute();
$query1->execute();

if(!empty($query->fetchAll())) {
$error[]="<div class='alert alert-danger alert-dismissible fade show'><i class='far fa-times-circle'></i> A $gender student with the name: $studentname already exists. Please try again. <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
}
else if(!empty($query1->fetchAll())) {
$error[]="<div class='alert alert-danger alert-dismissible fade show'><i class='far fa-times-circle'></i> A student with the registration number: $regnum already exists. Please try again. <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
}
else {
   if(!empty($studentname) && !empty($gender) && !empty($regnum)) {
$sql="INSERT INTO  tblstudents(StudentName,RegNum,Gender,ClassId,Status) VALUES(:studentname,:regnum,:gender,:classid,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':studentname',$studentname,PDO::PARAM_STR);
$query->bindParam(':regnum',$regnum,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':classid',$classid,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
// $query->bindParam(':image',$image,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg[]="<div class='alert alert-success alert-dismissible fade show'><i class='far fa-check-circle'></i> Student info added successfully. <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
}
else
{
$error[]="<div class='alert alert-danger alert-dismissible fade show'><i class='far fa-times-circle'></i> Something went wrong. Please try again. <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
}

}
} }
if(!empty($error)) {
$error=join($br,$error);
}

if(!empty($msg)) {
$msg=join($br,$msg);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Student Admission</title>
   <?php include('includes/header.php');?>
        <style>
           * ==========================================
* CUSTOM UTIL CLASSES
* ==========================================
*
*/
#upload {
    opacity: 0;
}

#upload-label {
    position: absolute;
    top: 50%;
    left: 1rem;
    transform: translateY(-50%);
}

.image-area {
    border: 2px dashed red;
    padding: 1rem;
    position: relative;
}

.image-area::before {
    content: 'Uploaded image result';
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.8rem;
    z-index: 1;
}

.image-area img {
    z-index: 2;
    position: relative;
}

</style>
    </head>
    <body>

                   <?php include('includes/leftbar.php');?>
                       <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
<li class="breadcrumb-item"><a href="manage-students.php">Students</a></li>
                                        <li class="breadcrumb-item active">Add New</li>
                                    </ul>

                     <div class="container-fluid">

                                    <h3 class="h3 title">Student Creation</h2>

                                </div>
                                </div>

                        <div class="mb-5 container-fluid">

                                        <div class="card shadow">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h5 class="text-muted font-weight-bold h5">Fill In The Student's Info.</h5>
                                                </div>

<?php if(isset($_POST['submit'])) {
if(!empty($error)){ echo $error;?>
 <?php }
else if(!empty($msg)){ echo $msg; ?>

                                        <?php } }?>


 <form class="mt-4" method="post" name="form" enctype="multipart/form-data">
   <!-- <div class="row py-4">
        <div class="col-lg-6 mx-auto"> -->

            <!-- Upload image input -->
              <!-- <label class="control-label">Student Image</label>
            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white border border-muted shadow-sm">
                <input hidden id="upload" type="file" onchange="readURL(this);" name="image" class="form-control border-0">

                <div class="float-right input-group-append">
                    <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="far fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose Image</small></label>
                </div>

            </div>
                     <span> File size should not exceed 150KB</span>
<div class="card mb-2">
   <div class="card-header">File Details Shown Here</div>
   <div class="card-body">
   <h4 class="mb-2 h4" id="upload-label"></h4>
   <h4 class="h4" id="upload-size"></h4>
   </div>
   </div> -->
            <!-- Uploaded image area-->
          <!--  <p class="font-italic text-teal text-center">The image uploaded will be rendered inside the box below.</p>
            <div class="image-area mt-4"><img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"></div>

        </div>
    </div> -->



<div class="mb-4 form-floating">
<input type="text" name="fullname" class="form-control" id="fName" required="required" placeholder="Type in name..." autocomplete="on">
<label for="fName">Full Name</label>
</div>

<div class="mb-4 form-floating">
<input type="text" name="regnum" class="form-control" id="regnum"  required="required" placeholder="Type in registration number..." autocomplete="on">
<label for="regnum">Registration Number</label>
</div>



<div class="mb-4 form-group">
<h6>Gender</h6>

<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="Male">
  <label class="form-check-label" for="inlineRadio1">Male</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Female">
  <label class="form-check-label" for="inlineRadio2">Female</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="gender" id="inlineRadio3" value="Other">
  <label class="form-check-label" for="inlineRadio3">Other</label>
</div>
</div>

   <div class="mb-4 form-floating">

 <select name="class" class="form-select" id="class" required="required">
<option hidden selected>Select Class</option>

<?php

 if($_SESSION['role'] !=1) {
   $condition="where id=".$_SESSION['class']; // if  not an admin, show only the class assigned to the teacher
 $cond = "&& ClassName != 'Graduated'"; // do not show the Graduated class
}


else {
$cond = "where ClassName != 'Graduated'"; // do not show the Graduated class
}

$sql = "SELECT id,ClassName from tblclasses $condition $cond ORDER BY ClassNameNumeric";
$query = $dbh->prepare($sql);
$query->execute();


if($query->rowCount() > 0)
{
      $results=$query->fetchAll(PDO::FETCH_OBJ);
   foreach($results as $result) {
 ?>
<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->ClassName); ?></option>


   <?php }} ?>

 </select>
    <label for="class">Class</label>
                                                        </div>

                                                    <div class="form-group">

                                                            <button type="submit" name="submit" class="btn btn-primary">Add Student</button>
                                                        </div>

                                                </form>

                                            </div>
            </div>
        </div>


 <?php include('includes/scripts.php');?>
 <script>
/*  ==========================================
    SHOW UPLOADED IMAGE
* ========================================== */
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageResult')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(function () {
    $('#upload').on('change', function () {
        readURL(input);
    });
});

/*  ==========================================
    SHOW UPLOADED IMAGE NAME
* ========================================== */
var input = document.getElementById( 'upload' );
var infoArea = document.getElementById( 'upload-label' )
var infoArea1 = document.getElementById('upload-size' );

input.addEventListener( 'change', showFileName );
input.addEventListener('change', showFileSize );




function showFileName( event ) {
  var input = event.srcElement;
  var fileName = input.files[0].name;
  infoArea.textContent = 'File name: ' + fileName;
}
function showFileSize( event ) {
   var input = event.srcElement;
   var fileSize = (input.files[0].size/1024).toFixed(2);
   infoArea1.textContent = 'File size: ' + fileSize + 'KB';
   }
</script>
    </body>
 <?php include('includes/footer.php');?>
</html>
<?PHP } ?>
