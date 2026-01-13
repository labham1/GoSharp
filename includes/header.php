<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>GoSharpener</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<nav class="navbar">
  <div class="logo">GoSharpener</div>

  <ul class="nav-links">
    <?php if($_SESSION['role'] === 'user'): ?>
      <li><a href="../user/dashboard.php">Dashboard</a></li>
      <li><a href="../user/upload_post.php">Upload</a></li>
      <li><a href="../user/report_card.php">Report Card</a></li>
    <?php endif; ?>

    <?php if($_SESSION['role'] === 'admin'): ?>
      <li><a href="../admin/dashboard.php">Dashboard</a></li>
      <li><a href="../admin/verify_post.php">Verify Posts</a></li>
      <li><a href="../admin/tag_analytics.php">Analytics</a></li>
    <?php endif; ?>

    <li><a href="../auth/logout.php" class="logout">Logout</a></li>
  </ul>
</nav>

<div class="container">
