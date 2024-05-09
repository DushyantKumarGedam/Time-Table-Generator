<?php
include("../connection.php");
include("home.php");

// Assuming your table for classrooms is named "classrooms"
$query = "SELECT * FROM classrooms";
$result = mysqli_query($conn, $query);

if ($result) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Classroom Information</title>
        <link rel="stylesheet" href="css/table.css">
        <link rel="stylesheet" href="css/classroom.css">
    </head>

    <body>
        <div class="container">
            <div class="add-classroom-btn-container">
                <button class="add-classroom-btn" onclick="openClassroomModal()">Add Classroom</button>
            </div>
            <table class="responsive-table">
                <caption>Classroom Information</caption>
                <thead>
                    <tr>
                        <th scope="col">Class ID</th>
                        <th scope="col">Course</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="3">Data is current as of March 31, 2021.</td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $classId = isset($row['class_id']) ? $row['class_id'] : 'N/A';
                        $course = isset($row['course']) ? $row['course'] : 'N/A';
                        ?>
                        <tr>
                            <td><?php echo $classId ?></td>
                            <td><?php echo $course ?></td>
                            <td>
                                <a href="delete/delete_classroom.php?classId=<?php echo $classId; ?>" class="btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this classroom?')">Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <div id="addClassroomModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeClassroomModal()">&times;</span>
                    <h2 style="text-align: center; color: #007bff; margin-bottom: 20px; font-size: 24px;">Add Classroom</h2>

                    <form id="addClassroomForm" action="add/addclassroom.php" method="post">
                        <label for="classId">Class ID:</label>
                        <input type="text" id="classId" name="classId" required>

                        <label for="course">Course:</label>
                        <input type="text" id="course" name="course" required>

                        <input type="submit" value="Add Classroom" style="background-color: #007bff; color: #fff; padding: 10px 20px; font-size: 16px; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s;">

                        <style>
                            input[type="submit"]:hover {
                                background-color: #0056b3;
                            }
                        </style>

                    </form>
                </div>
            </div>

            <script>
                function openClassroomModal() {
                    document.getElementById('addClassroomModal').style.display = 'block';
                }

                function closeClassroomModal() {
                    document.getElementById('addClassroomModal').style.display = 'none';
                }

                window.onclick = function (event) {
                    var modal = document.getElementById('addClassroomModal');
                    if (event.target == modal) {
                        closeClassroomModal();
                    }
                };
            </script>
        </body>

    </html>
    <?php
} else {
    echo 'Error fetching data from the database: ' . mysqli_error($conn);
}

mysqli_close($conn);
?>
