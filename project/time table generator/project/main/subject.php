<?php
include("../connection.php");
include("home.php");

$query = "SELECT * FROM subjects";
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
        <link rel="stylesheet" href="css/subject.css">
        
    </head>

    <body>
        <div class="container">
            <div class="add-subject-btn-container">
                <button class="add-subject-btn" onclick="openSubjectModal()">Add Subject</button>
            </div>
            <table class="responsive-table">
                <caption>Subject Information</caption>
                <thead>
                    <tr>
                        <th scope="col">Subject Code</th>
                        <th scope="col">Subject Name</th>
                        <th scope="col">Course Type</th>
                        <th scope="col">Course</th>
                        <th scope="col">Semester</th>
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
                        $subjectCode = isset($row['subject_code']) ? $row['subject_code'] : 'N/A';
                        $subjectName = isset($row['subject_name']) ? $row['subject_name'] : 'N/A';
                        $courseType = isset($row['course_type']) ? $row['course_type'] : 'N/A';
                        $course = isset($row['course']) ? $row['course'] : 'N/A';
                        $semester = isset($row['semester']) ? $row['semester'] : 'N/A';
                        ?>
                        <tr>
                            <td><?php echo $subjectCode ?></td>
                            <td><?php echo $subjectName ?></td>
                            <td><?php echo $courseType ?></td>
                            <td><?php echo $course ?></td>
                            <td><?php echo $semester ?></td>
                            <td>
                                <a href="delete/delete_subject.php?subjectCode=<?php echo $subjectCode; ?>" class="btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this subject?')">Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <div id="addSubjectModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeSubjectModal()">&times;</span>
        <h2 style="text-align: center; color: #007bff; margin-bottom: 20px; font-size: 24px;">Add Subject</h2>

        <form id="addSubjectForm" action="add/addsubject.php" method="post">
            <label for="subjectCode">Subject Code:</label>
            <input type="text" id="subjectCode" name="subjectCode" required>

            <label for="subjectName">Subject Name:</label>
            <input type="text" id="subjectName" name="subjectName" required>

            <label for="courseType">Course Type:</label>
            <input type="text" id="courseType" name="courseType" required>

            <label for="course">Course:</label>
            <input type="text" id="course" name="course" required>

            <label for="semester">Semester:</label>
            <input type="text" id="semester" name="semester" required>

            <input type="submit" value="Add Subject" style="background-color: #007bff; color: #fff; padding: 10px 20px; font-size: 16px; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s;">

            <style>
                input[type="submit"]:hover {
                    background-color: #0056b3;
                }
            </style>

        </form>
    </div>
</div>

<script>
    function openSubjectModal() {
        document.getElementById('addSubjectModal').style.display = 'block';
    }

    function closeSubjectModal() {
        document.getElementById('addSubjectModal').style.display = 'none';
    }

    window.onclick = function (event) {
        var modal = document.getElementById('addSubjectModal');
        if (event.target == modal) {
            closeSubjectModal();
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
