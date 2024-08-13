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

// Check if date is provided, otherwise use today's date
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Fetch attendance records for the selected date
$sql = "SELECT * FROM attendance WHERE date='$date'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Attendance for <?php echo $date; ?></h2>
    <form method="GET" action="view_attendance.php" class="mb-4">
        <div class="form-group">
            <label for="attendanceDate">Select Date:</label>
            <input type="date" class="form-control" id="attendanceDate" name="date" value="<?php echo $date; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">View Attendance</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Type</th>
                <th>Name</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["entity_type"]. "</td><td>" . $row["entity_name"]. "</td><td>" . $row["date"]. "</td><td>" . $row["status"]. "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No attendance records found for this date.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
