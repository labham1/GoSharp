<?php
session_start();
include("../config/db.php");

$user_id = $_SESSION['uid'];
$tag_id = $_POST['tag_id'];
$comment = $_POST['comment'];

$file = $_FILES['media'];

$originalName = pathinfo($file['name'], PATHINFO_FILENAME);
$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

$cleanName = preg_replace("/[^a-zA-Z0-9]/", "_", $originalName);
$filename = time() . "_" . $cleanName . "." . $extension;

/* absolute upload directory */
$uploadDir = __DIR__ . "/../uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
    die("File upload failed");
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

$media_type = in_array($ext, ['mp4','avi','mov']) ? 'video' : 'image';


mysqli_query($conn,"
  INSERT INTO posts
  (user_id, media, media_type, tag_id, comment, status, created_at)
  VALUES
  ('$user_id','$filename','$media_type','$tag_id','$comment','pending',NOW())
");

header("Location: upload_post.php?success=1");
exit;
