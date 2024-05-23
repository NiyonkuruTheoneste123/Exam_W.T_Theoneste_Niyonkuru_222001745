<?php
session_start();
include 'DB_connection.php'; // Ensure this file exists and correctly sets up a database connection.

$userData = null;
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['view_profile'])) {
        $email = $_POST['email'];

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email format";
        } else {
            // Prepare SQL statement to retrieve user information
            $sql = "SELECT user_id, username, email, phone_number FROM users WHERE email = ?";
            $stmt = $connection->prepare($sql);
            if ($stmt === false) {
                $message = "Error preparing statement: " . $connection->error;
            } else {
                // Bind parameters
                $stmt->bind_param("s", $email);

                // Execute statement
                $stmt->execute();

                // Bind result variables
                $stmt->bind_result($user_id, $username, $email, $phone_number);

                // Fetch values
                if ($stmt->fetch()) {
                    $userData = ['user_id' => $user_id, 'username' => $username, 'email' => $email, 'phone_number' => $phone_number];
                } else {
                    $message = "No user found with the provided email.";
                }

                // Close statement
                $stmt->close();
            }
        }
    } elseif (isset($_POST['update'])) {
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email format";
        } else {
            // Prepare SQL statement to update user information
            $sql = "UPDATE users SET username = ?, email = ?, phone_number = ? WHERE user_id = ?";
            $stmt = $connection->prepare($sql);
            if ($stmt === false) {
                $message = "Error preparing statement: " . $connection->error;
            } else {
                // Bind parameters
                $stmt->bind_param("sssi", $username, $email, $phone_number, $user_id);

                // Execute statement
                if ($stmt->execute()) {
                    $message = "Profile updated successfully.";
                } else {
                    $message = "Error executing statement: " . $stmt->error;
                }

                // Close statement
                $stmt->close();
            }
        }
    } elseif (isset($_POST['delete'])) {
        $user_id = $_POST['user_id'];

        // Prepare SQL statement to delete user account
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $connection->prepare($sql);
        if ($stmt === false) {
            $message = "Error preparing statement: " . $connection->error;
        } else {
            // Bind parameters
            $stmt->bind_param("i", $user_id);

            // Execute statement
            if ($stmt->execute()) {
                $message = "Account deleted successfully.";
                session_destroy();
                header("Location: login.html"); // Redirect to login page after account deletion
                exit();
            } else {
                $message = "Error executing statement: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        }
    }
}

// Close connection
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
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
        input[type="email"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: dimgray;
            color: white;
            border: none;
            padding: 5px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
        .go-home {
            background-color: dimgray;
            color: white;
            border: none;
            padding: 5px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
        .go-home a {
            background-color: dimgray;
            color: white;
            border: none;
            padding: 5px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
        .message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <?php if (!isset($userData)): ?>
            <form method="post" action="">
                <label>Email:</label>
                <input type="email" name="email" required>
                <input type="submit" value="View Profile" name="view_profile">
            </form>
        <?php else: ?>
            <form method="post" action="">
                <input type="hidden" name="user_id" value="<?php echo $userData['user_id']; ?>">
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
                <label>Phone Number:</label>
                <input type="text" name="phone_number" value="<?php echo htmlspecialchars($userData['phone_number']); ?>" required>
                <input type="submit" value="Update Profile" name="update">
                <input type="submit" value="Delete Account" name="delete" onclick="return confirm('Are you sure you want to delete your account?');">
            </form>
        <?php endif; ?>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="go-home">
            <a href="home.html">Go Home</a>
        </div>
    </div>
</body>
</html>
