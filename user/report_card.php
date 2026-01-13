<?php
session_start();
include("../config/db.php");
include("../includes/header.php");

$uid = $_SESSION['uid'];

$total = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT COUNT(*) c FROM posts WHERE user_id='$uid'")
)['c'];

$verified = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT COUNT(*) c FROM posts WHERE user_id='$uid' AND status='verified'")
)['c'];

$pending = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT COUNT(*) c FROM posts WHERE user_id='$uid' AND status='pending'")
)['c'];

$rejected = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT COUNT(*) c FROM posts WHERE user_id='$uid' AND status='rejected'")
)['c'];
?>

<div class="card">
  <h2>My Impact Report Card</h2>

  <p>Total Posts: <strong><?= $total ?></strong></p>
  <p>Verified Posts: <strong><?= $verified ?></strong></p>
  <p>Pending Posts: <strong><?= $pending ?></strong></p>
  <p>Rejected Posts: <strong><?= $rejected ?></strong></p>

  <br>
  <a href="download_report_pdf.php">
    <button>Download Report PDF</button>
  </a>
</div>

<?php include("../includes/footer.php"); ?>
