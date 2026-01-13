<?php
session_start();
if (!isset($_SESSION['uid']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

include("../includes/header.php");
include("../config/db.php");
?>

<div class="card upload-card">

  <h2>Upload Impact Post</h2>

  <!-- SUCCESS MESSAGE -->
  <?php if (isset($_GET['success'])): ?>
    <p class="success-msg">
      ✅ Your post has been submitted and is pending admin verification.
    </p>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" action="save_post.php">

    <label>Upload Image / Video</label>
    <input type="file" name="media" required>

    <label>Select Category</label>
    <select name="tag_id" required>
      <option value="">-- Select Tag --</option>
      <?php
      $t = mysqli_query($conn, "SELECT * FROM tags");
      while ($r = mysqli_fetch_assoc($t)) {
        echo "<option value='{$r['id']}'>" . htmlspecialchars($r['tag_name']) . "</option>";
      }
      ?>
    </select>

    <label>Description</label>
    <textarea 
      name="comment" 
      placeholder="Describe your impact..." 
      rows="4"
      required></textarea>

    <button type="submit">Submit Post</button>

  </form>

</div>

<?php include("../includes/footer.php"); ?>
