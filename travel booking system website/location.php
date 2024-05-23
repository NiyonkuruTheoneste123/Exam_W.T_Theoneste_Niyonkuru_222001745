<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Information</title>
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
                <li><a href="location.html" class="back-button">Back home</a></li>
            </li>
        </ul>
    </nav>
</header>

<div class="content">
    <h2>Location Information</h2>
    <table>
        <tr>
            <th>Location ID</th>
            <th>Location Name</th>
            <th>Country</th>
            <th>Latitude(degree)</th>
            <th>Longitude(degree)</th>
        </tr>
        <?php
        include 'DB_connection.php'; // Include database connection

        // Handling POST requests for insert, update, or delete
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['add'])) {
                $stmt = $connection->prepare("INSERT INTO locations (location_name, country, latitude, longitude) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssdd", $_POST['location_name'], $_POST['country'], $_POST['latitude'], $_POST['longitude']);
            } elseif (isset($_POST['update'])) {
                $stmt = $connection->prepare("UPDATE locations SET location_name=?, country=?, latitude=?, longitude=? WHERE location_id=?");
                $stmt->bind_param("ssddi", $_POST['location_name'], $_POST['country'], $_POST['latitude'], $_POST['longitude'], $_POST['location_id']);
            } elseif (isset($_POST['delete'])) {
                $stmt = $connection->prepare("DELETE FROM locations WHERE location_id=?");
                $stmt->bind_param("i", $_POST['location_id']);
            }

            if ($stmt->execute()) {
                echo "<script>showAlert('Operation successful.');</script>";
            } else {
                echo "<script>showAlert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }

        // SQL query to fetch data
        $sql = "SELECT * FROM locations";
        $result = $connection->query($sql);

        if ($result === false) {
            echo "<tr><td colspan='5'>Error fetching data: " . $connection->error . "</td></tr>";
        } elseif ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                            <td>{$row['location_id']}</td>
                            <td>{$row['location_name']}</td>
                            <td>{$row['country']}</td>
                            <td>{$row['latitude']}</td>
                            <td>{$row['longitude']}</td>
                          </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data found</td></tr>";
        }

        $connection->close(); // Close the database connection
        ?>
    </table>

    <!-- Form for insert, update, or delete -->
    <h2>Manage Location</h2>
    <form method="post" action="" onsubmit="return confirmAction()">
        <!-- Hidden location_id field for updates and deletes -->
        <label for="location_id">Location ID:</label>
        <input type="number" id="location_id" name="location_id" required><br><br>
        <label for="location_name">Location Name:</label>
        <input type="text" id="location_name" name="location_name" required><br><br>
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" required><br><br>
        <label for="latitude">Latitude:</label>
        <input type="number" id="latitude" name="latitude" step="any" required><br><br>
        <label for="longitude">Longitude:</label>
        <input type="number" id="longitude" name="longitude" step="any" required><br><br>
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
        var message = "Are you sure you want to " + action.toLowerCase() + " this location?";
        return confirm(message);
    }
</script>
</body>
</html>
