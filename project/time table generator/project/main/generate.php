<?php
include("../connection.php");
include("home.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Timetable</title>

    <link rel="stylesheet" href="css/timetable.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        input[type="text"] {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
        #printButton {
            background-color: #28a745;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
        }

        #printButton:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>

    <h2>University Timetable</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
        if (isset($_POST['generate_button'])) {
            // Execute the Python script using exec
            exec("python3 generate.py");        
            echo "<p>Timetables have been generated successfully!</p>";
        }
    }
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="submit" name="generate_button" value="Generate Timetables">
    </form>


    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="class_id">Enter Class ID:</label>
        <input type="text" id="class_id" name="class_id" required>
        <input type="submit" value="Show Timetable for Class">
    </form>

    <!-- Teacher Timetable Form -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="teacher_id">Enter Teacher ID:</label>
        <input type="text" id="teacher_id" name="teacher_id" required>
        <input type="submit" value="Show Timetable for Teacher">
    </form

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Replace these connection details with your actual MySQL credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "project";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get user input (class_id or teacher_id)
        $userInput = $_POST['class_id'] ?? ($_POST['teacher_id'] ?? null);

        // Initialize an empty string for SQL query
        $sql = "";

        // Determine whether to show timetable for class or teacher based on user input
        if (isset($_POST['class_id'])) {
            // Construct SQL for class form
            $sql = "SELECT t.time_slot, 
                MAX(CASE WHEN t.Days = 'Monday' THEN CONCAT(s.subject_name, ' (', t.teacher_id, ')') END) AS Monday,
                MAX(CASE WHEN t.Days = 'Tuesday' THEN CONCAT(s.subject_name, ' (', t.teacher_id, ')') END) AS Tuesday,
                MAX(CASE WHEN t.Days = 'Wednesday' THEN CONCAT(s.subject_name, ' (', t.teacher_id, ')') END) AS Wednesday,
                MAX(CASE WHEN t.Days = 'Thursday' THEN CONCAT(s.subject_name, ' (', t.teacher_id, ')') END) AS Thursday,
                MAX(CASE WHEN t.Days = 'Friday' THEN CONCAT(s.subject_name, ' (', t.teacher_id, ')') END) AS Friday
            FROM timetable t
            LEFT JOIN subjects s ON t.subject_code = s.subject_code
            WHERE t.class_id = '$userInput'
            GROUP BY t.time_slot
            ORDER BY t.time_slot";
        } elseif (isset($_POST['teacher_id'])) {
            // Construct SQL for teacher form
            $sql = "SELECT t.time_slot, 
                           MAX(CASE WHEN t.Days = 'Monday' THEN CONCAT(s.subject_name, ' (', t.class_id, ')') END) AS Monday,
                           MAX(CASE WHEN t.Days = 'Tuesday' THEN CONCAT(s.subject_name, ' (', t.class_id, ')') END) AS Tuesday,
                           MAX(CASE WHEN t.Days = 'Wednesday' THEN CONCAT(s.subject_name, ' (', t.class_id, ')') END) AS Wednesday,
                           MAX(CASE WHEN t.Days = 'Thursday' THEN CONCAT(s.subject_name, ' (', t.class_id, ')') END) AS Thursday,
                           MAX(CASE WHEN t.Days = 'Friday' THEN CONCAT(s.subject_name, ' (', t.class_id, ')') END) AS Friday
                    FROM timetable t
                    LEFT JOIN subjects s ON t.subject_code = s.subject_code
                    WHERE t.teacher_id = '$userInput'
                    GROUP BY t.time_slot
                    ORDER BY t.time_slot";
        }

        // Check if $sql is not empty before executing the query
        if (!empty($sql)) {
            $result = $conn->query($sql);

            // Check for errors in the query execution
            if ($result === false) {
                echo "Error: " . $conn->error;
            } else {
                // Output data to the HTML table
                if ($result->num_rows > 0) {
                    echo "<h3>Timetable for " . (isset($_POST['class_id']) ? "Class $userInput" : "Teacher $userInput") . "</h3>";
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Time</th>";
                    echo "<th>Monday</th>";
                    echo "<th>Tuesday</th>";
                    echo "<th>Wednesday</th>";
                    echo "<th>Thursday</th>";
                    echo "<th>Friday</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['time_slot'] . "</td>";
                        echo "<td>" . ($row['Monday'] ?? '') . "</td>";
                        echo "<td>" . ($row['Tuesday'] ?? '') . "</td>";
                        echo "<td>" . ($row['Wednesday'] ?? '') . "</td>";
                        echo "<td>" . ($row['Thursday'] ?? '') . "</td>";
                        echo "<td>" . ($row['Friday'] ?? '') . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<p>No timetable found for " . (isset($_POST['class_id']) ? "Class $userInput" : "Teacher $userInput") . ".</p>";
                }
            }
        } else {
            // Handle the case when $sql is empty
            echo "Invalid form submission.";
        }

        // Close connection
        $conn->close();
    }
    ?>

    <button id="printButton" onclick="printTimetable()">Print Timetable</button>

    <script>
        function printTimetable() {
            // Hide unnecessary elements
            document.body.style.backgroundColor = '#fff'; // Set background color for better print quality
            document.querySelector('h2').style.display = 'none';
            document.querySelectorAll('form').forEach(form => form.style.display = 'none');

            // Print the timetable table
            window.print();

            // Restore elements after printing
            document.body.style.backgroundColor = ''; // Reset background color
            document.querySelector('h2').style.display = 'block';
            document.querySelectorAll('form').forEach(form => form.style.display = 'block');
        }
    </script>

</body>
</html>
