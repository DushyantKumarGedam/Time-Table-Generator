<?php
include("../connection.php");
include("home.php");

$query = "SELECT * FROM teachers";
$result = mysqli_query($conn, $query);

if ($result) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teacher Information</title>
        <link rel="stylesheet" href="css/table.css">
        <link rel="stylesheet" href="css/teacher.css">
        
    </head>

    <body>
        <div class="container">
            <div class="add-teacher-btn-container">
                <button class="add-teacher-btn" onclick="openModal()">Add Teacher</button>
            </div>
            <table class="responsive-table">
                <caption>Teacher Information</caption>
                <thead>
                    <tr>
                        <th scope="col">Teacher ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Alias</th>
                        <th scope="col">Email</th>
                        <th scope="col">Contact No.</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="6">Data is current as of March 31, 2021.</td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $teacherId = isset($row['teacher_id']) ? $row['teacher_id'] : 'N/A';
                        $name = isset($row['Name']) ? $row['Name'] : 'N/A';
                        $alias = isset($row['Alias']) ? $row['Alias'] : 'N/A';
                        $email = isset($row['email']) ? $row['email'] : 'N/A';
                        $contactNo = isset($row['Contact_no.']) ? $row['Contact_no.'] : 'N/A';
                        ?>
                        <tr>
                            <td><?php echo $teacherId ?></td>
                            <td><?php echo $name ?></td>
                            <td><?php echo $alias ?></td>
                            <td><?php echo $email ?></td>
                            <td><?php echo $contactNo ?></td>
                            <td>
                                <a href="delete/delete_teacher.php?teacherId=<?php echo $teacherId; ?>" class="btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            
            <div id="addTeacherModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2 style="text-align: center; color: #007bff; margin-bottom: 20px; font-size: 24px;">Add Teacher</h2>

                    <form id="addTeacherForm" action="add/addteacher.php" method="post">
                        <label for="teacherid">Teacher ID:</label>
                        <input type="text" id="teacherid" name="teacherid" required>

                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>

                        <label for="alias">Alias:</label>
                        <input type="text" id="alias" name="alias" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="contactNo">Contact No.:</label>
                        <input type="text" id="contactNo" name="contactNo" required>

                        <input type="submit" value="Add Teacher" style="background-color: #28a745; color: #fff; padding: 10px 20px; font-size: 16px; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s;">

                        <style>
                        input[type="submit"]:hover {
                            background-color: #218838;
                        }
                        </style>

                    </form>
                </div>
            </div>
        </div>

        <script>
            function openModal() {
                document.getElementById('addTeacherModal').style.display = 'block';
            }

            function closeModal() {
                document.getElementById('addTeacherModal').style.display = 'none';
            }

            window.onclick = function (event) {
                var modal = document.getElementById('addTeacherModal');
                if (event.target == modal) {
                    closeModal();
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
