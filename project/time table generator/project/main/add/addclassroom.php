<?php
include("../delete/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $classId = mysqli_real_escape_string($con, $_POST['classId']);
    $course = mysqli_real_escape_string($con, $_POST['course']);

    // Insert data into the classrooms table
    $insert_query = "INSERT INTO classrooms (class_id, course) VALUES (?, ?)";

    if ($stmt = mysqli_prepare($con, $insert_query)) {
        mysqli_stmt_bind_param($stmt, "ss", $classId, $course);

        if (mysqli_stmt_execute($stmt)) {
            echo "Classroom added successfully!";
            header("Location:../classroom.php");
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
