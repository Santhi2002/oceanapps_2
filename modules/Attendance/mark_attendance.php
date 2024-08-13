<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entity_type = $_POST['entity_type'];
    $entity_name = $_POST['entity_name'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM attendance WHERE entity_type=? AND entity_name=? AND date=?");
    $stmt->bind_param("sss", $entity_type, $entity_name, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Attendance for " . htmlspecialchars($entity_type) . " " . htmlspecialchars($entity_name) . " on " . htmlspecialchars($date) . " is already recorded.";
    } else {
        // Insert attendance data into the database using a prepared statement
        $stmt = $conn->prepare("INSERT INTO attendance (entity_type, entity_name, date, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $entity_type, $entity_name, $date, $status);

        if ($stmt->execute()) {
            echo "Attendance recorded successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
