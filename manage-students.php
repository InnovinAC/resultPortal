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
        <title>Admin | Manage Students</title>
<?php include('includes/header.php'); ?>
    <link rel="stylesheet" href="../css/jquery.fancybox.min.css">
    </head>
    <body>
<?php include('includes/leftbar.php'); ?>
   <ul class="breadcrumb">
            							<li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
                                        <li class="breadcrumb-item"> Students</li>
            							<li class="active breadcrumb-item">Manage Students</li>
            						</ul>
                        <div class="container-fluid">

                                    <h2 class="h2 title">Manage Students</h2>


       <div class="card">
                                            <div class="card-body">

                                                    <h6 class="h5 text-muted card-title">View Students Info</h6>
   <?php include('includes/scroll.php');?>


<section id="printable">

  <div class='table-responsive'>
                                                <table id="example" class="table-responsive-md table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Student Name</th>
                                                            <th>Image</th>
                                                            <th>Reg No</th>
                                                            <th>Current Class</th>
<th>Gender</th>
                                                            <th>Reg Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
<?php if($_SESSION['role'] !=1) {
   $condition="where ClassId=:class"; }
$sql = "SELECT tblstudents.StudentId,tblstudents.Gender, tblstudents.StudentName,tblclasses.ClassNameNumeric,tblstudents.Image,tblstudents.RegNum,tblstudents.RegDate,tblstudents.StudentId,tblstudents.Status,tblclasses.ClassName from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId $condition order by tblclasses.ClassNameNumeric,tblstudents.StudentName";
$query = $dbh->prepare($sql);
if($_SESSION['role'] != 1) {
  $query->bindParam(':class',$_SESSION['class'],PDO::PARAM_STR);
}
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
$id = $result->StudentId;?>
<tr>
 <td><input type="checkbox" class="checkItem me-3" name="delete[]" value="<?php echo $result->StudentId;?>"><?php echo htmlentities($cnt);?></td>
                                                            <td><span id="studName"><?php echo htmlentities($result->StudentName);?></span></td>
                                                            <td><a href="students/<?php echo htmlentities($result->Image);?>" data-fancybox data-caption="<?php echo $result->StudentName;?>">
	<img width="20" class="rounded  d-flex mx-auto" src="students/<?php echo htmlentities($result->Image);?>" alt="" />
</a></td>
                                                            <td><?php echo htmlentities($result->RegNum);?></td>
                                                            <td><?php echo htmlentities($result->ClassName);?></td>
  <td><?php echo htmlentities($result->Gender);?></td>
                                                            <td><?php echo date("d M, Y g:i a", strtotime(htmlentities($result->RegDate)));?></td>
                                                             <td><?php if($result->Status==1){
echo htmlentities('Active');
}
else{
   echo htmlentities('Blocked');
}
                                                                ?></td>
<td>
<a class="me-3" href="edit-student.php?stid=<?php echo htmlentities($result->StudentId);?>" title="Edit Record"><i class="far fa-edit"></i>Edit</a>
<a href="javascript:void" title="Delete Record" class='text-vermillion' id="delete"  data-name='<?php echo $result->StudentName;?>' data-id='<?php echo $result->StudentId;?>'><i class="far fa-trash-alt"></i>Delete</a>
</td>
</tr>
<?php $cnt=$cnt+1;}} ?>


                                                    </tbody>
 <tfoot>
                                                        <tr>
                                                          <th>#</th>
                                                            <th>Student Name</th>
                                                            <th>Image</th>
                                                            <th>Reg No</th>
                                                            <th>Current Class</th>
<th>Gender</th>
                                                   <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
<p> <input type="checkbox" id="checkAll"> <label for="checkAll" class="control-label">Select All</label></p>
<i class="far fa-2x fa-level-up-alt fa-flip-horizontal"></i> With Selected:
<div>
 <a class="btn btn-outline-primary float-right mt-3" href="add-students.php">Add New</a>
     <?php include('includes/printtext.php');?>
   </div>
                                            </div>
                                          </div>
                                        </div>





        </div>

<?php include('includes/scripts.php'); ?>

  <?php include('includes/printscript.php');?>
   <script src="../js/jquery.fancybox.min.js"></script>
</div>
<script>
	// Load DataTables
$(document).ready( function() {
  $('#example').DataTable();



          $(document).on('click', '#delete', function(){
              var id = $(this).data('id');
              var el = this;
              var name = $(this).data('name');
              var table =  $('#example').DataTable();
              swal.fire({
                  title: 'Are you sure? <h6>(Page closes in 10 seconds)</h6>',
                  html: "<b>NB:</b> <i>Doing this will also delete every single copy of <u><b>" + name + "'s</b></u> result.</i>",
                  icon: 'warning',
                  timer: 10000,
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Go ahead',
                  cancelButtonText: 'Cancel',
              }).then((result) => {
                  if (result.value){
                      $.ajax({
                          url: 'remove-student.php?htaccess=0',
                          type: 'POST',
                          data: {id:id},
                          dataType: 'json'
                      })
                      .done(function(response){
                          swal.fire('Oh Yeah!', "The student <b><u>" + name + "</u></b> has been deleted successfully.", response.status);
                          $(el).closest('tr').css('background','tomato');
                          $(el).closest('tr').fadeOut(900,function(){
                              $(this).remove();
                          });
                        load('manage-students');
                      })
                      .fail(function(){
                          swal.fire('Damn!', 'Beats me, but something went wrong! Try again.', 'error');
                      });
                  }
              })
          });


      });

  </script>






    </body>
<?php include('includes/footer.php');?>
</html>
<?php } ?>
