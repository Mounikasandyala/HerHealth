<?php
// Include database connection details
include('config.php');

// Get current date
$current_date = date('Y-m-d');

// Select alerts that need to be sent (alert_date is today or earlier and not yet sent)
$sql = "SELECT id, message, patient_id, nurse_id FROM alerts WHERE alert_date <= ? AND is_sent = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $current_date);
$stmt->execute();
$result = $stmt->get_result();

// Process each alert
while ($row = $result->fetch_assoc()) {
    // Example action: Send alert via email (replace with your actual alert mechanism)
    $message = "Alert: " . $row['message'];
    $patient_id = $row['patient_id'];
    $nurse_id = $row['nurse_id'];
    
    // Example: Send alert to patient or nurse via some communication method
    echo "Sending alert to Patient ID: $patient_id and Nurse ID: $nurse_id - Message: $message<br>";

    // Mark alert as sent (update is_sent flag)
    $update_sql = "UPDATE alerts SET is_sent = 1 WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $row['id']);
    $update_stmt->execute();
    $update_stmt->close();
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>
