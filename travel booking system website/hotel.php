<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Information</title>
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
                <li><a href="hotel.html" class="back-button">Back</a></li>
            </li>
        </ul>
    </nav>
</header>

<div class="content">
    <h2>Hotel Information</h2>
    <table>
        <tr>
            <th>Hotel ID</th>
            <th>Hotel Name</th>
            <th>Location</th>
            <th>Price Per Night($)</th>
            <th>Rating</th>
        </tr>
        <?php
        include 'DB_connection.php'; // Include database connection

        // Handling POST requests for insert, update, or delete
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['add'])) {
                $stmt = $connection->prepare("INSERT INTO hotels (hotel_name, location, price_per_night, rating) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssdi", $_POST['hotel_name'], $_POST['location'], $_POST['price_per_night'], $_POST['rating']);
            } elseif (isset($_POST['update'])) {
                $stmt = $connection->prepare("UPDATE hotels SET hotel_name=?, location=?, price_per_night=?, rating=? WHERE hotel_id=?");
                $stmt->bind_param("ssdii", $_POST['hotel_name'], $_POST['location'], $_POST['price_per_night'], $_POST['rating'], $_POST['hotel_id']);
            } elseif (isset($_POST['delete'])) {
                $stmt = $connection->prepare("DELETE FROM hotels WHERE hotel_id=?");
                $stmt->bind_param("i", $_POST['hotel_id']);
            }

            if ($stmt->execute()) {
                echo "<script>showAlert('Operation successful.');</script>";
            } else {
                echo "<script>showAlert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }

        // SQL query to fetch data
        $sql = "SELECT * FROM hotels";
        $result = $connection->query($sql);

        if ($result === false) {
            echo "<tr><td colspan='5'>Error fetching data: " . $connection->error . "</td></tr>";
        } elseif ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                            <td>{$row['hotel_id']}</td>
                            <td>{$row['hotel_name']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['price_per_night']}</td>
                            <td>{$row['rating']}</td>
                          </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data found</td></tr>";
        }

        $connection->close(); // Close the database connection
        ?>
    </table>

    <!-- Form for insert, update, or delete -->
    <h2>Manage Hotel</h2>
    <form method="post" action="" onsubmit="return confirmAction()">
        <!-- Hidden hotel_id field for updates and deletes -->
        <label for="hotel_id">Hotel ID:</label>
        <input type="number" id="hotel_id" name="hotel_id" required><br><br>
        <label for="hotel_name">Hotel Name:</label>
        <input type="text" id="hotel_name" name="hotel_name" required><br><br>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required><br><br>
        <label for="price_per_night">Price Per Night:</label>
        <input type="number" id="price_per_night" name="price_per_night" required><br><br>
        <label for="rating">Rating:</label>
        <input type="number" id="rating" name="rating" required><br><br>
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
        var message = "Are you sure you want to " + action.toLowerCase() + " this hotel?";
        return confirm(message);
    }
</script>
</body>
</html>
