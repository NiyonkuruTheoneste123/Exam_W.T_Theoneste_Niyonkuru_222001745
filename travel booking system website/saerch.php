<?php
// Connection details
$host = "localhost";
$user = "noble@";
$pass = "222001745";
$database = "travelbookingsystem";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if form is submitted
if(isset($_POST['submit'])) {
    $table = $_POST['table_name'];
    
    // Query to get table columns
    $columns_query = "SHOW COLUMNS FROM $table";
    $columns_result = $connection->query($columns_query);
    
    if ($columns_result->num_rows > 0) {
        // Fetch column names and details
        $column_details = array();
        while($row = $columns_result->fetch_assoc()) {
            $column_details[] = $row;
        }

        // Query to get table data rows
        $data_query = "SELECT * FROM $table";
        $data_result = $connection->query($data_query);
        
        if ($data_result->num_rows > 0) {
            echo "<h2>Table: $table</h2>";
            echo "<table>";
            echo "<tr>";
            // Display column names
            foreach ($column_details as $column) {
                echo "<th>".$column['Field']."</th>";
            }
            echo "</tr>";
            // Display data rows
            while($row = $data_result->fetch_assoc()) {
                echo "<tr>";
                foreach($row as $key => $value) {
                    echo "<td>".$value."</td>";
                }
                echo "</tr>";
            }
            echo "</table>";

            // Add the "Manipulate Data" button
            $manipulate_file = $table . '.php';
            echo "<form method='post' action='$manipulate_file'>";
            echo "<input type='hidden' name='table_name' value='$table'>";
            echo "<button type='submit'>Manipulate Data</button>";
            echo "<a href='home.html'><button type='button'>Go Home</button></a>";
            echo "</form>";
        } else {
            echo "No data found in table";
        }
    } else {
        echo "Table not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        button {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        a button {
            background-color: #28a745;
        }
        a button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Search Table</h1>
    <form method="post" action="">
        <label>Enter Table Name:</label>
        <input type="text" name="table_name" required>
        <input type="submit" name="submit" value="Search">
    </form>
</body>
</html>
