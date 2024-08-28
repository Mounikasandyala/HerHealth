<?php
include('C:\xampp\htdocs\HERHEALTH\config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $nurse_id = trim($_POST["id"]);
    $aadhaar = trim($_POST["aadhaar"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
    } else {
        $sql = "SELECT nurse_id FROM users WHERE nurse_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("d", $nurse_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $error_message = "This Nurse ID is already taken.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name,nurse_id, aadhaar,phone,address,password) VALUES (?, ?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdddss", $name,$nurse_id,$aadhaar,$phone,$address, $password);

            if ($stmt->execute()) {
                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        $stmt->close();
    }
}
#$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Her Health - Registration</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <main class="registration-container">
    <body>
    <div class="all-content">
        <!-- navbar start -->
        <nav class="navbar navbar-expand-lg" id="navbar">
            <div class="container-fluid">
              <a class="navbar-brand" href="#" id="logo"><img src="https://www.godaddy.com/resources/ae/wp-content/uploads/Her-Health-First-logo-300x229.png" alt="Her Health Logo"></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span><i class="fa-solid fa-bars" style="color: white; font-size: 23px;"></i></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="about.html">About US</a>
                  </li> 
                  <li class="nav-item">
                    <a class="nav-link" href="our work.html">Our Work</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="blog.html">Blogs</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                  </li>
                 
                </ul>
              </div>
            </div>
          </nav>
        <h1>Her Health</h1>
        <p>Welcome to Her Health.</p>
        <?php if (!empty($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required aria-required="true" aria-label="Full Name">
            </div>
            <div class="form-group">
                <label for="id">Nurse ID</label>
                <input type="text" id="id" name="id" placeholder="Enter your ID" required aria-required="true" aria-label="ID">
            </div>
            <div class="form-group">
                <label for="aadhaar">Aadhaar Number</label>
                <input type="text" id="aadhaar" name="aadhaar" placeholder="Enter your Aadhaar number" required aria-required="true" aria-label="Aadhaar Number">
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required aria-required="true" autocomplete="tel" aria-label="Phone Number">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" placeholder="Enter your address" required aria-required="true" aria-label="Address">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password" required aria-required="true" autocomplete="new-password" aria-label="Password">
            </div>
            <div class="form-group">
                <label for="password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required aria-required="true" autocomplete="new-password" aria-label="Password">
            </div>
            
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
            <div class="button-group">
        <button onclick="location.href='home.html'">Back</button>
        </div>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </main>
</body>
</html>
