<?php 
include('header.php');
if(isset($_SESSION['ROLE']) && $_SESSION['ROLE']!='1'){
	header('location:news.php');
	die();
}
?>
<div class="container-fluid">
<ol class="breadcrumb">
  <li class="breadcrumb-item">
	 <a href="">Dashboard</a>
  </li>
</ol>
<!-- Page Content -->
<h1>Admin Dashboard</h1>
<hr>
<p>As an admin of the Yorkshire & Humber Regional Organised Crime Unit, you play a crucial role in ensuring the safety and security of our communities. </p>
<p>Your dedication and hard work are greatly appreciated. This blank page serves as a starting point for creating new custom pages to support our mission.</p>
</div>
<?php include('footer.php')?>