<?php
include("../config/db.php");

if(isset($_POST['register'])){
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $check = mysqli_query($conn,"SELECT id FROM users WHERE email='$email'");
  if(mysqli_num_rows($check) > 0){
    $error = "Email already registered";
  } else {
    mysqli_query($conn,
      "INSERT INTO users(name,email,password,role)
       VALUES('$name','$email','$password','user')"
    );
    header("Location: login.php?registered=1");
    exit;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register | GoSharpener</title>
  <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<div class="auth-container">
  <h2>Create Account</h2>

  <?php if(isset($error)): ?>
    <div class="error"><?= $error ?></div>
  <?php endif; ?>

  <form method="post">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email address" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="register">Register</button>
  </form>

  <p>Already have an account?
    <a href="login.php">Login here</a>
  </p>
</div>

</body>
</html>
