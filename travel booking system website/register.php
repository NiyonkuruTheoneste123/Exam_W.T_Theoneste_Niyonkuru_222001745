<?php
include 'DB_connection.php'; // Ensure this file exists and correctly sets up a database connection.

$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit();
    }

    // Validate password
    if (strlen($password) < 4 || !preg_match("/[A-Za-z]/", $password) || !preg_match("/\d/", $password)) {
        echo "Password must be at least 4 characters long and contain at least one letter and one number";
        exit();
    }

    // Hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement
    $sql = "INSERT INTO users (username, email, password, phone_number) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    if ($stmt === false) {
        echo "Error preparing statement: " . $connection->error;
        exit();
    }

    // Bind parameters
    $stmt->bind_param("ssss", $username, $email, $password, $phone_number);

    // Execute statement
    if ($stmt->execute()) {
        $success = true;
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1 {
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
        }
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .popup .close-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
    <script>
        function showPopup() {
            document.getElementById("successPopup").style.display = "block";
        }

        function closePopup() {
            document.getElementById("successPopup").style.display = "none";
            window.location.href = "login.html"; // Redirect to login page after closing the popup
        }
    </script>
</head>
<body>
    <?php if ($success): ?>
    <div id="successPopup" class="popup">
        <p>Successfully registered!</p>
        <button class="close-btn" onclick="closePopup()">OK</button>
    </div>
    <script>
        showPopup();
    </script>
    <?php else: ?>
    <div class="container">
        <h1>Register</h1>
        <form method="post" action="">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <label>Phone Number:</label>
            <input type="text" name="phone_number" required>
            <input type="submit" value="Register">
        </form>
    </div>
    <?php endif; ?>
</body>
</html>
