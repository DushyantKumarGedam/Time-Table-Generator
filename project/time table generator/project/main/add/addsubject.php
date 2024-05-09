<?php
include("../delete/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $subjectCode = mysqli_real_escape_string($con, $_POST['subjectCode']);
    $subjectName = mysqli_real_escape_string($con, $_POST['subjectName']);
    $courseType = mysqli_real_escape_string($con, $_POST['courseType']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);

    // Insert data into the subjects table
    $insert_query = "INSERT INTO subjects (subject_code, subject_name, course_type, course, semester) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($con, $insert_query)) {
        mysqli_stmt_bind_param($stmt, "sssss", $subjectCode, $subjectName, $courseType, $course, $semester);

        if (mysqli_stmt_execute($stmt)) {
            echo "Subject added successfully!";
            header("Location:../subject.php");
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    // Handle non-POST requests
    echo "Invalid request method";
}

mysqli_close($con);
?>
