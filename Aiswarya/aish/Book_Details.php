<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mcadb";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");

// Select the database
$conn->select_db($dbname);

// Create table if it doesn't exist
$table_sql = "CREATE TABLE IF NOT EXISTS book_details (
    id INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    edition INT NOT NULL,
    publisher VARCHAR(255) NOT NULL
)";
$conn->query($table_sql);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookno = (int)$_POST['bookno'];
    $booktitle = $conn->real_escape_string($_POST['booktitle']);
    $bookedition = (int)$_POST['booked'];
    $bookpub = $conn->real_escape_string($_POST['bookpub']);

    // Insert data using prepared statement
    $stmt = $conn->prepare("INSERT INTO book_details (id, title, edition, publisher) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $bookno, $booktitle, $bookedition, $bookpub);
    $stmt->execute();
    $stmt->close();
}

// Fetch all book records
$query = $conn->query("SELECT * FROM book_details");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Details</title>
    <style>
        table { border-collapse: collapse; width: 70%; margin: auto; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        form { margin: 20px auto; width: 300px; text-align: left; }
        label { display: block; margin-top: 10px; }
    </style>
</head>
<body>
<h2 align="center">Book Details</h2>

<!-- Form to add book -->
<form method="POST" action="">
    <label>Book Number: <input type="number" name="bookno" required></label>
    <label>Book Title: <input type="text" name="booktitle" required></label>
    <label>Book Edition: <input type="number" name="booked" min="1" required></label>
    <label>Book Publisher: <input type="text" name="bookpub" required></label>
    <input type="submit" value="Submit" style="margin-top:10px;">
</form>

<!-- Table to display books -->
<table>
    <tr>
        <th>Book Number</th>
        <th>Title</th>
        <th>Edition</th>
        <th>Publisher</th>
    </tr>
    <?php while ($row = $query->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['edition']); ?></td>
            <td><?php echo htmlspecialchars($row['publisher']); ?></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>

