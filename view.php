
<!DOCTYPE html>
<html>
    <head>
        <title>View</title>
        <style> 
        table
        {
            border-collapse: collapse; 
            width: 100%;
            color: #007bff;
            font-family: monospace;
            font-size: 25px;
            text-align: left;
        }
        th
        {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even)
        {
            background-color: aliceblue;
        }
        button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
}
        </style>
    </head>
    <body>
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
            </tr>
            <?php
                include('C:\xampp\htdocs\HERHEALTH\config.php');
                $sql="select * from patients";
                $result= $conn-> query($sql);
                if($result->num_rows>0)
                {
                     while($row=$result->fetch_assoc())
                    {
                        echo "<tr><td>".$row["name"]."</td><td>".$row["nurse_id"]."</td><td>".$row["patient_id"]."</td><td>".$row["age"]."</td><td>".$row["weight"]."</td><td>".$row["blood_group"]."</td><td>".$row["phone"]."</td><td>".$row["visit_date"]."</td><td>".$row["revisit_date"]."</td></tr>";
                    }
                    echo "</table>";
                }
                else
                {
                    echo "0 Result";
                }
            ?>
        </table>
        <centre>
        <div class="button-group">
        <button onclick="location.href='dashboard.html'">Dashboard</button>
        <button onclick="location.href='home.html'">Home</button>
        </div>
        </centre>
    </body>
</html>