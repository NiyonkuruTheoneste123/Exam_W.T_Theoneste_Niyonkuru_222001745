<?php
include 'DB_connection.php';

// Check if user is logged in
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Retrieve user information from the database
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_username = $_POST['new_username'];
        $new_email = $_POST['new_email'];
        $new_password = $_POST['new_password'];
        $new_phone_number = $_POST['new_phone_number'];

        // Validate email format
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format";
        } else {
            // Validate password format
            if (strlen($new_password) < 4 || !preg_match("/[A-Za-z]/", $new_password) || !preg_match("/\d/", $new_password)) {
                $error = "Password must be at least 4 characters long and contain at least one letter and one number";
            } else {
                // Hash the new password
                $new_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the user information in the database
                $update_sql = "UPDATE users SET username = ?, email = ?, password = ?, phone_number = ? WHERE username = ?";
                $update_stmt = $connection->prepare($update_sql);
                $update_stmt->bind_param("sssis", $new_username, $new_email, $new_password, $new_phone_number, $username);
                if ($update_stmt->execute()) {
                    // Redirect to a success page or display a success message
                    header("Location: account_updated.php");
                    exit();
                } else {
                    $error = "Error updating account";
                }

                $update_stmt->close();
            }
        }
    }
} else {
    $error = "User not found";
}

$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Settings</title>
</head>
<body>
    <h1>User Settings</h1>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    <form method="post" action="">
        <label for="new_username">New Username:</label><br>
        <input type="text" id="new_username" name="new_username" value="<?php echo isset($user['username']) ? $user['username'] : ''; ?>"><br><br>

        <label for="new_email">New Email:</label><br>
        <input type="email" id="new_email" name="new_email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>"><br><br>

        <label for="new_password">New Password:</label><br>
        <input type="password" id="new_password" name="new_password"><br><br>

        <label for="new_phone_number">New Phone Number:</label><br>
        <input type="text" id="new_phone_number" name="new_phone_number" value="<?php echo isset($user['phone_number']) ? $user['phone_number'] : ''; ?>"><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
