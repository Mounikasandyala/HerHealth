<?php
include('C:\xampp\htdocs\HERHEALTH\config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nurse_id = trim($_POST["id"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT nurse_id FROM users WHERE nurse_id = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nurse_id, $password);  // Corrected bind_param to use "ss" for both string types
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $_SESSION["loggedin"] = true;
        $_SESSION["nurse_id"] = $nurse_id;
        header("location:home.html");
    } else {
        $error_message = "Invalid ID or password.";  // Use a variable to store error message
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Her Health Login</title>
    <link rel="stylesheet" href="style2.css"> 
</head>
<body>
    <div class="login-container">
        <h1>Login to Her Health</h1>
        <?php if (!empty($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="id">ID</label>
                <input type="text" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
            <div class="button-group">
                <button type="button" onclick="location.href='register.php'">Back</button>
            </div>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>
