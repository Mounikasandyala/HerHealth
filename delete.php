<?php
include('C:\xampp\htdocs\HERHEALTH\config.php');

// Check if patient_id is provided in the URL
if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];

    // Prepare the DELETE statement
    $sql = "DELETE FROM patients WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id); // Assuming patient_id is an integer, adjust "i" if it's a different type

    // Execute the statement
    if ($stmt->execute()) {
        header("location: deleted.html");
        exit(); // Always exit after redirection
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close(); // Close statement
} else {
    echo "No patient_id provided!";
}

$conn->close(); // Close database connection
?>
