<?php
include("../delete/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $teacherId = mysqli_real_escape_string($con, $_POST['teacherid']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $alias = mysqli_real_escape_string($con, $_POST['alias']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contactNo = mysqli_real_escape_string($con, $_POST['contactNo']);

    // Insert data into the teachers table
    $insert_query = "INSERT INTO teachers (teacher_id, Name, Alias, email, `Contact_no.`) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($con, $insert_query)) {
        mysqli_stmt_bind_param($stmt, "sssss", $teacherId, $name, $alias, $email, $contactNo);

        if (mysqli_stmt_execute($stmt)) {
            
            echo "Teacher added successfully!";
            header("Location:../teacher.php");
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
