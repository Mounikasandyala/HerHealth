<?php
include('C:\xampp\htdocs\HERHEALTH\config.php');

$nurse_id_err = $patient_id_err = $general_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $nurse_id = trim($_POST["nurse_id"]);
    $patient_id = trim($_POST["patient_id"]);
    $age = trim($_POST["age"]);
    $weight = trim($_POST["weight"]);
    $blood_group = trim($_POST["blood_group"]);
    $phone = trim($_POST["phone"]);
    $visit_date = trim($_POST["visit_date"]);
    $revisit_date = trim($_POST["revisit_date"]);
    //$reports = trim($_POST["reports"]);

    $date = date('Y-m-d', strtotime($visit_date));
    $re_date = date('Y-m-d', strtotime($revisit_date));

    // Check if the nurse ID exists
    $sql = "SELECT nurse_id FROM users WHERE nurse_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("d", $nurse_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $nurse_id_err = "Invalid nurse ID.";
    } else {
        // Check if the patient ID is already taken
        $sql = "SELECT patient_id FROM patients WHERE patient_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("d", $patient_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $patient_id_err = "This patient ID is already taken.";
        } else {
            // Insert the new patient data
            $sql = "INSERT INTO patients (name, nurse_id, patient_id, age, weight, blood_group, phone, visit_date, revisit_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sddddsdss", $name, $nurse_id, $patient_id, $age, $weight, $blood_group, $phone, $date, $re_date);

            if ($stmt->execute()) {
                header("location: added.html");
            } else {
                $general_err = "Something went wrong. Please try again later.";
            }
        }
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Her Health - Add Patient Details</title>
    <link rel="stylesheet" href="styles3.css">
</head>
<body background="https://static.vecteezy.com/system/resources/thumbnails/012/946/002/small_2x/banner-about-pregnancy-and-motherhood-with-place-for-text-pregnant-woman-future-mom-of-hugging-belly-with-arms-happy-mother-s-day-flat-illustration-vector.jpg">
    <div class="form-container">
        <h1>Patient Details</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter full name" required>
            </div>
            <div class="form-group">
                <label for="nurse_id">Nurse ID</label>
                <input type="number" id="nurse_id" name="nurse_id" placeholder="Enter nurse ID" required>
                <span class="error" style="color: red;"> <?php echo $nurse_id_err; ?></span>
            </div>
            <div class="form-group">
                <label for="patient_id">Patient ID</label>
                <input type="number" id="patient_id" name="patient_id" placeholder="Enter patient ID" required>
                <span class="error" style="color: red;"><?php echo $patient_id_err; ?></span>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" placeholder="Enter age" required>
            </div>
            <div class="form-group">
                <label for="weight">Weight</label>
                <input type="number" id="weight" name="weight" placeholder="Enter weight in kg" required>
            </div>
            <div class="form-group">
                <label for="blood_group">Blood Group</label>
                <input type="text" id="blood_group" name="blood_group" placeholder="Enter blood group" required>
            </div>
            <div class="form-group">
                <label for="aadhaar">Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="Enter your Phone number" required aria-required="true" aria-label="Phone Number">
            </div>
            <div class="form-group">
                <label for="visit_date">Visiting Hospital Date</label>
                <input type="date" id="visit_date" name="visit_date" required>
            </div>
            <div class="form-group">
                <label for="revisit_date">Re-visit Date</label>
                <input type="date" id="revisit_date" name="revisit_date" required>
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
            <button onclick="location.href='dashboard.html'">Dashboard</button>
        </form>
        <?php if (!empty($general_err)) echo "<div class='error'>$general_err</div>"; ?>
    </div>
</body>
</html>
