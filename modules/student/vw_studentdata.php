
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Detail Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function toggleCollegeInput(selectObj) {
            var othersInput = document.getElementById('otherCollegeInput');
            if (selectObj.value === "Others") {
                othersInput.style.display = 'block';
            } else {
                othersInput.style.display = 'none';
            }
        }
    </script>
</head>
<style>
    body{
        background-color: yellow;
    }
</style>
<body>

<div class="container mt-5">
    <center><h2> STUDENT REGISTRATION FORM</h2></center>
    <form method="POST" action="receipt.php">
        <div class="mb-3">
            <label for="std_id" class="form-label">Student ID :</label>
            <input type="text" class="form-control" id="std_id" name="std_id" placeholder="Enter the student Id" required>
        </div>

        <div class="mb-3">
            <label for="std_name" class="form-label">Student Name :</label>
            <input type="text" class="form-control" id="std_name" name="std_name" placeholder="Enter the student Name" required>
        </div>
        <div class="mb-3">
            <label for="branch" class="form-label">Branch :</label>
            <input type="text" class="form-control" id="branch" name="branch" placeholder="Enter the student branch" required>
        </div>
        
        <div class="mb-3">
            <label for="course" class="form-label">Course :</label>
            <input type="text" class="form-control" id="course" name="course" placeholder="Enter the student Course" required>
        </div>
        <div class="mb-3">
            <label for="college" class="form-label">College</label>
            <select class="form-select" id="college" name="college" onchange="toggleCollegeInput(this)" required>
                <option value="" selected disabled>Select your college</option>
                <option value="VSM College Of Enginnering">VSM College Of Enginnering</option>
                <option value="Ideal Institute Of Technology">Ideal Institute Of Technology</option>
                <option value="Pragati college of engg">Pragati College Of Engineering</option>
                <option value="Others">Others</option>
            </select>
        </div>

        <div class="mb-3" id="otherCollegeInput" style="display:none;">
            <label for="new_college" class="form-label">Enter Your College Name</label>
            <input type="text" class="form-control" id="new_college" name="new_college">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter the student College Name" required>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label><br>
            <input type="radio" name="gender" value="Male" required> Male
            <input type="radio" name="gender" value="Female" required> Female
        </div>
        <div class="mb-3">
            <label for="skills" class="form-label">Skills</label>
            <select class="form-select" id="skills" name="skills[]" multiple onchange="updatePrice()" required>
                <option value="java">Java </option>
                <option value="html">HTML </option>
                <option value="css">CSS </option>
                <option value="js">JavaScript </option>
                <option value="php">PHP </option>
                <option value="react">React JS</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Total Price</label>
            <input type="text" class="form-control" id="price" name="price" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- JavaScript to Update Price -->
<script>
    function updatePrice() {
        const skillPrices = {
            'java': 2000,
            'html': 1000,
            'css': 1500,
            'js': 2500,
            'php': 3000,
            'react': 3500
        };

        const selectedSkills = document.getElementById('skills').selectedOptions;
        let totalPrice = 0;

        for (let i = 0; i < selectedSkills.length; i++) {
            totalPrice += skillPrices[selectedSkills[i].value];
        }

        document.getElementById('price').value = '$' + totalPrice;
    }
</script>
</body>
</html>


    
