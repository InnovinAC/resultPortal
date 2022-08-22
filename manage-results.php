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

        <title>Admin | Manage Results</title>

      <?php include('includes/header.php');?>


    </head>
    <body>

<?php include('includes/leftbar.php');?>
<ul class="breadcrumb">
            							<li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
	<li class="breadcrumb-item">Results</li>
                                        <li class="active breadcrumb-item"><a href="manage-results.php">Manage Results</a></li>

            						</ul>
                        <div class="container-fluid">
                                    <h2 class="h2 title">Manage Results</h2>
                                </div>

                            <div class="container-fluid">

                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h5 class="text-muted font-weight-bolder h5">View Results Info</h5>
                                                </div>

<?php if($msg){?>
<div class="alert alert-success " role="alert">
 <strong>Good job! </strong><?php echo htmlentities($msg); ?>
 </div><?php }
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Something's wrong! </strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>


<?php include('includes/scroll.php');?>
<section id="printable">
    <div class="table-responsive">
                                                <table id="example" class="table-responsive-md dataTable table table-striped table-bordered" cellspacing="0" border="1" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Student Name</th>
                                                            <th>Reg No</th>
                                                            <th>Class</th>
<th>Term</th>
<th>Academic Session</th>
                                                            <th>Reg Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                          <th>#</th>
                                                            <th>Student Name</th>
                                                            <th>Reg No</th>
                                                            <th>Class</th>
<th>Term</th>
<th>Academic Session</th>
                                                            <th>Reg Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>

<?php
if($_SESSION['role']!=1) {
   $condition="where tblresult.ClassId=".$_SESSION['class']." && tblresult.SessionId=".$_SESSION['session']; }
$sql = "SELECT distinct tblterms.TermName,tblresult.TermId,tblresult.SessionId, tblstudents.StudentName,tblsessions.SessionName,tblresult.ClassId,tblstudents.RegNum,tblstudents.RegDate,tblresult.StudentId,tblstudents.Status,tblclasses.ClassName from tblresult join tblterms on tblterms.id=tblresult.TermId join tblstudents on tblstudents.StudentId=tblresult.StudentId  join tblclasses on tblclasses.id=tblresult.ClassId join tblsessions on tblsessions.id=tblresult.SessionId $condition order by tblsessions.id,tblterms.id desc, tblclasses.ClassNameNumeric,tblstudents.StudentName";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{

$cid = $result->ClassId;
$tid = $result->TermId;
$stid = $result->StudentId;
$sesid = $result->SessionId;
 ?>

<tr>
 <td><?php echo htmlentities($cnt);?></td>
                                                            <td><?php echo htmlentities($result->StudentName);?></td>
                                                            <td><?php echo htmlentities($result->RegNum);?></td>
                                                            <td><?php echo htmlentities($result->ClassName);?></td>
 <td><?php echo htmlentities($result->TermName);?></td>
  <td><?php echo htmlentities($result->SessionName);?></td>
                                                            <td><?php echo htmlentities($result->RegDate);?></td>
                                                             <td><?php if($result->Status==1){
echo htmlentities('Active');
}
else{
   echo htmlentities('Blocked');
}
                                                                ?></td>
<td>
<a class="me-3" href="edit-result.php?stid=<?php echo htmlentities($result->StudentId);?>&cid=<?php echo htmlentities($result->ClassId);?>&tid=<?php echo htmlentities($result->TermId);?>&sesid=<?php echo htmlentities($result->SessionId);?>" title="Edit Record"><i class="fal fa-edit"></i>Edit</a>

 <a href="javascript:void" title="Delete Record" class="text-vermillion" id="delete" data-session="<?php echo $result->SessionName;?>" data-term="<?php echo $result->TermName;?>" data-clas="<?php echo $result->ClassName;?>" data-regnum="<?php echo $result->RegNum;?>" data-name="<?php echo $result->StudentName;?>" data-cid="<?php echo $result->ClassId;?>" data-tid="<?php echo $result->TermId;?>" data-stid="<?php echo $result->StudentId;?>" data-sesid="<?php echo $result->SessionId;?>"><i class="fal fa-trash-alt"></i> Delete</a>


</td>
</tr>
<?php $cnt=$cnt+1;}} ?>


                                                    </tbody>
                                                </table>
</section>

 <a class="btn btn-outline-primary float-right mt-3" href="add-result.php">Add New</a>

<?php include('includes/printtext.php');?>


                                        </div>
                                      </div>
                                    </section>
                                    </div>



        </div>


   <?php include('includes/scripts.php');?>
<?php include('includes/printscript.php');?>
<script>
  // Load DataTables
$(document).ready( function() {
  $('#example').DataTable();



          $(document).on('click', '#delete', function(){
              var cid = $(this).data('cid');
              var tid = $(this).data('tid');
              var stid = $(this).data('stid');
              var sesid = $(this).data('sesid');
              var el = this;
              var name = $(this).data('name');
              var term = $(this).data('term');
              var clas = $(this).data('clas');
              var session = $(this).data('session');
              var regnum = $(this).data('regnum');
              swal.fire({
                  title: 'Are you sure you want to delete this result? <h6>(Page closes in 15 seconds)</h6>',
                  html: '<p>See details below</p><div class="container">\n<table class="table table-bordered table-striped" width="100%"><tbody><tr><td><strong>Student Name</strong></td><td>'+ name +'</td></tr><tr><td><strong>Registration Number</strong></td><td>'+ regnum +'</td></tr><tr><td><strong>Class</strong></td><td>'+ clas +'</td></tr><tr><td><strong>Term</strong></td><td>'+ term +'</td></tr><tr><td><strong>Academic Session</strong></td><td>'+ session +'</td></tr></tbody></table></div>',
                  icon: 'warning',
                  timer: 15000,
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Go ahead',
                  cancelButtonText: 'Cancel',
              }).then((result) => {
                  if (result.value){
                      $.ajax({
                          url: 'remove-result.php?htaccess=0',
                          type: 'POST',
                          data: {cid:cid,tid:tid,stid:stid,sesid:sesid},
                          dataType: 'json'
                      })
                      .done(function(response){
                          swal.fire('Oh Yeah!', "The student <b><u>" + name + "</u></b> has been deleted successfully.", response.status);
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
<?php include('includes/footer.php');?>
</html>
<?php } ?>
