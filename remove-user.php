<?php
include "../includes/config.php";

$id = 0;
if(!empty($_POST['id'])){
   $id = $_POST['id'];
}

if($id > 0){

	// Check record exists
	$checkRecord = $dbh->prepare("SELECT * FROM admin WHERE id=".$id);
	$checkRecord->execute();
	$totalrows = $checkRecord->rowCount();

	if($totalrows > 0){
		// Delete record
		$query = $dbh->prepare("DELETE FROM admin WHERE id=".$id);
		$query->execute();
		echo 1;
		exit;
	}else{
        echo 0;
        exit;
    }
}

echo 0;
exit;
