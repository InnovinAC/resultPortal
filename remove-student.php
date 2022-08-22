<?php

if ($_POST['id']) {

    require_once '../includes/config.php';

    $id = intval($_POST['id']);
    $query = $dbh->prepare("DELETE FROM tblstudents WHERE StudentId=:id");
    $query2 = $dbh->prepare("DELETE FROM tblresult WHERE StudentId=:id");
    $query3 = $dbh->prepare("DELETE FROM tblremarks WHERE StudentId=:id");
    $query4 = $dbh->prepare("DELETE FROM tblmarks WHERE StudentId=:id");
    $query5 = $dbh->prepare("DELETE FROM tblratings WHERE StudentId=:id");


    $query->execute([':id'=>$id]);
    $query2->execute([':id'=>$id]);
    $query3->execute([':id'=>$id]);
    $query4->execute([':id'=>$id]);
    $query5->execute([':id'=>$id]);

    echo $id;



}
