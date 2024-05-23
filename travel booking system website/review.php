<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Management</title>
    <link rel="stylesheet" type="text/css" href="tables.css" title="style 1" media="screen, tv, projection, handheld, print" />
</head>
<body>
<header>
    <nav>
        <ul>
            <li class="dropdown">
                <a href="#" class="button">Menu</a>
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
    <h2>Review Management</h2>
    <table>
        <tr>
            <th>Review ID</th>
            <th>Hotel ID</th>
            <th>Flight ID</th>
            <th>Review Text</th>
        </tr>
        <?php
        include 'DB_connection.php'; // Include database connection

        // Handling POST requests for insert, update, or delete
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['add'])) {
                $stmt = $connection->prepare("INSERT INTO reviews (hotel_id, flight_id, review_text) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $_POST['hotel_id'], $_POST['flight_id'], $_POST['review_text']);
            } elseif (isset($_POST['update'])) {
                $stmt = $connection->prepare("UPDATE reviews SET hotel_id=?, flight_id=?, review_text=? WHERE review_id=?");
                $stmt->bind_param("iisi", $_POST['hotel_id'], $_POST['flight_id'], $_POST['review_text'], $_POST['review_id']);
            } elseif (isset($_POST['delete'])) {
                $stmt = $connection->prepare("DELETE FROM reviews WHERE review_id=?");
                $stmt->bind_param("i", $_POST['review_id']);
            }

            if ($stmt->execute()) {
                echo "<script>alert('Operation successful.');</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }

        // SQL query to fetch data
        $sql = "SELECT * FROM reviews";
        $result = $connection->query($sql);

        if ($result === false) {
            echo "<tr><td colspan='4'>Error fetching data: " . $connection->error . "</td></tr>";
        } elseif ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                            <td>{$row['review_id']}</td>
                            <td>{$row['hotel_id']}</td>
                            <td>{$row['flight_id']}</td>
                            <td>{$row['review_text']}</td>
                          </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data found</td></tr>";
        }

        $connection->close(); // Close the database connection
        ?>
    </table>

    <!-- Form for insert, update, or delete -->
    <h2>Manage Reviews</h2>
    <form method="post" action="" onsubmit="return confirmAction()">
        <!-- Hidden review_id field for updates and deletes -->
        <label for="review_id">Review ID:</label>
        <input type="number" id="review_id" name="review_id">
        <label for="hotel_id">Hotel ID:</label>
        <input type="number" id="hotel_id" name="hotel_id" required>
        <label for="flight_id">Flight ID:</label>
        <input type="number" id="flight_id" name="flight_id">
        <label for="review_text">Review Text:</label>
        <textarea id="review_text" name="review_text" required></textarea><br><br>
        <input type="submit" value="Insert" name="add">
        <input type="submit" value="Update" name="update">
        <input type="submit" value="Delete" name="delete">
    </form>
</div>

<script>
    function confirmAction() {
        var action = document.querySelector('input[type="submit"]:focus').value;
        var message = "Are you sure you want to " + action.toLowerCase() + " this review?";
        return confirm(message);
    }
</script>
</body>
</html>
