<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Amenities Information</title>
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
                <li><a href="amenities.html" class="back-button">Back</a></li>
            </li>
        </ul>
    </nav>
</header>

<div class="content">
    <h2>Hotel Amenities Information</h2>
    <table>
        <tr>
            <th>Amenity ID</th>
            <th>Amenity Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Hotel ID</th>
        </tr>
        <?php
        include 'DB_connection.php'; // Include database connection

        // Handling POST requests for insert, update, or delete
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['add'])) {
                $stmt = $connection->prepare("INSERT INTO amenities (amenity_name, category, description, hotel_id) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssi", $_POST['amenity_name'], $_POST['category'], $_POST['description'], $_POST['hotel_id']);
            } elseif (isset($_POST['update'])) {
                $stmt = $connection->prepare("UPDATE amenities SET amenity_name=?, category=?, description=?, hotel_id=? WHERE amenity_id=?");
                $stmt->bind_param("sssii", $_POST['amenity_name'], $_POST['category'], $_POST['description'], $_POST['hotel_id'], $_POST['amenity_id']);
            } elseif (isset($_POST['delete'])) {
                $stmt = $connection->prepare("DELETE FROM amenities WHERE amenity_id=?");
                $stmt->bind_param("i", $_POST['amenity_id']);
            }

            if ($stmt->execute()) {
                echo "<script>showAlert('Operation successful.');</script>";
            } else {
                echo "<script>showAlert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }

        // SQL query to fetch data
        $sql = "SELECT * FROM amenities";
        $result = $connection->query($sql);

        if ($result === false) {
            echo "<tr><td colspan='5'>Error fetching data: " . $connection->error . "</td></tr>";
        } elseif ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                            <td>{$row['amenity_id']}</td>
                            <td>{$row['amenity_name']}</td>
                            <td>{$row['category']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['hotel_id']}</td>
                          </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data found</td></tr>";
        }

        $connection->close(); // Close the database connection
        ?>
    </table>

    <!-- Form for insert, update, or delete -->
    <h2>Manage Hotel Amenities</h2>
    <form method="post" action="" onsubmit="return confirmAction()">
        <!-- Hidden amenity_id field for updates and deletes -->
        <label for="amenity_id">Amenity ID:</label>
        <input type="number" id="amenity_id" name="amenity_id"><br><br>
        <label for="amenity_name">Amenity Name:</label>
        <input type="text" id="amenity_name" name="amenity_name" required><br><br>
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required><br><br>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required><br><br>
        <label for="hotel_id">Hotel ID:</label>
        <input type="number" id="hotel_id" name="hotel_id" required><br><br>
        <input type="submit" value="Insert" name="add">
        <input type="submit" value="Update" name="update">
        <input type="submit" value="Delete" name="delete">
    </form>
</div>
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
        var message = "Are you sure you want to " + action.toLowerCase() + " this amenity?";
        return confirm(message);
    }
</script>
</body>
</html>
