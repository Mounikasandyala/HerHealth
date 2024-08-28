<?php
include('C:\xampp\htdocs\HERHEALTH\config.php');

if(count($_POST) > 0) {
    if (isset($_POST['patient_id']) && !empty($_POST['patient_id'])) {
        $patient_id = $_POST['patient_id'];

        // Using prepared statements to prevent SQL injection
        $stmt = $conn->prepare("UPDATE patients SET name=?, nurse_id=?, age=?, weight=?, blood_group=?,phone=?, visit_date=?, revisit_date=? WHERE patient_id=?");
        $stmt->bind_param("sdddsdssd", $_POST['name'], $_POST['nurse_id'], $_POST['age'], $_POST['weight'], $_POST['blood_group'],$_POST['phone'], $_POST['visit_date'], $_POST['revisit_date'], $patient_id);
        
        if($stmt->execute()) {
            header("location: updated.php");
            $message = "<p style='color:green;'>Patient record Updated Successfully  !</p>";
        } else {
            $message = "<p style='color:red;'>Error updating patient record: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        $message = "<p style='color:red;'>Invalid patient ID!</p>";
    }
}

$patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : '';
$row = null;
if (!empty($patient_id)) {
    $result = $conn->query("SELECT * FROM patients WHERE patient_id='" . $conn->real_escape_string($patient_id) . "'");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $message = "<p style='color:red;'>Patient not found!</p>";
    }
}
?>
<html>
<head>
    <title>Update Patients Data</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<main class="registration-container">
    <form name="frmUser" method="post" action="">
        <div>
            <?php if(isset($message)) {
                echo $message;
            } ?>
        </div>
        <div style="padding-bottom: 5px;">
            <a href="retrieve.php">Patients List</a>
        </div>
        <?php if ($row) { ?>
            <input type="hidden" name="patient_id" class="txtField" value="<?php echo htmlspecialchars($row['patient_id']); ?>">
            <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="txtField" value="<?php echo htmlspecialchars($row['name']); ?>"><br>
            </div>
            <div class="form-group">
            <label for="nurse_id">Nurse Id</label>
            <input type="text" name="nurse_id" class="txtField" value="<?php echo htmlspecialchars($row['nurse_id']); ?>"><br>
            </div>
            <div class="form-group">
            <label for="age">Age</label>
            <input type="text" name="age" class="txtField" value="<?php echo htmlspecialchars($row['age']); ?>"><br>
            </div>
            <div class="form-group">
            <label for="weight">Weight</label>
            <input type="text" name="weight" class="txtField" value="<?php echo htmlspecialchars($row['weight']); ?>"><br>
            </div>
            <div class="form-group">
            <label for="blood_group">Blood Group</label>
            <input type="text" name="blood_group" class="txtField" value="<?php echo htmlspecialchars($row['blood_group']); ?>"><br>
            </div>
            <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" name="phone" class="txtField" value="<?php echo htmlspecialchars($row['phone']); ?>"><br>
            </div>
            <div class="form-group">
            <label for="visit_date">Visit Date</label>
            <input type="text" name="visit_date" class="txtField" value="<?php echo htmlspecialchars($row['visit_date']); ?>"><br>
            </div>
            <div class="form-group">
            <label for="revisit_date">Revisit Date</label>
            <input type="text" name="revisit_date" class="txtField" value="<?php echo htmlspecialchars($row['revisit_date']); ?>"><br>
            </div>
            <br>
            <div class="form-group">
            <input type="submit" name="submit" value="Submit" class="button" ><br>
            </div>
            <a href="dashboard.html">Dashboard</a>
        <?php } else { ?>
            <p>No patient data to display.</p>
            <a href="dashboard.html">Dashboard</a>
        <?php } ?>
    </form>
</main>
</body>
</html>

<?php

?>
