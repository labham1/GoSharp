<?php
include("config/db.php");
$pass = password_hash("admin123", PASSWORD_DEFAULT);

mysqli_query($conn,
 "INSERT INTO users(name,email,password,role)
  VALUES('Admin','admin@gosharpener.com','$pass','admin')"
);

echo "Admin created";
