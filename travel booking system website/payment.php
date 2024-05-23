<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Information</title>
    <link rel="stylesheet" type="text/css" href="tables.css" title="style 1" media="screen, tv, projection, handheld, print" />
</head>
<body>
<header>
    <nav>
        <ul>
            <li class="dropdown">
                <a href="#" class="button">Others</a>
                <div class="dropdown-content">
                    <a class="button" href="flight.html">Flights</a>
                    <a class="button" href="hotel.html">Hotels</a>
                    <a class="button" href="booking.php">Bookings</a>
                    <a class="button" href="flight-booking.html">Flight Bookings</a>
                    <a class="button" href="hotel_booking.html">Hotel Booking</a>
                    <a class="button" href="payment.html">Payments</a>
                    <a class="button" href="location.html">Locations</a>
                    <a class="button" href="amenities.html">Amenities</a>
                    <a class="button" href="review.php">Review</a>
                </div>
                <li><a href="payment.html" class="back-button">Back</a></li>
            </li>
        </ul>
    </nav>
</header>

<div class="content">
    <h2>Payment Information</h2>
    <table>
        <tr>
            <th>Payment ID</th>
            <th>User ID</th>
            <th>Booking ID</th>
            <th>Amount($)</th>
            <th>Payment Date</th>
        </tr>
        <?php
        include 'DB_connection.php'; // Include database connection

        // Handling POST requests for insert, update, or delete
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['add'])) {
                $stmt = $connection->prepare("INSERT INTO payment (user_id, booking_id, amount, payment_date) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iids", $_POST['user_id'], $_POST['booking_id'], $_POST['amount'], $_POST['payment_date']);
            } elseif (isset($_POST['update'])) {
                $stmt = $connection->prepare("UPDATE payment SET user_id=?, booking_id=?, amount=?, payment_date=? WHERE payment_id=?");
                $stmt->bind_param("iidsi", $_POST['user_id'], $_POST['booking_id'], $_POST['amount'], $_POST['payment_date'], $_POST['payment_id']);
            } elseif (isset($_POST['delete'])) {
                $stmt = $connection->prepare("DELETE FROM payment WHERE payment_id=?");
                $stmt->bind_param("i", $_POST['payment_id']);
            }

            if ($stmt->execute()) {
                echo "<script>showAlert('Operation successful.');</script>";
            } else {
                echo "<script>showAlert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }

        // SQL query to fetch data
        $sql = "SELECT * FROM payment";
        $result = $connection->query($sql);

        if ($result === false) {
            echo "<tr><td colspan='5'>Error fetching data: " . $connection->error . "</td></tr>";
        } elseif ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                            <td>{$row['payment_id']}</td>
                            <td>{$row['user_id']}</td>
                            <td>{$row['booking_id']}</td>
                            <td>{$row['amount']}</td>
                            <td>{$row['payment_date']}</td>
                          </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data found</td></tr>";
        }

        $connection->close(); // Close the database connection
        ?>
    </table>

    <!-- Form for insert, update, or delete -->
    <h2>Manage Payment</h2>
    <form method="post" action="" onsubmit="return confirmAction()">
        <!-- Hidden payment_id field for updates and deletes -->
        <label for="payment_id">Payment ID:</label>
        <input type="number" id="payment_id" name="payment_id" required><br><br>
        <label for="user_id">User ID:</label>
        <input type="number" id="user_id" name="user_id" required><br><br>
        <label for="booking_id">Booking ID:</label>
        <input type="number" id="booking_id" name="booking_id" required><br><br>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="any" required><br><br>
        <label for="payment_date">Payment Date:</label>
        <input type="date" id="payment_date" name="payment_date" required><br><br>
        <input type="submit" value="Insert" name="add">
        <input type="submit" value="Update" name="update">
        <input type="submit" value="Delete" name="delete">
    </form>
</div>

<!-- Popup message and overlay -->
<div class="popup" id="popup">
    <p id="popupMessage"></p>
</div>
<div class="overlay" id="overlay"></div>

<script>
    function showAlert(message) {
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('popup').style.display = 'block';
        document.getElementById('popupMessage').innerText = message;
    }

    function hidePopup() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('popup').style.display = 'none';
    }

    function confirmAction() {
        var action = document.querySelector('input[type="submit"]:focus').value;
        var message = "Are you sure you want to " + action.toLowerCase() + " this payment?";
        return confirm(message);
    }
</script>
</body>
</html>
