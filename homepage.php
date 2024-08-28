<?php
session_start();
require_once('C:\xampp\htdocs\herhealth\config.php');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Logout logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="main-wrapper">
        <center><h2>Home Page</h2></center>
        <center><h3>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></h3></center>
        
        <form action="" method="post">
            <div class="imgcontainer">
                <img src="imgs/avatar.png" alt="Avatar" class="avatar">
            </div>
            <div class="inner_container">
                <button class="logout_button" type="submit" name="logout">Log Out</button>    
            </div>
        </form>
    </div>
</body>
</html>
