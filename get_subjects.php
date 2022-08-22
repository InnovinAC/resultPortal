<?php
include('../includes/config.php');

// Code for Subjects
if(!empty($_POST["classid"]))
{
 $cid1=intval($_POST['classid']);
 if(!is_numeric($cid1)){

  echo htmlentities("Invalid Class");exit;
 }
 else{
 $status=0;
 $stmt = $dbh->prepare("SELECT tblsubjects.SubjectName,tblsubjects.id FROM tblsubjectcombination join  tblsubjects on  tblsubjects.id=tblsubjectcombination.SubjectId WHERE tblsubjectcombination.ClassId=:cid and tblsubjectcombination.status!=:stts order by tblsubjects.SubjectName");
$stmt->execute(array(':cid' => $cid1,':stts' => $status));
 if(empty($stmt->rowCount())) {
?>
<script>
// disable submit button if no subjects were found for the selected class
$('#submit').prop('disabled', true);
</script>
 <div class='alert alert-danger'><i class='far fa-frown'></i> No subject found for the selected class.</div>
<?php
} else {
?>
  <script>
  // re-enable the submit button if disabled previously due to lack of subjects in chosen class
  $('#submit').prop('disabled', false);
</script> <div class="alert alert-teal"><i class="far fa-info-circle"></i> If a student is not offering a particular subject, kindly leave both the CA and Exam scores empty.</div>
<div class="row mb-4 g-3">
   <?php
 while($row=$stmt->fetch(PDO::FETCH_ASSOC))
 {?>

     <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
    <div class="border mb-4 rounded border-dark shadow-sm py-4 px-3">
  <p>
<input type="hidden" name="subjectid[]" value="<?php echo htmlentities($row['id']); ?>"><b class="text-underline"><?php echo htmlentities($row['SubjectName']); ?></b></p><br>


<div class="form-floating mb-4"><input type="number" id="cas" min="0" max="" name="cas[]" value="" class="form-control" placeholder="Enter marks out of 40" autocomplete="off"><label>CA Score(Enter marks out of 40)</label></div>


<div class="form-floating"><input type="number" id="exams" min="0" max="" name="exams[]" value="" class="form-control" placeholder="Enter marks out of 60" autocomplete="off"><label>Exam Score(Enter marks out of 60)</label></div></div>
</div>


<?php  } ?>
</div>

<script>
  function maxValueCA(){
    var numbers = document.getElementById("cas");
    console.log(numbers);
    var maxQuantity = 40;

    numbers.addEventListener("input", function(e) {
        if(this.value>maxQuantity) {
            alert("The CA score cannot be greater than 40. Try again.");
            this.value = maxQuantity;
        }
    })
};
window.onload = maxValueCA();
</script>
<script>function maxValueExam(){
    var numbers = document.getElementById("exams");
    console.log(numbers);
    var maxQuantity = 60;

    numbers.addEventListener("input", function(e) {
        if(this.value>maxQuantity) {
            alert("The Exam score cannot be greater than 60. Try again.");
            this.value = maxQuantity;
        }
    })
};
window.onload = maxValueExam();
</script>
<?php
}
 }
 }

?>
