<?php 
session_start();
if (!isset($_SESSION['uid']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include("../includes/header.php");
include("../config/db.php");

$q = mysqli_query($conn, "
  SELECT 
    tags.tag_name,
    SUM(posts.status = 'verified') AS verified_count,
    SUM(posts.status = 'pending')  AS pending_count
  FROM posts
  JOIN tags ON posts.tag_id = tags.id
  GROUP BY tags.id
");
?>

<h2 class="admin-title">Tag Analytics</h2>

<div class="table-wrapper">

<table class="analytics-table">
  <thead>
    <tr>
      <th>Tag</th>
      <th>Verified Posts</th>
      <th>Pending Posts</th>
    </tr>
  </thead>
  <tbody>

  <?php if (mysqli_num_rows($q) == 0): ?>
    <tr>
      <td colspan="3" class="no-data">No data available</td>
    </tr>
  <?php endif; ?>

  <?php while ($r = mysqli_fetch_assoc($q)): ?>
    <tr>
      <td><?= htmlspecialchars($r['tag_name']) ?></td>
      <td class="verified"><?= $r['verified_count'] ?></td>
      <td class="pending"><?= $r['pending_count'] ?></td>
    </tr>
  <?php endwhile; ?>

  </tbody>
</table>

<a href="download_csv.php" class="btn-download">Download CSV</a>

</div>

<?php include("../includes/footer.php"); ?>
