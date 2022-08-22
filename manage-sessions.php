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

        <title>Admin | Manage Sessions</title>
   <?php include('includes/header.php');?>

<?php include('includes/scripts.php');?>
    </head>
    <body>

<?php include('includes/leftbar.php');?>
      <ul class="breadcrumb">
            							<li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
                                        <li class="breadcrumb-item"> Sessions</li>
            							<li class="breadcrumb-item active"><a href="manage-subjects.php">Manage Sessions</a></li>
            						</ul>
                        <div class="container-fluid">
                                    <h2 class="h2 title">Manage Sessions</h2>


 <div class="card">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h5 class="h5">View Sessions List</h5>
                                                </div>
                                                    <?php if($_SESSION['role']!=1) { ?>
                                              <div class="alert alert-warning"><i class="far fa-info-circle"></i> Sorry, you are not allowed access to this page. Kindly <a href="dashboard.php" class="alert-link text-underline">return to dashboard</a>.</div> <?php }  else {?>
<?php if($msg){?>
<div class="alert alert-success" role="alert">
 <strong>Great job! </strong><?php echo htmlentities($msg); ?>
 </div><?php }
else if($error){?>
    <div class="alert alert-danger" role="alert">
                                            <strong>Something's wrong! </strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>

   <?php include('includes/scroll.php');?>
   <section id="printable">
       <div class="table-responsive">
<table id="example" class="table table-striped table-bordered" border="1" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Session Name</th>


                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                          <th>#</th>
                                                             <th>Session Name</th>


                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
<?php
 $sql = "SELECT id,SessionName from tblsessions order by id";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
<tr>
 <td><?php echo htmlentities($cnt);?></td>
                                                            <td><?php echo htmlentities($result->SessionName);?></td>


<td>
<a class=" badge py-2 bg-primary" href="edit-session.php?sesid=<?php echo htmlentities($result->id);?>" title="Edit Record"> Edit </a>
<a class="badge py-2 bg-danger" href="delete-session.php?sesid=<?php echo htmlentities($result->id);?>" title="Delete Record"> Delete </a>

</td>
</tr>
<?php $cnt=$cnt+1;}} ?>


                                                    </tbody>
                                                </table>
</section>

 <a class="btn btn-outline-primary float-right mt-3" href="create-session.php">Add New</a>
<?php include('includes/printtext.php');?>
<?php } ?>
  </div>
</div>
</section>
</div>
   </div>

        </div>

<?php include('includes/printscript.php');?>
        <script>
            $(function($) {
                $('#example').DataTable();

            });
        </script>
    </body>


<?php include('includes/footer.php');?>
</html>
<?php } ?>
