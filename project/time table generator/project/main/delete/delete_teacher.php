<?php
require_once("connection.php");

// Check if the connection is successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the teacher ID is provided in the URL
if (isset($_GET['teacherId'])) {
    $teacher_id = $_GET['teacherId'];

    // Perform the deletion using a prepared statement
    $delete_query = "DELETE FROM teachers WHERE teacher_id = ?";

    if ($stmt = mysqli_prepare($con, $delete_query)) {
        mysqli_stmt_bind_param($stmt, "s", $teacher_id);  // Change "s" to "i" if teacher_id is an integer

        if (mysqli_stmt_execute($stmt)) {
            // Successful deletion
            header("Location: ../teacher.php"); // Redirect to the page where you display teacher records
            exit();
        } else {
            // Handle deletion failure
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        // Handle prepared statement creation failure
        echo "Error: " . mysqli_error($con);
    }
} else {
    // Handle invalid or missing teacher ID
    echo "Invalid or missing teacher ID";
}

mysqli_close($con);
?>
