<?php
include('C:\xampp\htdocs\HERHEALTH\config.php');

$sql = "SELECT u.name as nurse_name, u.phone as nurse_phone, p.name as patient_name, p.phone as patient_phone, p.visit_date 
        FROM patients p 
        JOIN users u ON p.nurse_id = u.nurse_id 
        WHERE p.revisit_date = CURDATE()";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $nurse_name = $row['nurse_name'];
        $nurse_phone = $row['nurse_phone'];
        $patient_name = $row['patient_name'];
        $patient_phone = $row['patient_phone'];
        $visit_date = $row['visit_date'];

        $message = "Reminder: Patient $patient_name has a scheduled visit today ($visit_date).";
        
        mail($nurse_phone."@smsgateway.com", "Visit Reminder", $message);
        mail($patient_phone."@smsgateway.com", "Visit Reminder", $message);
    }
}

$conn->close();
?>
