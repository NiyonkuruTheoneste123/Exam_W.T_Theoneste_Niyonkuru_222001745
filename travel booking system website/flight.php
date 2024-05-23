<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Information</title>
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
                    <a class="button" href="hotel_booking.html">Bookings</a>
                    <a class="button" href="flight-booking.html">Flight Bookings</a>
                    <a class="button" href="hotel_booking.html">Hotel Booking</a>
                    <a class="button" href="payment.html">Payments</a>
                    <a class="button" href="location.html">Locations</a>
                    <a class="button" href="amenities.html">Amenities</a> 
                </div>
                <li><a href="flight.html" class="back-button">Back</a></li>
            </li>
        </ul>
    </nav>
</header>

<div class="content">
    <h2>Flight Information</h2>
    <table>
        <tr>
            <th>Flight ID</th>
            <th>Departure City</th>
            <th>Arrival City</th>
            <th>Departure Date</th>
            <th>Arrival Date</th>
        </tr>
        <?php
        include 'DB_connection.php'; // Include database connection

        // Handling POST requests for insert, update, or delete
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['add'])) {
                $stmt = $connection->prepare("INSERT INTO flights (departure_city, arrival_city, departure_date, arrival_date) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $_POST['departure_city'], $_POST['arrival_city'], $_POST['departure_date'], $_POST['arrival_date']);
            } elseif (isset($_POST['update'])) {
                $stmt = $connection->prepare("UPDATE flights SET departure_city=?, arrival_city=?, departure_date=?, arrival_date=? WHERE flight_id=?");
                $stmt->bind_param("ssssi", $_POST['departure_city'], $_POST['arrival_city'], $_POST['departure_date'], $_POST['arrival_date'], $_POST['flight_id']);
            } elseif (isset($_POST['delete'])) {
                $stmt = $connection->prepare("DELETE FROM flights WHERE flight_id=?");
                $stmt->bind_param("i", $_POST['flight_id']);
            }

            if ($stmt->execute()) {
                echo "<script>showAlert('Operation successful.');</script>";
            } else {
                echo "<script>showAlert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }

        // SQL query to fetch data
        $sql = "SELECT * FROM flights";
        $result = $connection->query($sql);

        if ($result === false) {
            echo "<tr><td colspan='5'>Error fetching data: " . $connection->error . "</td></tr>";
        } elseif ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                            <td>{$row['flight_id']}</td>
                            <td>{$row['departure_city']}</td>
                            <td>{$row['arrival_city']}</td>
                            <td>{$row['departure_date']}</td>
                            <td>{$row['arrival_date']}</td>
                          </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data found</td></tr>";
        }

        $connection->close(); // Close the database connection
        ?>
    </table>

    <!-- Form for insert, update, or delete -->
    <h2>Manage Flight</h2>
    <form method="post" action="" onsubmit="return confirmAction()">
        <!-- Hidden flight_id field for updates and deletes -->
        <label for="flight_id">Flight ID:</label>
        <input type="number" id="flight_id" name="flight_id" required><br><br>
        <label for="departure_city">Departure City:</label>
        <input type="text" id="departure_city" name="departure_city" required><br><br>
        <label for="arrival_city">Arrival City:</label>
        <input type="text" id="arrival_city" name="arrival_city" required><br><br>
        <label for="departure_date">Departure Date:</label>
        <input type="date" id="departure_date" name="departure_date" required><br><br>
        <label for="arrival_date">Arrival Date:</label>
        <input type="date" id="arrival_date" name="arrival_date" required><br><br>
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
        var message = "Are you sure you want to " + action.toLowerCase() + " this flight?";
        return confirm(message);
    }
</script>
</body>
</html>
