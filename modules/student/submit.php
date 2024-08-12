<?php
// Database 
$host = "localhost";
$user = "root";
$password = "";
$database = "oceanapps_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Get form data
$std_id = $_POST['std_id'];
$std_name = $_POST['std_name'];
$course = $_POST['course'];
$branch = $_POST['branch'];
$college = $_POST['college'];
$email = $_POST['email'];

if ($college == 'Others') {
    $college = $_POST['new_college'];
}
// Check if the student email already exists
$sql = "SELECT * FROM tblstds WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo "<center><div class='container mt-5'><div class='alert alert-danger'>Student Email already exists!</div></div></center>";
} else {
    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert new student data into tblstds
        $sql = "INSERT INTO tblstds (std_id, std_name, branch, course, college_name, email) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $std_id, $std_name, $branch, $course, $college, $email);
        $stmt->execute();

        // Insert data into tblemp
        $sql = "INSERT INTO tblemp (empname, designation, email, password, createdon, program) VALUES (?, 'student', ?, ?, NOW(), NULL)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $std_name, $email, $password);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        echo "<center><div class='container mt-5'><div class='alert alert-success'>Student data successfully inserted into both tables!</div></div></center>";
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo "<div class='container mt-5'><div class='alert alert-danger'>Error: " . $e->getMessage() . "</div></div>";
    }
}

$stmt->close();
$conn->close();
?>
