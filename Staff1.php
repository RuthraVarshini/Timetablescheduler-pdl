<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Details Form</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/Staff.css">
    <style>
       body {
        background-image: url('img/img5.jpg');
        background-size: cover;
        background-position: center;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 10px; /* Increased top and bottom padding */
        background-color: #333;
        color: #fff;
        width: 90%; /* Adjusted width */
        margin: auto; /* Centered the header */
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Added shadow effect */
    }

    .nav-links {
        flex: 1; /* Take up remaining space */
    }

    .nav-links a {
        color: #fff;
        text-decoration: none;
        margin-right: 20px;
    }

    .nav-links a:hover {
        text-decoration: underline;
    }

    .logout {
        color: #fff;
        text-decoration: none;
        margin-left: auto; /* Align to the right */
    }


    .container {
        width: 50%;
        margin: auto;
        padding: 20px;
        margin-top: 50px;
        background-color: #77bdd6;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    select {
        width: calc(100% - 22px);
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    </style>
</head>
<body>
<div class="header">
    <div class="nav-links">
        <a href="Course.php">Courses</a>
        <a href="Staff1.php">Faculty</a>
        <a href="Room.php">Rooms</a>
        <a href="GenerateTimetable.php">Generate Timetable</a>
    </div>
    <a href="home.php" class="logout">Logout</a>
</div>
<div class="container">
    <h1 class="mt-5 mb-4">Faculty Details</h1>
    <?php
    // Database connection parameters
    $servername = "localhost";
    $username = "root"; // Replace with your MySQL username
    $password = ""; // Replace with your MySQL password
    $dbname = "ttdb";   // Replace with your MySQL database name
    $port = 3306; // Specify the port number here

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $name = $designation = $email = $academic_position = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = test_input($_POST["id"]);
        $name = test_input($_POST["name"]);
        $designation = test_input($_POST["designation"]);
        $email = test_input($_POST["email"]);
        $academic_position = test_input($_POST["academic_position"]);

        // Insert data into database
        $sql = "INSERT INTO staff_details (id, name, designation, email, academic_position) VALUES ('$id', '$name', '$designation', '$email', '$academic_position')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="id">ID:</label>
            <input type="text" class="form-control" id="id" name="id" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="designation">Designation:</label>
            <input type="text" class="form-control" id="designation" name="designation" required>
        </div>
        <div class="form-group">
            <label for="email">Email ID:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="academic_position">Academic Position:</label>
            <select class="form-control" id="academic_position" name="academic_position" required>
                <option value="">Select Academic Position</option>
                <option value="Professor">Professor</option>
                <option value="Assistant Professor">Assistant Professor</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html
