<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Information</title>
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
            </li>
            <li><a href="home.html" class="back-button">Back</a></li>
        </ul>
    </nav>
</header>

<div class="content">
    <h2>Booking Information</h2>
    <table>
        <tr>
            <th>Booking ID</th>
            <th>Flight ID</th>
            <th>Hotel ID</th>
            <th>Booking Date</th>
        </tr>
        <?php
        include 'DB_connection.php'; // Include database connection

        // Handling POST requests for insert, update, or delete
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['add'])) {
                $stmt = $connection->prepare("INSERT INTO bookings (flight_id, hotel_id, booking_date) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $_POST['flight_id'], $_POST['hotel_id'], $_POST['booking_date']);
            } elseif (isset($_POST['update'])) {
                $stmt = $connection->prepare("UPDATE bookings SET flight_id=?, hotel_id=?, booking_date=? WHERE booking_id=?");
                $stmt->bind_param("iiii", $_POST['flight_id'], $_POST['hotel_id'], $_POST['booking_date'], $_POST['booking_id']);
            } elseif (isset($_POST['delete'])) {
                $stmt = $connection->prepare("DELETE FROM bookings WHERE booking_id=?");
                $stmt->bind_param("i", $_POST['booking_id']);
            }

            if ($stmt->execute()) {
                echo "<script>showAlert('Operation successful.');</script>";
            } else {
                echo "<script>showAlert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }

        // SQL query to fetch data
        $sql = "SELECT * FROM bookings";
        $result = $connection->query($sql);

        if ($result === false) {
            echo "<tr><td colspan='5'>Error fetching data: " . $connection->error . "</td></tr>";
        } elseif ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                            <td>{$row['booking_id']}</td>
                            <td>{$row['flight_id']}</td>
                            <td>{$row['hotel_id']}</td>
                            <td>{$row['booking_date']}</td>
                          </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data found</td></tr>";
        }

        $connection->close(); // Close the database connection
        ?>
    </table>

    <!-- Form for insert, update, or delete -->
    <h2>Manage Booking</h2>
    <form method="post" action="" onsubmit="return confirmAction()">
        <!-- Hidden booking_id field for updates and deletes -->
        <label for="booking_id">Booking ID:</label>
        <input type="number" id="booking_id" name="booking_id" required><br><br>
        <label for="flight_id">Flight ID:</label>
        <input type="number" id="flight_id" name="flight_id" required><br><br>
        <label for="hotel_id">Hotel ID:</label>
        <input type="number" id="hotel_id" name="hotel_id" required><br><br>
        <label for="booking_date">Booking Date:</label>
        <input type="date" id="booking_date" name="booking_date" required><br><br>
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
        var message = "Are you sure you want to " + action.toLowerCase() + " this booking?";
        return confirm(message);
    }
</script>
</body>
</html>
