<?php
// Start session to access logged-in user data
session_start();

// Check if user is NOT logged in OR role is not 'user'
if(!isset($_SESSION['uid']) || $_SESSION['role'] !== 'user'){
  // Redirect unauthorized users to login page
  header("Location: ../auth/login.php");
  exit;
}

// Include database connection
include("../config/db.php");

// Include common header (navbar, styles, etc.)
include("../includes/header.php");

/* ✅ STORE LOGGED-IN USER ID */
$userId = $_SESSION['uid'];

// Fetch verified posts created by this user
$q = mysqli_query($conn, "
  SELECT posts.*, tags.tag_name
  FROM posts
  JOIN tags ON posts.tag_id = tags.id
  WHERE posts.status = 'verified'
    AND posts.user_id = '$userId'
  ORDER BY posts.created_at DESC
");
?>

<h2>Verified Impact Feed</h2>

<!-- Show message if no verified posts exist -->
<?php if(mysqli_num_rows($q) == 0): ?>
  <div class="card">
    <p>No verified posts yet.</p>
  </div>
<?php endif; ?>

<!-- Loop through each verified post -->
<?php while($post = mysqli_fetch_assoc($q)): ?>
  <div class="card">

    <!-- MEDIA SECTION (Image or Video) -->
    <?php
      // Get media type (image/video), default is image
      $mediaType = $post['media_type'] ?? 'image';
    ?>

    <!-- If media is an image -->
    <?php if($mediaType === 'image'): ?>
      <img src="../uploads/<?= htmlspecialchars($post['media']) ?>"
           style="width:50%;border-radius:6px">

    <!-- If media is a video -->
    <?php else: ?>
      <video controls style="width:50%;border-radius:6px">
        <source src="../uploads/<?= htmlspecialchars($post['media']) ?>">
      </video>
    <?php endif; ?>

    <!-- POST DETAILS -->
    <!-- Display post comment safely -->
    <p><?= htmlspecialchars($post['comment']) ?></p>

    <!-- Display formatted date and time -->
    <small>
      Posted on <?= date("d M Y, h:i A", strtotime($post['created_at'])) ?>
    </small>

  </div>
<?php endwhile; ?>

<!-- Include common footer -->
<?php include("../includes/footer.php"); ?>
