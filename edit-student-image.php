<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {   
    header("Location: admin.php"); 
    }
    else{

$stid=intval($_GET['stid']);
// Code to update student information
if(isset($_FILES['image']) || isset($_POST['submit'])){
      $error= array();
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $extensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$extensions)=== false){
         $error[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 153600) {
         $error[]='File size must not exceed 300KB';
      }
      
      if(empty($error)==true) {
         $query=$dbh->prepare("select Image from tblstudents where StudentId=".$stid);
         $query->execute();
         $result=$query->fetch();
         unlink("students/".$result['Image']);
         
         move_uploaded_file($file_tmp,"students/".$file_name);
       
         
         $query1=$dbh->prepare("update tblstudents set Image=:image where StudentId=:stid");
         $query1->bindParam(":image",$file_name,PDO::PARAM_STR);
         $query1->bindParam(":stid",$stid,PDO::PARAM_INT);
         $query1->execute();
         
         
         
         $msg[] = "<div class='alert alert-success'><i class='far fa-check-circle'></i> Image Uploaded Successfully</div>";
      }else{
         // print_r($errors);
      }

}



?>
<!DOCTYPE html>
<html lang="en">
    <head>
     
        <title>Admin | Change Student Image</title>
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
                                        <li class="breadcrumb-item active">Edit Student Image</li>
                                    </ul>
                     <div class="container-fluid">
                          
                                    <h2 class="title">Student Image</h2>
                           
                        </div>
                        <div class="container-fluid">
      <div class="card">
      <div class="card-body">
       <div class="card-title">
      <h5 class="text-muted font-weight-bold">Change the image</h5>
                                            </div>
                                            <div class="alert alert-info"><i class="far fa-info-circle"></i> NB: Changing the image would delete the previously assigned image.</div>
  
<?php if(isset($_POST['submit'])) {
if($msg){ implode("",$msg); ?>
 <?php } 
else if($error){ implode("",$error); }}?>
                                                
<?php 

$sql = "SELECT tblstudents.ClassId,tblstudents.Image,tblstudents.StudentName,tblstudents.RegNum,tblstudents.RegDate,tblstudents.StudentId,tblstudents.Gender,tblclasses.ClassName from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId where tblstudents.StudentId=:stid";
$query = $dbh->prepare($sql);
$query->bindParam(':stid',$stid,PDO::PARAM_STR);
$query->execute();
$result=$query->fetch();
$cnt=1;
if($query->rowCount() > 0)
{
   
   ?>
      <?php if($_SESSION['role'] != 1 && $_SESSION['class'] != $result['ClassId']) { ?>
                <div class="alert alert-warning"><i class="far fa-info-circle"></i> Sorry, you're not allowed to change the image of a student whom is not in your class. The selected student is currently in <b><?php echo $result['ClassName'];?></b>.</div>
                <?php } else { ?> 
      <table class=" table table-bordered table-striped">
         <tbody>
         <tr><td>Student Name</td><td><?php echo $result['StudentName']; ?></td></tr>
         <tr><td>Registration Number</td><td><?php echo $result['RegNum'];?></td></tr>
         <tr><td>Current Class</td><td><?php echo $result['ClassName'];?></td></tr>
         </tbody>
         </table>
         
         <h4> Current Image: </h4>
          <img class="border border-primary w-50 d-flex mx-auto p-2" src="students/<?php echo htmlentities($result['Image']); ?>">
             

<form method="post" name="form" enctype="multipart/form-data">
<br><br>
   <div class="row py-4">
        <div class="col-lg-6 mx-auto">

            <!-- Upload image input-->
            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white border border-muted shadow-sm">
                <input id="uplovad" type="file" hidden onchange="readURL(this);" name="image" class="form-control border-0">
                
                <div class="input-group-append">
                    <label for="uplovad" class="float-right btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                </div>
            </div>

            <!-- Uploaded image area-->
            <p class="font-italic text-teal text-center">The new image uploaded will be rendered inside the box below.</p>
            <div class="image-area mt-4"><img id="imageResult" src="#" alt="" class="img-fluid shadow-sm mx-auto d-block"></div>

        </div>
    </div>



                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                                        </div>
                                                    
                                                </form>

</div>

                                    <?php }}  else {  echo "<div class='alert alert-info'>
<span class='far fa-info-circle'></span>
Sorry, the selected student does not exist. <a class='alert-link text-underline' href='manage-students.php'>Go back</a> and try again.</div>"; }?>  
                    </div>
                </div>
            </div>
     
        </div>
    
    </body>
 <?php 
 include('includes/scripts.php'); ?>
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
var infoArea = document.getElementById( 'upload-label' );

input.addEventListener( 'change', showFileName );
function showFileName( event ) {
  var input = event.srcElement;
  var fileName = input.files[0].name;
  infoArea.textContent = 'File name: ' + fileName;
} 
</script>

<?php
 include('includes/footer.php');?>
</html>
<?PHP } ?>