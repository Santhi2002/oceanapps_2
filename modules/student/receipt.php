<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $std_id = htmlspecialchars($_POST['std_id']);
    $std_name = htmlspecialchars($_POST['std_name']);
    $branch = htmlspecialchars($_POST['branch']);
    $course = htmlspecialchars($_POST['course']);
    $gender = htmlspecialchars($_POST['gender']);
    $skills = $_POST['skills'];
    $price = htmlspecialchars($_POST['price']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body{
        background-color: greenyellow;
        border-color: green;
    }
</style>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Payment Receipt</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Student ID: <?php echo $std_id; ?></h5>
            <p class="card-text"><strong>Name:</strong> <?php echo $std_name; ?></p>
            <p class="card-text"><strong>Branch:</strong> <?php echo $branch; ?></p>
            <p class="card-text"><strong>Course:</strong> <?php echo $course; ?></p>
            <p class="card-text"><strong>Gender:</strong> <?php echo $gender; ?></p>
            <p class="card-text"><strong>Skills:</strong> <?php echo implode(", ", array_map('ucfirst', $skills)); ?></p>
            <p class="card-text"><strong>Total Price:</strong> <?php echo $price; ?></p>
            <!-- <p class="card-text"><strong>Status:</strong> Payment Successful</p> -->
             <form action="sucess.php">
             <button class="btn btn-primary">Pay Amount</button>
             </form>
        </div>
    </div>
</div>
<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
