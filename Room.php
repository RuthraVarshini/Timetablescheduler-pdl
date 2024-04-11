<?php
$servername = "localhost:3306"; 
$username = "root";
$password = "";
$dbname = "ttdb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$roomType = $roomNumber = $capacity = '';
$message = ''; // Variable to hold the message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomType = $_POST['roomType'];
    $roomNumber = $_POST['roomNumber'];
    $capacity = $_POST['capacity'];

    $stmt = $conn->prepare("INSERT INTO room_details (roomType, roomNumber, allocation) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $roomType, $roomNumber, $capacity);

    if ($stmt->execute() === TRUE) {
        $message = "New record created successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/room.css">
    <title>Room Details Form</title>
    <style>
       body {
        background-image: url('img/img7.webp');
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
    <h2 style="margin-bottom: 20px">Room Details</h2>
    <?php if (!empty($message)) : ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="room-form">
        <div class="form-group">
            <label for="roomType">Room Type:</label>
            <select id="roomType" name="roomType">
                <option value="" disabled selected>--Select--</option>
                <option value="lectureHall">Lecture Hall</option>
                <option value="lab">Lab</option>
            </select>
        </div>

        <div class="form-group">
            <label for="roomNumber">Room Number:</label>
            <input
                type="text"
                id="roomNumber"
                name="roomNumber"
                placeholder="Enter Room Number"
                required
            />
        </div>

        <div class="form-group">
            <label for="capacity">Capacity:</label>
            <input
                type="text"
                id="capacity"
                name="capacity"
                placeholder="Enter capacity"
                required
            />
        </div>

        <div class="form-group" style="text-align: center">
            <button type="submit">Submit</button>
        </div>
    </form>
</div>

</body>
</html>
