<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {
    header("Location: admin.php");
    }
    else{
 //code for activating Subject
if(isset($_GET['acid']))
{
$acid=intval($_GET['acid']);
$status=1;
$sql="update tblsubjectcombination set status=:status where id=:acid ";
$query = $dbh->prepare($sql);
$query->bindParam(':acid',$acid,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$msg="Subject combination activated successfully.";
}

 // code to deaactivate subject
if(isset($_GET['did']))
{
$did=intval($_GET['did']);
$status=0;
$sql="update tblsubjectcombination set status=:status where id=:did ";
$query = $dbh->prepare($sql);
$query->bindParam(':did',$did,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$msg="Subject combination deactivated successfully.";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Admin | Manage Subjects Combination</title>
<?php include('includes/header.php');?>


    </head>
    <body>
<?php include('includes/leftbar.php');?>

  <ul class="breadcrumb">
            							<li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="manage-subjects.php">Subjects</a></li>
            							<li class="active breadcrumb-item"><a href="manage-subjectcombination.php">Combinations</a></li>
            						</ul>
                        <div class="container-fluid">
                                    <h2 class="title">Manage Subjects Combination</h2>

                        </div>
                            <div class="container-fluid">

   <div class="card">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h5>View Subjects Combination Info</h5>
                                                </div>

<?php if($msg){?>
<div class="alert alert-success" role="alert">
<span class='far fa-check-circle'></span>
 <strong>Great job! </strong><?php echo htmlentities($msg); ?>
 </div><?php }
else if($error){?>
    <div class="alert alert-danger" role="alert">
                                            <strong>Oh crap! </strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>

   <?php include('includes/scroll.php');?>
                                    <section id="printable">
                                      <div class="table-responsive">
                                                <table id="example" class="table table-responsive-md table-striped table-bordered" cellspacing="0" border="1" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Class</th>
                                                            <th>Subject </th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

<?php
if($_SESSION['role'] !=1) {
   $condition="where ClassId=".$_SESSION['class']; }
 $sql = "SELECT tblclasses.ClassName,tblclasses.ClassNameNumeric,tblsubjects.SubjectName,tblsubjectcombination.id as scid,tblsubjectcombination.status from tblsubjectcombination join tblclasses on tblclasses.id=tblsubjectcombination.ClassId  join tblsubjects on tblsubjects.id=tblsubjectcombination.SubjectId $condition order by tblclasses.ClassNameNumeric,tblsubjects.SubjectName";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
$id = $result->scid;?>
<tr>
 <td><?php echo htmlentities($cnt);?></td>
                                                            <td><?php echo htmlentities($result->ClassName);?></td>
                                                            <td><?php echo htmlentities($result->SubjectName);?></td>
                                                             <td><?php $stts=$result->status;
switch($stts) {
  case 0:
  echo "<span class='text-danger'>Inactive</span>";
  break;
  case 1:
  echo "<span class='text-success'>Active</span>";
  break;
}                                       ?></td>

<td>
<?php if($stts=='0')
{ ?>
<a id="activate" class="text-success me-4" href="javascript:void" data-subject="<?php echo htmlentities($result->SubjectName);?>" data-clas="<?php echo htmlentities($result->ClassName);?>" data-url="manage-subjectcombination.php?acid=<?php echo htmlentities($result->scid);?>"><i class="fal fa-lightbulb-on" title="Activate Record"></i>  Activate</a>  <?php } else {?>

<a id="deactivate" class='text-vermillion me-4' href="javascript:void" data-subject="<?php echo htmlentities($result->SubjectName);?>" data-clas="<?php echo htmlentities($result->ClassName);?>" data-url="manage-subjectcombination.php?did=<?php echo htmlentities($result->scid);?>" title="Deactivate Record"> <i class="far fa-power-off"></i> Deactivate </a>
<?php }?>
<a class="text-danger" href="javascript:void" id="delete" data-subject="<?php echo htmlentities($result->SubjectName);?>" data-clas="<?php echo htmlentities($result->ClassName);?>" data-id='<?php echo $result->scid;?>' title="Delete Record"><i class="fal fa-trash-alt"></i> Delete </a></td>
</tr>
<?php $cnt=$cnt+1;}} ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Class</th>
                                                            <th>Subject</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
</section>
<a class="btn btn-outline-primary float-right mt-3" href="add-subjectcombination.php">Add New</a>

                                  <?php include('includes/printtext.php');?>



                                </div>
</div>
</section>

                            </div>
                    </div>
            </div>

        </div>
 <?php include('includes/scripts.php'); include('includes/footer.php');?>

        <?php include('includes/printscript.php');?>
        <script>
          $(document).ready( function() {
  $('#example').DataTable();

  // code to de-activate subject combination
  $(document).on('click', '#deactivate', function(){
              var id = $(this).data('id');
              var el = this;
              var url = $(this).data('url');
              var clas = $(this).data('clas');
              var subject = $(this).data('subject');
              swal.fire({
                  title: 'Are you sure you want to deactivate this subject combination? <h6>(Page closes in 10 seconds)</h6>',
                  html: "<b>NB:</b> <i>The subject <b>" + subject + "</b> will no longer be able to be added to new results for <b>" + clas + "</b> until it is re-activated.</i>",
                  icon: 'warning',
                  timer: 10000,
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Go ahead',
                  cancelButtonText: 'Cancel',
              }).then((result) => {
                  if (result.value){
                    window.location.replace(url)
                  }
              })
          });

          // code to activate subject combination
          $(document).on('click', '#activate', function(){
                      var id = $(this).data('id');
                      var el = this;
                      var url = $(this).data('url');
                      var clas = $(this).data('clas');
                      var subject = $(this).data('subject');
                      swal.fire({
                          title: 'Are you sure you want to activate this subject combination? <h6>(Page closes in 10 seconds)</h6>',
                          html: "<b>NB:</b> <i>The subject <b>"+subject+"</b> will now be available to be added to new results for <b>"+clas+"</b></i>",
                          icon: 'warning',
                          timer: 10000,
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Go ahead',
                          cancelButtonText: 'Cancel',
                      }).then((result) => {
                          if (result.value){
                            window.location.replace(url)

                          }
                      })
                  });


                  // code to delete subject Combination
                  $(document).on('click', '#delete', function(){
                                  var id = $(this).data('id');
                                  var el = this;
                                  var url = $(this).data('url');
                                  var clas = $(this).data('clas');
                                  var subject = $(this).data('subject');
                                  swal.fire({
                                      title: 'Are you sure you want to delete this subject? <h6>(Page closes in 10 seconds)</h6>',
                                      html: "<b>NB:</b> <i>The subject <b>"+subject+"</b> will no longer be available to be added to new results for <b>"+clas+"</b></i>",
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
                                            url: 'remove-subjectcombination',
                                            type: 'POST',
                                            data: {id:id},
                                            dataType: 'json'
                                        })

                                          .done(function(response){
                                              swal.fire('Oh Yeah!', "The subject <b><u>" + subject + "</u></b> has been deleted from <b>"+ clas +"</b>.", response.status);
                                              $(el).closest('tr').css('background','tomato');
                                              $(el).closest('tr').fadeOut(900,function(){
                                                  $(this).remove();
                                              });

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
</html>
<?php } ?>
