<?php
include 'DB_connection.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit();
    }

    // Check if email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Generate a unique token for password reset (you can use a library like PHPMailer or generate your own)
        $token = uniqid();

        // Store the token in the database
        $sql = "UPDATE users SET reset_token = ? WHERE email = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s",$email);
        $stmt->execute();

        // Send email with password reset link
        // (you need to implement the email sending functionality)
        $reset_link = "http://yourdomain.com/reset_password_page.php?token=$token";
        // Example of sending email (you should implement this part)
        // mail($email, "Password Reset", "Click the following link to reset your password: $reset_link");

        echo "An email with instructions to reset your password has been sent to your email address.";
    } else {
        echo "Email address not found";
    }

    // Close statement and database connection
    $stmt->close();
    $connection->close();
}
?>
