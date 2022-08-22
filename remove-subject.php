<?php
include "../includes/config.php";

$id = 0;
if(isset($_POST['id'])){
   $id = $_POST['id'];
}

if($id > 0){

	// Check record exists
	$checkRecord = $dbh->prepare("SELECT * FROM tblsubjects WHERE id=".$id);
	$checkRecord->execute();
	$totalrows = $checkRecord->rowCount();

	if($totalrows > 0){
		// Delete record
		$query = $dbh->prepare("DELETE FROM tblsubjects WHERE id=".$id);
		$query1 = $dbh->prepare("Delete from tblresult WHERE SubjectId=".$id);
		$query2 = $dbh->prepare("Delete from tblsubjectcombination where SubjectId=".$id);
    $query3 = $dbh->prepare("Delete from tblmarks WHERE SubjectId=".$id);
    $query4 = $dbh->prepare("Delete from tblremarks WHERE SubjectId=".$id);
    $query5 = $dbh->prepare("Delete from tblratings WHERE SubjectId=".$id);


		$query->execute();
		$query1->execute();
		$query2->execute();
    $query3->execute();
    $query4->execute();
    $query5->execute();
		echo 1;
		exit;
	}else{
        echo 0;
        exit;
    }
}

echo 0;
exit;
