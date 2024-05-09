<?php
require_once("connection.php");

// Check if the connection is successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the subject code is provided in the URL
if (isset($_GET['subjectCode'])) {
    $subjectCode = $_GET['subjectCode'];

    // Perform the deletion using a prepared statement
    $delete_query = "DELETE FROM subjects WHERE subject_code = ?";

    if ($stmt = mysqli_prepare($con, $delete_query)) {
        mysqli_stmt_bind_param($stmt, "s", $subjectCode);  // Change "s" to "i" if subject_code is an integer

        if (mysqli_stmt_execute($stmt)) {
            // Successful deletion
            header("Location: ../subject.php"); // Redirect to the page where you display subject records
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
    // Handle invalid or missing subject code
    echo "Invalid or missing subject code";
}

mysqli_close($con);
?>
