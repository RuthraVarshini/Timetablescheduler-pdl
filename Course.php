<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Details</title>
    <link rel="stylesheet" href="CSS/Course.css">
    <style>
       body {
        background-image: url('img/img4.jpg');
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
            <a href="Staff1.php">Teacher</a>
            <a href="Room.php">Rooms</a>
            <a href="GenerateTimetable.php">Generate Timetable</a>
        </div>
        <a href="home.php" class="logout">Logout</a>
    </div>
    <div class="container">
        <h1>Courses Details</h1>
        <form id="courseForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="courseId">Course ID:</label>
                <input type="text" id="courseId" name="courseId" placeholder="Enter Course ID">
            </div>
            <div class="form-group">
                <label for="courseName">Course Name:</label>
                <input type="text" id="courseName" name="courseName" placeholder="Enter Course Name">
            </div>
            <div class="form-group">
                <label for="duration">Duration:</label>
                <input type="text" id="duration" name="duration" placeholder="Enter Duration">
            </div>
            <div class="form-group">
                <label for="type">Type of Course:</label>
                <select id="type" name="type">
                    <option value="" disabled selected>Select Type</option>
                    <option value="theory">Theory</option>
                    <option value="lab">Lab</option>
                </select>
            </div>
            <div class="form-group">
                <label for="credit">Credit:</label>
                <input type="number" id="credit" name="credit" placeholder="Enter Credit (0-4)">
            </div>
            <div class="form-group">
                <label for="semester">Semester:</label>
                <select id="semester" name="semester">
                    <option value="" disabled selected>Select Semester</option>
                    <?php for($i = 1; $i <= 8; $i++) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                </select>
            </div>
            <!-- New field for hours per week -->
            <div class="form-group">
                <label for="hoursPerWeek">Hours per Week:</label>
                <input type="number" id="hoursPerWeek" name="hoursPerWeek" placeholder="Enter Hours per Week">
            </div>
            <button type="submit">Add</button>
        </form>    
        <?php
$servername = "localhost";
$username = "root";
$password = ""; // Assuming you don't have a password set for your local MySQL server
$dbname = "ttdb";
$port = 3306; // Assuming your MySQL server is running on port 3308

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $courseId = isset($_POST['courseId']) ? $_POST['courseId'] : null;
    $courseName = isset($_POST['courseName']) ? $_POST['courseName'] : null;
    $duration = isset($_POST['duration']) ? $_POST['duration'] : null;
    $type = isset($_POST['type']) ? $_POST['type'] : null;
    $credit = isset($_POST['credit']) ? $_POST['credit'] : null;
    $semester = isset($_POST['semester']) ? $_POST['semester'] : null;
    $hoursPerWeek = isset($_POST['hoursPerWeek']) ? $_POST['hoursPerWeek'] : null;

    // Check if courseId is provided
    if ($courseId !== null) {
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("INSERT INTO courses_detials (courseId, courseName, duration, type, credit, semester, hours_per_week) VALUES (?, ?, ?, ?, ?, ?, ?)");

        // Check if the statement is prepared successfully
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        // Bind parameters to the statement
        $stmt->bind_param("sssssii", $courseId, $courseName, $duration, $type, $credit, $semester, $hoursPerWeek);

        // Execute the INSERT statement
        if ($stmt->execute()) {
            echo "<p>New record created successfully.</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        // Close statement
        $stmt->close();
    } else {
        // Output an error message if courseId is not provided
        echo "<p>Error: Course ID is required.</p>";
    }
}

// Close connection
$conn->close();
?>
    </div>
</body>
</html>