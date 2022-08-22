<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(empty($_SESSION['alogin']))
    {
    header("Location: admin.php");
    }


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Manage Users</title>
<?php include('includes/header.php'); ?>

    </head>
    <body>
<?php include('includes/leftbar.php'); ?>
   <ul class="breadcrumb">
            							<li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
                                        <li class="breadcrumb-item"> Users</li>
            							<li class="active breadcrumb-item">Manage Users</li>
            						</ul>
                        <div class="container-fluid">

                                    <h2 class="h2 title">Manage Teachers</h2>

                                 <?php if($_SESSION['role']==1) { ?>
       <div class="card">
                                            <div class="card-body">

                                                    <h5 class="h5 card-title">View Info</h5>
   <?php include('includes/scroll.php');?>


<section id="printable">
    <div class="table-responsive">
                                                <table id="example" class="table-responsive-md table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Username</th>
                                                            <th>Email </th>
                                                            <th>Class</th>
                                                           <th>Role</th>


                                                            <th><?php if($result->Role != 1) { ?> Action <?php } else { } ?></th>

                                                        </tr>
                                                    </thead>

                                                    <tbody>
<?php $sql = "SELECT a.id,c.ClassName, a.Role, a.UserName, a.Email from admin a  join tblclasses c on c.id=a.ClassId where a.Role!=1 order by a.Role,a.UserName";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
$id=$result->id;  ?>
<tr>
 <td><?php echo htmlentities($cnt);?></td>
                                                            <td><?php echo strip_tags($result->UserName);?></td>
                                                            <td><?php echo strip_tags($result->Email);?></td>
                                                            <td><?php echo strip_tags($result->ClassName); ?></td>
                                                            <?php if($result->Role==1) { $role="Administrator"; } else { $role="Teacher"; }?>

                                                            <td><?php echo $role; ?> </td>






      <td>
         <?php if($result->Role != 1) { ?>
<a class="me-3" href="edit-user.php?aid=<?php echo htmlentities($result->id);?>" title="Edit User"><i class="far fa-edit"></i>Edit</a>
<a id="delete" class="text-vermillion" href="javascript:void" data-name="<?php echo strip_tags($result->UserName);?>" data-id="<?php echo $result->id;?>" title="Delete User"><i class="far fa-trash-alt"></i> Delete </a>
<?php } else {  } ?>


</td>

</tr>
<?php $cnt++;}} ?>


                                                    </tbody>
 <tfoot>
                                                        <tr>
                                                          <th>#</th>
                                                            <th>Username</th>
                                                            <th>Email</th>
                                                            <th>Class</th>
                                                            <th>Role</th>
                                                               <?php if($result->Role != 1) { ?>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </tfoot>
                                                </table>

 <a class="btn btn-outline-primary float-right mt-3" href="create-user.php">Add New</a>
     <?php include('includes/printtext.php');?>
                                            </div>
                                          </div>
                                        </section>
                                        </div>





        </div>

<?php include('includes/scripts.php'); ?>
<script>
	// Load DataTables
$(document).ready( function() {
  $('#example').DataTable();


  $(document).on('click', '#delete', function(){
              var id = $(this).data('id');
              var el = this;
              var name = $(this).data('name');
              swal.fire({
                  title: 'Are you sure? <h6>(Page closes in 10 seconds)</h6>',
                  html: "<b>NB:</b> <i>Doing this will delete the teacher <u><b>" + name + "</b></u> from the database.</i>",
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
                          url: 'remove-user.php?htaccess=0',
                          type: 'POST',
                          data: {id:id},
                          dataType: 'json'
                      })
                      .done(function(response){
                          swal.fire('Oh Yeah!', "The teacher <b><u>" + name + "</u></b> has been deleted successfully.", response.status);
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
  <?php include('includes/printscript.php');?>
</div>
<?php } else { ?>
   <div class="container ">
      <div class=" alert alert-info">Sorry,  you are not allowed to view this page, please return to <a href="dashboard.php">Dashboard</a>.</div>
   <?php } ?>
    </body>
<?php include('includes/footer.php');?>
</html>
