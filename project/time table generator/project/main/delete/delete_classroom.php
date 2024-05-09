<?php
require_once("connection.php");

// Check if the connection is successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the class ID is provided in the URL
if (isset($_GET['classId'])) {
    $classId = $_GET['classId'];

    // Perform the deletion using a prepared statement
    $delete_query = "DELETE FROM classrooms WHERE class_id = ?";

    if ($stmt = mysqli_prepare($con, $delete_query)) {
        mysqli_stmt_bind_param($stmt, "s", $classId);  // Change "s" to "i" if class_id is an integer

        if (mysqli_stmt_execute($stmt)) {
            // Successful deletion
            header("Location: ../classroom.php"); // Redirect to the page where you display classroom records
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
    // Handle invalid or missing class ID
    echo "Invalid or missing class ID";
}

mysqli_close($con);
?>
