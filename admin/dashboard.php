<?php
session_start();
include("../includes/header.php");
if(!isset($_SESSION['uid']) || $_SESSION['role'] != 'admin'){
  header("Location: ../auth/login.php");
  exit;
}
include("../config/db.php"); ?>
<h2>Admin Dashboard</h2>
<a href="verify_post.php">Verify Posts</a>
<a href="tag_analytics.php">Tag Analytics</a>
<?php include("../includes/footer.php"); ?>
