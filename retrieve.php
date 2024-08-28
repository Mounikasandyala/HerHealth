<?php
include('C:\xampp\htdocs\HERHEALTH\config.php');
$result=mysqli_query($conn,"select * from patients");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Retrive data</title>
        <link rel="stylesheet" href="retrieveStyle.css">
    </head>
    <body>
        <?php
        if(mysqli_num_rows($result)>0)
        {
        ?>
        <table>
            <tr>
                <th>NAME</th>
                <th>NURSE ID</th>
                <th>PATIENT ID</th>
                <th>AGE</th>
                <th>WEIGHT</th>
                <th>BLOOD GROUP</th>
                <th>PHONE NUMBER</th>
                <th>VISIT DATE</th>
                <th>REVISIT DATE</th>
                <th>ACTION</th>
            </tr>
            <?php
            $i=0;
            while($row=mysqli_fetch_array($result))
            {
            ?>
            <tr>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["nurse_id"]; ?></td>
                <td><?php echo $row["patient_id"]; ?></td>
                <td><?php echo $row["age"]; ?></td>
                <td><?php echo $row["weight"]; ?></td>
                <td><?php echo $row["blood_group"]; ?></td>
                <td><?php echo $row["phone"]; ?></td>
                <td><?php echo $row["visit_date"]; ?></td>
                <td><?php echo $row["revisit_date"]; ?></td>
                <td><a href="update.php?patient_id=<?php echo $row["patient_id"]; ?>">Update</a></td>
            </tr>
            <?php
            $i++;
            }
            ?>
        </table>
        <button onclick="location.href='dashboard.html'">Dashboard</button>
        <button onclick="location.href='home.html'">Home</button>
        <?php
        }
        else
        {
            echo "0 results found";
        }
        ?>
    </body>
</html>