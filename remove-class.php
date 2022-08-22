<?php 
include "../includes/config.php";

$id = 0;
if(isset($_POST['id'])){
   $id = $_POST['id'];
}

if($id > 0){

	// Check that record exists
	$checkRecord = $dbh->prepare("SELECT * FROM tblclasses WHERE id=".$id);
	$checkRecord->execute();
	$totalrows = $checkRecord->rowCount();

	if($totalrows > 0){
		// Delete record
		$query = $dbh->prepare("DELETE FROM tblclasses WHERE id=".$id);
		$query1 = $dbh->prepare("DELETE FROM tblresult WHERE ClassId=".$id);
		$query2 = $dbh->prepare("DELETE FROM tblsubjectcombination WHERE ClassId=".$id);
		$query3 = $dbh->prepare("DELETE FROM tblmarks WHERE ClassId=".$id);
		$query->execute();
		$query1->execute();
		$query2->execute();
		$query3->execute();
		echo 1;
		exit;
	}else{
        echo 0;
        exit;
    }
}

echo 0;
exit;
?>