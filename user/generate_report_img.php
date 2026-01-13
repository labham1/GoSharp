<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("../config/db.php");

if(!isset($_SESSION['uid'])){
  exit;
}

$uid = $_SESSION['uid'];

$total = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT COUNT(*) c FROM posts WHERE user_id='$uid'")
)['c'];

$verified = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT COUNT(*) c FROM posts WHERE user_id='$uid' AND status='verified'")
)['c'];

$width = 800;
$height = 500;
$image = imagecreate($width, $height);

$white = imagecolorallocate($image, 255,255,255);
$black = imagecolorallocate($image, 0,0,0);
$green = imagecolorallocate($image, 0,128,0);

imagestring($image, 5, 240, 40, "GoSharpener Impact Report Card", $green);

imagestring($image, 4, 120, 150, "Total Posts:", $black);
imagestring($image, 4, 350, 150, $total, $black);

imagestring($image, 4, 120, 200, "Verified Posts:", $black);
imagestring($image, 4, 350, 200, $verified, $black);

imagestring($image, 3, 120, 280, "Generated on: ".date("d M Y"), $black);

header("Content-Type: image/png");
imagepng($image);
imagedestroy($image);
