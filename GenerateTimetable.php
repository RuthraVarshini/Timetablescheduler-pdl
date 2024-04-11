<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Timetable</title>
    <link rel="stylesheet" href="CSS/Generate.css">

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
        <h2>Generate Timetable</h2>
        <div class="semester-select">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="semesterSelect">Select Semester:</label>
                <select id="semesterSelect" name="semester">
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4">Semester 4</option>
                    <option value="5">Semester 5</option>
                    <option value="6">Semester 6</option>
                    <option value="7">Semester 7</option>
                    <option value="8">Semester 8</option>
                </select>
                <button type="submit" id="generateBtn">Generate</button>
                <a href="#" id="downloadPdfBtn">Download as PDF</a> <!-- PDF download link -->
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script>
        document.getElementById('downloadPdfBtn').addEventListener('click', function() {
            const doc = new jsPDF();

            // Add content to the PDF
            const table = document.querySelector('.timetable');
            doc.text('Generated Timetable', 10, 10);
            doc.autoTable({ html: table });

            // Save the PDF file
            doc.save('timetable.pdf');
        });
    </script>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ttdb";
    $port = 3306; // Specify the port number here

    // Attempt to establish connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $semester = $_POST['semester'];
        // Fetch all courses for the selected semester
        $sql = "SELECT * FROM courses_detials WHERE semester = $semester";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Initialize a timetable array
            $timetable = array(
                "Monday" => array(),
                "Tuesday" => array(),
                "Wednesday" => array(),
                "Thursday" => array(),
                "Friday" => array()
            );

            // Initialize an array to track labs allocated per day
            $labsAllocatedPerDay = array(
                "Monday" => false,
                "Tuesday" => false,
                "Wednesday" => false,
                "Thursday" => false,
                "Friday" => false
            );

            // Separate lab courses and other courses
            $labCourses = array();
            $otherCourses = array();

            while ($row = $result->fetch_assoc()) {
                if ($row['type'] == "lab") {
                    $labCourses[] = $row['courseName'];
                } else {
                    // Add theory courses with the specified hours per week to the otherCourses array
                    $hours_per_week = $row['hours_per_week'];
                    for ($i = 0; $i < $hours_per_week; $i++) {
                        $otherCourses[] = $row['courseName'];
                    }
                }
            }

            // Randomly allocate lab courses for continuously three hours
            shuffle($labCourses);
            foreach ($labCourses as $labCourse) {
                $allocated = false;
                $days = array_keys($timetable); // Get the keys of the timetable array
                shuffle($days); // Shuffle the days to allocate labs randomly across different days
                foreach ($days as $day) {
                    // Check if there are enough consecutive slots available for lab and lab is not already allocated for this day
                    if (count($timetable[$day]) <= 4 && !$labsAllocatedPerDay[$day]) { // Assuming only morning slots
                        // Allocate lab course for 3 hours in a row
                        $timetable[$day][] = $labCourse;
                        $timetable[$day][] = $labCourse;
                        $timetable[$day][] = $labCourse;
                        $allocated = true;
                        $labsAllocatedPerDay[$day] = true; // Mark lab allocated for this day
                        break; // Exit the loop once allocated
                    }
                }
                if (!$allocated) {
                    echo "<p>Error: Insufficient slots to allocate 3-hour lab course or lab already allocated for the day.</p>";
                }
            }

            // Randomly allocate other courses within the timetable
            shuffle($otherCourses);
            foreach ($otherCourses as $otherCourse) {
                // Check if there are empty slots in the timetable
                $emptySlots = array_filter($timetable, function($slots) {
                    return count($slots) < 7; // Assuming only morning slots
                });
                if (!empty($emptySlots)) {
                    $day = array_rand($emptySlots);
                    $timetable[$day][] = $otherCourse;
                } else {
                    echo "<p>Error: Insufficient slots to allocate other courses.</p>";
                    break;
                }
            }

            // Display the generated timetable
            echo "<h2>Generated Timetable</h2>";
            echo "<table class='timetable'>";
            echo "<thead><tr><th></th><th>9:15 - 10:05</th><th>10:05 - 10:55</th><th>11:15 - 12:00</th><th>12.00 - 12:50</th><th>1.50 - 2.40</th><th>2.40 - 3.30</th><th>3.45 - 4.30</th></tr></thead>";
            echo "<tbody>";
            foreach ($timetable as $day => $slots) {
                echo "<tr>";
                echo "<td>$day</td>";
                foreach ($slots as $slot => $course) {
                    echo "<td>$course</td>";
                }
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No courses found for the selected semester.</p>";
        }
    }

    $conn->close();
    ?>
</body>
</html>
