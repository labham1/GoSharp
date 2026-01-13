<?php
// Start a session so we can store user data (like user id, role)
session_start();

// Include database connection file
include("../config/db.php");

// Check if the login form is submitted
if(isset($_POST['login'])){

  // Get email from form and remove extra spaces
  $email = trim($_POST['email']);

  // Get password from form
  $password = $_POST['password'];

  // Fetch user data from database using the email
  $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

  // Convert query result into an associative array
  $user = mysqli_fetch_assoc($q);

  // Check if user exists AND password matches the hashed password in DB
  if($user && password_verify($password, $user['password'])){

    // Store user id in session
    $_SESSION['uid'] = $user['id'];

    // Store user role (admin or user) in session
    $_SESSION['role'] = $user['role'];

    // Redirect based on user role
    if($user['role'] === 'admin'){
      header("Location: ../admin/dashboard.php");
    } else {
      header("Location: ../user/dashboard.php");
    }

    // Stop further script execution after redirect
    exit;

  } else {
    // If login fails, show error message
    $error = "Invalid email or password";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login | GoSharpener</title>

  <!-- External CSS file for login page styling -->
  <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<div class="auth-container">
  <h2>GoSharpener Login</h2>

  <!-- Show error message if login fails -->
  <?php if(isset($error)): ?>
    <div class="error"><?= $error ?></div>
  <?php endif; ?>

  <!-- Show success message after registration -->
  <?php if(isset($_GET['registered'])): ?>
    <div class="success">Registration successful. Please login.</div>
  <?php endif; ?>

  <!-- Login form -->
  <form method="post">

    <!-- Email input -->
    <input type="email" name="email" placeholder="Email address" required>

    <!-- Password input -->
    <input type="password" name="password" placeholder="Password" required>

    <!-- Submit button -->
    <button type="submit" name="login">Login</button>
  </form>

  <!-- Registration link -->
  <p>Don't have an account?
    <a href="register.php">Register here</a>
  </p>
</div>

</body>
</html>
