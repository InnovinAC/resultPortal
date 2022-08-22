<?php
session_start();
error_reporting(0);
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

        <title>Admin | Manage Subjects</title>
   <?php include('includes/header.php');?>


    </head>
    <body>

<?php include('includes/leftbar.php');?>
      <ul class="breadcrumb">
            							<li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
                                        <li class="breadcrumb-item"> Subjects</li>
            							<li class="breadcrumb-item active"><a href="manage-subjects.php">Manage Subjects</a></li>
            						</ul>
                        <div class="container-fluid">
                                    <h2 class="h2 title">Manage Subjects</h2>


 <div class="card">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h5 class="h5">View Subjects Info</h5>
                                                </div>

<?php if($msg){?>
<div class="alert alert-success" role="alert">
 <strong>Great job! </strong><?php echo htmlentities($msg); ?>
 </div><?php }
else if($error){?>
    <div class="alert alert-danger" role="alert">
                                            <strong>Something's wrong! </strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>

   <?php // include('includes/scroll.php');?>
   <section id="printable">
       <div class="table-responsive">
<table id="example" class="table table-striped table-bordered" border="1" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Subject Name</th>

                                                                       <?php  if($_SESSION['role']==1) { ?>
                                                            <th>Action</th> <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                          <th>#</th>
                                                             <th>Subject Name</th>

                                                   <?php  if($_SESSION['role']==1) { ?>
                                                            <th>Action</th><?php } ?>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
<?php
 $sql = "SELECT id,SubjectName from tblsubjects order by SubjectName";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
$id=$result->id; ?>
<tr>
 <td><?php echo htmlentities($cnt);?></td>
                                                            <td><?php echo htmlentities($result->SubjectName);?></td>

                                                  <?php  if($_SESSION['role']==1) { ?>
<td>
<a class='badge float-left py-2 bg-primary' href="edit-subject.php?subjectid=<?php echo htmlentities($result->id);?>" title="Edit Record">Edit </a>
<span class="badge delete py-2 bg-danger" data-id='<?php echo $result->id;?>' title="Delete Record"> Delete </span>

</td> <?php } ?>
</tr>
<?php $cnt=$cnt+1;}} ?>


                                                    </tbody>
                                                </table>
</section>

 <a class="float-right btn btn-outline-primary mt-3" href="create-subject.php">Add New</a>
<?php include('includes/printtext.php');?>

  </div>
</div>
</section>
</div>
   </div>

        </div>
<?php include('includes/scripts.php');?><?php include('includes/footer.php');?>
<?php include('includes/printscript.php');?>
        <script>
            $(function($) {
                $('#example').DataTable();
} );

</script>

<script>

// Start Ajax Delete
$(document).ready(function(){

   // Delete
   $(document).on('click', '.delete', function(){
       var el = this;

       // Delete Id
       var id = $(this).data('id');

       var confirmalert = confirm("Are you sure? ");
       if (confirmalert == true) {
           // AJAX Request
           $.ajax({
               url: 'remove-subject.php',
               type: 'POST',
               data: { id:id },
               success: function(response){

                   if(response == 1){
                       // Remove row from HTML Table
                       $(el).closest('tr').css('background','tomato');
                       $(el).closest('tr').fadeOut(900,function(){
                           $(this).remove();
                       });
                   }else{
                       alert('Invalid ID.');
                   }
               }
           });
       }
   });
});

        </script>
    </body>



</html>
<?php } ?>
