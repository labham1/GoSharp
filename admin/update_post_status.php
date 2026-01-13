<?php
session_start();
if (!isset($_SESSION['uid']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include("../config/db.php");

$postId = intval($_POST['post_id']);
$tagId  = intval($_POST['tag_id']);
$action = $_POST['action']; // verified | rejected

$status = ($action === 'verified') ? 'verified' : 'rejected';

mysqli_query($conn, "
  UPDATE posts
  SET tag_id='$tagId', status='$status'
  WHERE id='$postId'
");

/* ABSOLUTE PATH REDIRECT — FIXES 404 */
header("Location: verify_post.php?msg=$status");
exit;

