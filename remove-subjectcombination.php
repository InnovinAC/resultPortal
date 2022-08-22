<?php
include "../includes/config.php";

$id = 0;
if(isset($_POST['id'])){
   $id = $_POST['id'];
}

if($id > 0){

	// Check that record exists
	$checkRecord = $dbh->prepare("SELECT * FROM tblsubjectcombination WHERE id=:id");
	$checkRecord->execute([":id"=>$id]);
	$totalrows = $checkRecord->rowCount();

	if($totalrows > 0){
		// Delete record
		$query = $dbh->prepare("DELETE FROM tblsubjectcombination WHERE id=:id");
		$query->execute([":id"=>$id]);
		echo 1;
		exit;
	}else{
        echo 0;
        exit;
    }
}

echo 0;
exit;
