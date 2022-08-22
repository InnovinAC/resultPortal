<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['alogin'])=="" || $_SESSION['alogin']!='innovin')
    {   
    header("Location: admin.php"); 
    }
    else {
       $_GET['action']="bypass";
       
       if(isset($_POST['submit'])) {
          
          $name=$_POST['name'];
          $location=$_POST['location'];
          $disable=$_POST['disable'];
          $domain=$_POST['domain'];
          
          $query=$dbh->prepare("update tblsettings set Value='$name' where SettingName='siteName'");
          $query1=$dbh->prepare("update tblsettings set Value='$location' where SettingName='location'");
          $query2=$dbh->prepare("update tblsettings set Value='$disable' where SettingName='siteDisabled'");
          $query3=$dbh->prepare("update tblsettings set Value='$domain' where SettingName='domainName'");
          $query->execute(); 
          $query1->execute();
          $query2->execute();
          $query3->execute();
          if($query->execute() && $query1->execute() && $query2->execute() && $query3->execute()) {
             $msg="Settings changed successfully";
             }
             else {
                $error="An error occurred"; }
                } ?>
          
         <!Doctype HTML>
          <html lang="en">
             <head>
                   <title>Admin |  Change Settings</title>
 <?php include('includes/header.php');?>  
     
    </head>
    <body>
      <?php include('includes/leftbar.php');?>  

  <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fal fa-home"></i> Dashboard</a></li>
                                
                                        <li class="breadcrumb-item active"><a href="other-settings.php">Other Settings</a></li>
                                    </ul>
                     <div class="container-fluid">
                   <h2 class="h2 title"><i class="far fa-cog"></i> Change Settings</h2>
                               
                                </div>
                        <div class="container-fluid">
                                        <div class="card">
                                            <div class="card-body">
                                               <?php if(isSiteDisabled()==1) { ?>
                                                  <div class="alert alert-danger"> This site is currently disabled</div> <?php } ?>
                                               <?php if($msg) { ?>
                                                  <div class="alert alert-success"><i class=" far fa-check-circle"></i> Good job! <?php echo $msg; ?></div> <?php } else if($error) { ?>
                                                       <div class="alert alert-danger"><i class=" far fa-times-circle"></i> Sorry! <?php echo $error; ?></div> <?php } ?>
                                                     
                                               <form method="post" class="form-horizontal">
                                                             <div class=" form-group">
                                                 <label class="control-label">School Name</label>
                                                 <input type="text" value="<?php echo getSiteName(); ?>" class="form-control" name="name">
                                                    </div>
                                               
                                               <div class="form-group">
                                               <label class="control-label">Disable Site</label>
                                               <select class="form-control" name="disable">
                                                  <option value="0" <?php if(isSiteDisabled()==0) { echo "selected"; }?>>No</option>
                                                  <option value="1" <?php if(isSiteDisabled()==1) { echo "selected"; }?>>Yes</option>
                                              </select> 
                                              </div>
                                              
                                              <div class=" form-group">
                                                 <label class="control-label">School Location</label>
                                                 <input type="text" value="<?php echo getLocation(); ?>" class="form-control" name="location">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                       <label class="control-label">Domain Name</label>
                                                                   <input type="text" value="<?php echo getDomainName(); ?>" class="form-control" name="domain">
                                             </div>
                                              
                                              <div class="form-group">
                                                 <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                              
                                              </div>
                                              </form>
                                              </div>
                                              </div>
                                              </div>
                                              </body>
                                              <?php include("includes/scripts.php"); include("includes/footer.php"); ?>
                                              
                     </html>
    <?php } ?>