<?php
include("config/db.php");
$pass = password_hash("pass", PASSWORD_DEFAULT);

mysqli_query($conn,
 "INSERT INTO users(name,email,password,role)
  VALUES('Admin','email','$pass','admin')"
);

echo "Admin created";
