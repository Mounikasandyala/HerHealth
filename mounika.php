<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $due_date = htmlspecialchars(trim($_POST['due_date']));
    $conditions = htmlspecialchars(trim($_POST['conditions']));
    $password = htmlspecialchars(trim($_POST['password']));
    $terms = isset($_POST['terms']);

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($due_date) || empty($password) || !$terms) {
        die("Please fill out all required fields and agree to the terms.");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection (update with your own connection details)
    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "her";

    $conn = new mysqli($servername, $username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        $conn->close();
        die("This email is already registered. Please use a different email.");
    }
    $stmt->close();

    // Prepare and bind the insert statement
    $stmt = $conn->prepare("INSERT INTO users(name, email, phone, due_date, conditions, password) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error);
    }
    $stmt->bind_param("ssssss", $name, $email, $phone, $due_date, $conditions, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Her Health - Registration</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="registration-container">
        <h1>Her Health </h1>
        <p>Welcome to Her Health.</p>
        <form action="connect.php" method="post">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="due-date">Due Date</label>
                <input type="date" id="due-date" name="due_date" required>
            </div>
            <div class="form-group">
                <label for="conditions">Any Specific Conditions</label>
                <textarea id="conditions" name="conditions" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">I agree to the <a href="#">terms and conditions</a></label>
            </div>
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
        </form>
        <p>login here? <a href="login.html">login form</a>.</p>
    </div>
</body>
</html>

