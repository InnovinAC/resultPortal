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
        <title>Admin | Manage Pins</title>
<?php include('includes/header.php'); ?>

    </head>
<body>
<?php include('includes/leftbar.php');?>
    <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
            							<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"> Pins</li>
            							<li aria-current="page" class="breadcrumb-item active"><a  href="manage-pins.php" class="text-primary">Manage Pins</a></li>
            						</ol>
									</nav>
<div class="container-fluid">

                                    <p class="h2 title text-center">Manage Pins</p>



   <section id="printable">

<div class="card">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <p class="h4"><code>View Pins Information</code></p>
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


<?php include('includes/scroll.php');?>

                                                <div class="table-responsive">
                                                <table id="example" class="table table-striped table-responsive-md table-bordered" border="1" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Pin</th>
                                                            <th>Usages Left</th>

                                                            <th>Creation Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                          <th>#</th>
                                                           <th>Pin</th>
                                                            <th>Usages Left</th>

                                                            <th>Creation Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
<?php $sql = "SELECT id,Pin,Trials from tblpins";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
$id = $result->id; ?>
<tr>
 <td><?php echo htmlentities($cnt);?></td>
                                                            <td><?php echo htmlentities($result->Pin);?></td>
                                                            <td><?php echo htmlentities($result->Trials);?></td>
                                                            <td><?php echo htmlentities($result->CreationDate);?></td>
<td>

<span title="Delete Record" class='py-2 badge bg-danger delete' data-id='<?php echo $id; ?>'>Delete</span>


</td>
</tr>
<?php $cnt=$cnt+1;}} ?>


                                                    </tbody>

                                                </table>

<a class="btn btn-outline-primary float-right mt-3" href="create-pin.php">Add New</a>
<?php include('includes/printtext.php');?>

                                </div>
                              </div>
</div>
</div>



     <?php include('includes/scripts.php'); ?>
        <script>
            $(function($) {
                $('#example').DataTable();
            });


        // Start Ajax Delete
        	$(document).ready(function(){

    // Delete
    $(document).on('click', '.delete', function(){
        var el = this;

        // Delete id
        var id = $(this).data('id');

        var confirmalert = confirm("Are you sure?");
        if (confirmalert == true) {
            // AJAX Request
            $.ajax({
                url: 'remove-pin.php',
                type: 'POST',
                data: { id:id },
                success: function(response){

                    if(response == 1){
                        // Remove row from HTML Table
                        $(el).closest('tr').css('background','tomato');
                        $(el).closest('tr').fadeOut(800,function(){
                            $(this).remove();
                        });
                    }else{
                        alert('Invalid ID.');
                    }
                }
            });
        }
    });
}); </script>
<?php include('includes/printscript.php'); include('includes/footer.php');?>
    </body>
</html>
<?php } ?>
