<?php
session_start();
if (!isset($_SESSION['uid']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include("../config/db.php");
include("../includes/header.php");

/* TAG LIST */
$tags = mysqli_query($conn, "SELECT * FROM tags");

/* PENDING POSTS */
$pending = mysqli_query($conn, "
  SELECT posts.*, tags.tag_name, users.name AS username
  FROM posts
  JOIN tags ON posts.tag_id = tags.id
  JOIN users ON posts.user_id = users.id
  WHERE posts.status = 'pending'
  ORDER BY posts.created_at DESC
");

/* REJECTED POSTS */
$rejected = mysqli_query($conn, "
  SELECT posts.*, tags.tag_name
  FROM posts
  JOIN tags ON posts.tag_id = tags.id
  WHERE posts.status = 'rejected'
  ORDER BY posts.created_at DESC
");
?>

<!-- SUCCESS MESSAGE -->
<?php if (isset($_GET['msg'])): ?>
  <p class="admin-msg">
    Post <?= $_GET['msg'] === 'verified' ? 'approved' : 'rejected' ?> successfully.
  </p>
<?php endif; ?>

<h2>Pending Posts</h2>

<?php if (mysqli_num_rows($pending) == 0): ?>
  <p>No pending posts.</p>
<?php endif; ?>

<?php while ($post = mysqli_fetch_assoc($pending)): ?>
<div class="card admin-card">

  <p class="posted-by">
    Posted by: <?= htmlspecialchars($post['username']) ?>
  </p>

  <!-- MEDIA -->
  <?php if ($post['media_type'] === 'image'): ?>
    <img src="../uploads/<?= urlencode($post['media']) ?>" class="admin-media">
  <?php else: ?>
    <video controls class="admin-media">
      <source src="../uploads/<?= urlencode($post['media']) ?>">
    </video>
  <?php endif; ?>

  <p><?= htmlspecialchars($post['comment']) ?></p>

  <!-- TAG CHANGE + ACTION -->
  <form method="post" action="update_post_status.php">
    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">

    <label>Change Tag</label>
    <select name="tag_id">
      <?php
      mysqli_data_seek($tags, 0);
      while ($t = mysqli_fetch_assoc($tags)):
      ?>
        <option value="<?= $t['id'] ?>"
          <?= $t['id'] == $post['tag_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($t['tag_name']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <div class="admin-actions">
      <button type="submit" name="action" value="verified" class="btn-approve">
        Approve
      </button>

      <button type="submit" name="action" value="rejected" class="btn-reject">
        Reject
      </button>
    </div>
  </form>

</div>
<?php endwhile; ?>

<hr>

<h2>Rejected Posts</h2>

<?php if (mysqli_num_rows($rejected) == 0): ?>
  <p>No rejected posts.</p>
<?php endif; ?>

<?php while ($post = mysqli_fetch_assoc($rejected)): ?>
<div class="card rejected-card">
  <p><strong>Tag:</strong> <?= htmlspecialchars($post['tag_name']) ?></p>
  <p><?= htmlspecialchars($post['comment']) ?></p>
  <small>
    Rejected on <?= date("d M Y, h:i A", strtotime($post['created_at'])) ?>
  </small>
</div>
<?php endwhile; ?>

<?php include("../includes/footer.php"); ?>
