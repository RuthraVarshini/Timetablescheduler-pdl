<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
    if ($_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
        $fileName = $_FILES['fileToUpload']['name'];
        $fileSize = $_FILES['fileToUpload']['size'];
        $fileType = $_FILES['fileToUpload']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allow certain file formats
        $allowedExtensions = array('xls', 'xlsx');
        if (in_array($fileExtension, $allowedExtensions)) {
            // Move uploaded file to the uploads directory
            $uploadPath = 'uploads/' . basename($fileName);
            move_uploaded_file($fileTmpPath, $uploadPath);

            // Include PHPExcel library for parsing Excel files
            require 'PHPExcel/PHPExcel.php';

            // Load the uploaded Excel file
            $excelReader = PHPExcel_IOFactory::createReaderForFile($uploadPath);
            $excelObj = $excelReader->load($uploadPath);
            $worksheet = $excelObj->getSheet(0);
            $lastRow = $worksheet->getHighestRow();

            // Establish database connection (replace with your actual database credentials)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ttdb";
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Loop through each row in the Excel file
            for ($row = 2; $row <= $lastRow; $row++) {
                $courseId = $worksheet->getCell('A' . $row)->getValue();
                $courseName = $worksheet->getCell('B' . $row)->getValue();
                $duration = $worksheet->getCell('C' . $row)->getValue();
                $type = $worksheet->getCell('D' . $row)->getValue();
                $credit = $worksheet->getCell('E' . $row)->getValue();
                $semester = $worksheet->getCell('F' . $row)->getValue();
                $hoursPerWeek = $worksheet->getCell('G' . $row)->getValue();

                // Insert data into the database
                $sql = "INSERT INTO courses (courseId, courseName, duration, type, credit, semester, hoursPerWeek)
                        VALUES ('$courseId', '$courseName', '$duration', '$type', '$credit', '$semester', '$hoursPerWeek')";

                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully<br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            // Close database connection
            $conn->close();
            
            // Delete the uploaded file
            unlink($uploadPath);

            echo "All records inserted successfully";
        } else {
            echo "Invalid file format. Please upload a valid Excel file.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
