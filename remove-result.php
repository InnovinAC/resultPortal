<?php
include "../includes/config.php";


   $cid = $_POST['cid'];
   $tid = $_POST['tid'];
   $stid = $_POST['stid'];
   $sesid = $_POST['sesid'];

if($cid != 0 && $tid != 0 && $stid != 0 && $sesid != 0){

	// Check record exists
	$checkRecord = $dbh->prepare("SELECT * FROM tblresult WHERE StudentId=:stid and TermId=:tid and SessionId=:sesid and ClassId=:cid");
	$checkRecord->execute([':stid'=>$stid,':tid'=>$tid,':sesid'=>$sesid,':cid'=>$cid]);
	$totalrows = $checkRecord->rowCount();

	if($totalrows > 0){
		// Delete record
		$query = $dbh->prepare("DELETE FROM tblresult WHERE StudentId=:stid and TermId=:tid and SessionId=:sesid and ClassId=:cid");
    	$query2 = $dbh->prepare("DELETE FROM tblratings WHERE StudentId=:stid and TermId=:tid and SessionId=:sesid and ClassId=:cid");
      	$query3 = $dbh->prepare("DELETE FROM tblremarks WHERE StudentId=:stid and TermId=:tid and SessionId=:sesid and ClassId=:cid");
        	$query4 = $dbh->prepare("DELETE FROM tblmarks WHERE StudentId=:stid and TermId=:tid and SessionId=:sesid and ClassId=:cid");
		$query->execute([':stid'=>$stid,':tid'=>$tid,':sesid'=>$sesid,':cid'=>$cid]);
    $query2->execute([':stid'=>$stid,':tid'=>$tid,':sesid'=>$sesid,':cid'=>$cid]);
    $query3->execute([':stid'=>$stid,':tid'=>$tid,':sesid'=>$sesid,':cid'=>$cid]);
    $query4->execute([':stid'=>$stid,':tid'=>$tid,':sesid'=>$sesid,':cid'=>$cid]);


		echo 1;
		exit;
	}else{
        echo 0;
        exit;
    }
}

echo 0;
exit;
