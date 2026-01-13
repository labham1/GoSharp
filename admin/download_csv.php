<?php
include("../config/db.php");
header("Content-Disposition: attachment; filename=tag_report.csv");
echo "Tag,Verified,Pending\n";
$q=mysqli_query($conn,"SELECT tags.tag_name,
SUM(status='verified') v, SUM(status='pending') p
FROM posts JOIN tags ON posts.tag_id=tags.id GROUP BY tags.id");
while($r=mysqli_fetch_assoc($q)){
 echo "{$r['tag_name']},{$r['v']},{$r['p']}\n";
}
?>