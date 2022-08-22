<nav class="navbar navbar-expand-lg navbar-dark bg-navy">
<div class="container-fluid">
  <a class="navbar-brand" href="dashboard.php">School Portal</a>
  <span class="toggler">
    <span id="toggler-icon" class="fal navbar-toggler fa-bars fa-2x text-white" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"></span>
  </span>
  <div class="collapse text-white navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li style="font-size:13px" class="nav-item">
        <a class="nav-link active" aria-current="page" href="dashboard.php">
          <span class="fal fa-home"></span> Dashboard </a>
      </li> <?php if($_SESSION['role']==1) { ?>
	  <li style="font-size:13px" class="nav-item dropdown">
        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fal fa-graduation-cap"></i> Sessions </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="create-session.php">
            <i class="fal fa-download"></i> Create Academic Session </a></li>
			<li><hr class="dropdown-divider"></li>
         <li> <a class="dropdown-item" href="manage-sessions.php">
            <i class="fal fa-graduation-cap"></i> Manage Sessions </a></li>
        </ul>
      </li> <?php } ?> <li class="nav-item dropdown" style="font-size:12px">
        <a class="active nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fal fa-book-open"></i> Subjects </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown"> <?php if($_SESSION['role']==1) { ?> <li><a class="dropdown-item" href="create-subject.php">
            <i class="fal fa-book"></i> Create Subject </a></li>
			<li><hr class="dropdown-divider"></li><?php } ?> <li><a class="dropdown-item" href="manage-subjects.php">
            <i class="fal fa-books"></i> Manage Subjects </a></li>
			<li><hr class="dropdown-divider"></li>
         <li><a class="dropdown-item" href="add-subjectcombination.php">
            <i class="fal fa-chalkboard"></i> Add Subject Combination </a></li>
			<li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="manage-subjectcombination.php">
            <i class="fal fa-server"></i> Manage Subject Combinations </a></li>
        </ul>
      </li>
      <li class="nav-item dropdown" style="font-size:13px">
        <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fal fa-user-graduate"></i> Students </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="add-students.php">
            <i class="fal fa-user"></i> Add Students </a></l>
			<li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="manage-students.php">
            <i class="fal fa-users"></i> Manage Students </a></li>
        </ul>
      </li>
      <li class="nav-item dropdown" style="font-size:13px">
        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fal fa-newspaper"></i> Results </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="add-result.php">
            <i class="fal fa-archive"></i> Add Results </a></li>
			<li><hr class="dropdown-divider"></li>
         <li> <a class="dropdown-item" href="manage-results.php">
            <i class="fal fa-server"></i> Manage Results </a></li>
        </ul>
      </li>
      <li class="nav-item dropdown" style="font-size:13px">
        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fal fa-wrench"></i> Tools </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="change-password.php">
            <i class="fal fa-lock"></i> Change Password </a></li> <?php if($_SESSION['role']==1) { ?><li><hr class="dropdown-divider"></li>
<li><a class="dropdown-item" href="settings.php">
            <i class="fal fa-cog"></i> Change Settings </a></li>
			<li><hr class="dropdown-divider"></li>
         <li><a class="dropdown-item" href="create-user.php">
            <i class="fal fa-user-cog"></i> Create Teacher </a></li>
			<li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="manage-users.php">
            <i class="fal fa-users-cog"></i> Manage Teachers </a></li>
			<li><hr class="dropdown-divider"></li>
			<li><a class="dropdown-item" href="create-pin.php">
            <i class="fal fa-plus-circle"></i> Create Pin </a></li>
			<li><hr class="dropdown-divider"></li>
			<li><a class="dropdown-item" href="manage-pins.php">
            <i class="fal fa-shield-check"></i> Manage Pins </a></li>
			<li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="mass-promote.php">
            <i class="fal fa-share"></i> Mass Promote Students </a></li>

		<?php } ?>
        </ul>
      </li>
      <li class="nav-item active" style="font-size:13px">
        <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')" class="nav-link text-white active">
          <i class="fal fa-sign-out"></i> Sign Out </a>
      </li>
    </ul>
  </div>
</nav>
<noscript>
  <br>
  <div class="container">
    <div class="alert alert-danger" role="alert">
      <b>
        <i class="fal fa-info-circle"></i> Please enable JavaScript on your browser to avoid issues while using this software. </b>
    </div>
  </div>
</noscript>
