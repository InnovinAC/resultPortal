<?php
	session_start();
	error_reporting(0);
	include('../includes/config.php');
	if(empty($_SESSION['alogin']))
    {
		header("Location: admin.php");
	}
    else{

		if(isset($_POST['submit']))
		{
			$class=$_POST['class'];


			foreach($_POST['subject'] as $subject) {
				$sql="SELECT ClassId,SubjectId FROM tblsubjectcombination where tblsubjectcombination.ClassId=:class && tblsubjectcombination.SubjectId=:subject";
				$query=$dbh->prepare($sql);
				$query->bindParam(':class',$class,PDO::PARAM_STR);
				$query->bindParam(':subject',$subject,PDO::PARAM_STR);
				$query->execute();
				$data=$query->fetchAll();
				if(empty($data)) {

					$class=$_POST['class'];

					// $subject=$_POST['subject'];
					$status=1;
					// multiple values


					$sql="INSERT INTO  tblsubjectcombination(ClassId,SubjectId,status) VALUES(:class,:subject,:status)";
					$query = $dbh->prepare($sql);
					$query->bindParam(':class',$class,PDO::PARAM_STR);
					$query->bindParam(':subject',$subject,PDO::PARAM_STR);
					$query->bindParam(':status',$status,PDO::PARAM_STR);
					$query->execute();
					$err = $query->errorInfo();
					echo $err[2];
					$lastInsertId = $dbh->lastInsertId();
					if($lastInsertId)
					{
						$msg="Subject combination(s) added successfully.";
					}
					else
					{
						$error="Something went wrong. Please try again.";
					}
				}
				else {
					$error="One or more of the selected subject combinations already exist(s). Try again.";

				}
			}}
	?>
	<!DOCTYPE html>
	<html lang="en">
		<head>

			<title>Admin | Add Subject Combination</title>
			<?php include('includes/header.php');?>
			<link href="../css/select2.min.css" rel="stylesheet ">
		</head>
		<body>

			<?php include('includes/leftbar.php');?>

			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
				<li class="breadcrumb-item"><a href="manage-subjectcombination.php">Subject Combinations</a></li>
				<li class="breadcrumb-item active">Add New</li>
			</ul>
			<div class="container-fluid">

				<h3 class="h3 title">Add Subject Combination</h2>

			</div>
			<div class="container-fluid">

				<div class="card">
					<div class="card-body">
						<div class="card-title">
							<h5 class="text-green-dark h5 font-weight-bold">Select Details.</h5>

						</div>

						<?php if($msg){?>
							<div class="alert alert-success" role="alert">
								<span class="far fa-check-circle"></span>
								<strong>Great job! </strong><?php echo htmlentities($msg); ?>
							</div><?php }
							else if($error){?>
							<div class="alert alert-danger" role="alert">
								<span class="far fa-times-circle"></span>
								<strong>Oh crap! </strong> <?php echo htmlentities($error); ?>
							</div>
						<?php } ?>
						<form class="form-floating" method="post">
							<div class="mb-4 form-floating">

								<select name="class" class="form-select" id="class" required="required">
									<option hidden selected value=""><i>Select Class</i></option>
									<?php if($_SESSION['role'] !=1) {
									$condition="where id=".$_SESSION['class']; }
									else {
										$query1 = $dbh->prepare("Select MAX(id) as max from tblclasses");
										$query1->execute();
										$lastId= $query1->fetch();
										$lastId = $lastId['max'];
										$condition = "where id < ".$lastId;
									}
									$sql = "SELECT ClassName,id from tblclasses $condition order by ClassNameNumeric";
									$query = $dbh->prepare($sql);
									$query->execute();
									$results=$query->fetchAll(PDO::FETCH_OBJ);
									if($query->rowCount() > 0)
									{
										foreach($results as $result)
										{   ?>
										<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->ClassName); ?></option>
									<?php }} ?>
								</select>
								<label for="class" class="control-label">Class:</label>
							</div>

							<div class="mb-4 form-group">
								<label for="default" class="control-label">Subject(s):</label>

								<select multiple="multiple" name="subject[]" class="select12 form-control" id="default" required="required">
									<option hidden value="">Select Subject(s)</option>
									<?php $sql = "SELECT SubjectName,id from tblsubjects ORDER by SubjectName";
										$query = $dbh->prepare($sql);
										$query->execute();
										$results=$query->fetchAll(PDO::FETCH_OBJ);
										if($query->rowCount() > 0)
										{
											foreach($results as $result)
											{   ?>
											<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->SubjectName); ?></option>
										<?php }} ?>
								</select>

							</div>



							<div class="form-group">
								<button type="submit" name="submit" class="btn btn-primary">Add Combination(s)</button>
							</div>

						</form>

					</div>
				</div>
			</div>
			<?php include('includes/scripts.php');?>


			<script src="js/select2.min.js"></script>
			<script>
				$(function($) {
                $(".select12").select2({
				placeholder: "Type here to search..." });

				});
			</script>
		</body>
		<?php include('includes/footer.php');?>
	</html>
<?PHP } ?>
