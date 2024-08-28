<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $birth_date = htmlspecialchars(trim($_POST['birth_date']));  // Changed variable name to match HTML form
    $conditions = htmlspecialchars(trim($_POST['conditions']));
    $password = htmlspecialchars(trim($_POST['password']));
    $terms = isset($_POST['terms']);

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($birth_date) || empty($password) || !$terms) {
        die("Please fill out all required fields and agree to the terms.");
    }

    // Validate password length and special characters
    $passwordRegex = '/^(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$/';
    if (!preg_match($passwordRegex, $password)) {
        die("Password must be at least 8 characters long and include at least one special character.");
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
    $stmt = $conn->prepare("INSERT INTO users(name, email, phone, birth_date, conditions, password) VALUES (?, ?, ?, ?, ?, ?)");  // Changed column name to birth_date
    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error);
    }
    $stmt->bind_param("ssssss", $name, $email, $phone, $birth_date, $conditions, $hashed_password);  // Changed variable name to match HTML form

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}
?>
