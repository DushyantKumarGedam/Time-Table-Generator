<?php
include("connection.php");

// Check if subjectCode is set in the URL
if (isset($_GET['subjectCode'])) {
    $subjectCode = mysqli_real_escape_string($con, $_GET['subjectCode']);

    // Fetch data for the selected subjectCode
    $query = "SELECT subjects.subject_code, subjects.subject_name, allotment.Allocated_1, allotment.Allocated_2, allotment.Allocated_3
              FROM subjects
              LEFT JOIN allotment ON subjects.subject_code = allotment.subject_code
              WHERE subjects.subject_code = '$subjectCode'";

    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $subjectCode = $row['subject_code'];
        $subjectName = $row['subject_name'];
        $allocated1 = $row['Allocated_1'];
        $allocated2 = $row['Allocated_2'];
        $allocated3 = $row['Allocated_3'];
    } else {
        // Subject not found in allotment table, set default values
        $subjectName = ''; // You may set a default value or show an error message
        $allocated1 = '';
        $allocated2 = '';
        $allocated3 = '';
    }
} else {
    // Redirect to the main page or show an error message
    header("Location: ../allotment.php");
    exit();
}

// Handle the form submission for editing the row
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve updated data from the form
    $updatedAllocated1 = mysqli_real_escape_string($con, $_POST['updatedAllocated1']);
    $updatedAllocated2 = mysqli_real_escape_string($con, $_POST['updatedAllocated2']);
    $updatedAllocated3 = mysqli_real_escape_string($con, $_POST['updatedAllocated3']);

    // Check if the subject exists in the allotment table
    $checkQuery = "SELECT * FROM allotment WHERE subject_code = '$subjectCode'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Subject exists in the allotment table, update the existing row
        $updateQuery = "UPDATE allotment SET
                        Allocated_1 = '$updatedAllocated1',
                        Allocated_2 = '$updatedAllocated2',
                        Allocated_3 = '$updatedAllocated3'
                        WHERE subject_code = '$subjectCode'";

        $updateResult = mysqli_query($con, $updateQuery);

        if ($updateResult) {
            // Redirect to the main page or show a success message
            header("Location: ../allotment.php");
            exit();
        } else {
            // Handle the update error
            echo 'Error updating data: ' . mysqli_error($con);
        }
    } else {
        // Subject does not exist in the allotment table, insert a new row
        $insertQuery = "INSERT INTO allotment (subject_code, subject_name, Allocated_1, Allocated_2, Allocated_3)
                        VALUES ('$subjectCode', '$subjectName', '$updatedAllocated1', '$updatedAllocated2', '$updatedAllocated3')";

        $insertResult = mysqli_query($con, $insertQuery);

        if ($insertResult) {
            // Redirect to the main page or show a success message
            header("Location: ../allotment.php");
            exit();
        } else {
            // Handle the insert error
            echo 'Error inserting data: ' . mysqli_error($con);
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Allotment</title>
    <link rel="stylesheet" href="../css/table.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
        }

        input {
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #007bff;
            margin-top: 10px;
            text-align: center;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Allotment - <?php echo $subjectCode; ?></h2>
        <form method="post" action="">
            <label for="updatedAllocated1">Allocated 1:</label>
            <input type="text" name="updatedAllocated1" value="<?php echo $allocated1; ?>" required>

            <label for="updatedAllocated2">Allocated 2:</label>
            <input type="text" name="updatedAllocated2" value="<?php echo $allocated2; ?>" required>

            <label for="updatedAllocated3">Allocated 3:</label>
            <input type="text" name="updatedAllocated3" value="<?php echo $allocated3; ?>" required>

            <button type="submit">Update</button>
            <a href="../allotment.php">Cancel</a>
        </form>
    </div>
</body>

</html>
