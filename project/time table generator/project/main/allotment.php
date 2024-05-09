<?php
include("../connection.php");
include("home.php");

$query = "SELECT subjects.subject_code, subjects.subject_name, allotment.Allocated_1, allotment.Allocated_2, allotment.Allocated_3
          FROM subjects
          LEFT JOIN allotment ON subjects.subject_code = allotment.subject_code";

$result = mysqli_query($conn, $query);

if ($result) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allotment Information</title>
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/allotment.css">
    <!-- Add any additional styles or scripts as needed -->
    <style>
        /* Styles for the edit modal */
        .edit-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            z-index: 1000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>

<body>
    <div class="container">
        <table class="responsive-table">
            <caption>Allotment Information (Read-Only)</caption>
            <thead>
                <tr>
                    <th scope="col">Subject Code</th>
                    <th scope="col">Subject Name</th>
                    <th scope="col">Allocated 1</th>
                    <th scope="col">Allocated 2</th>
                    <th scope="col">Allocated 3</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="6">Data is current as of <?php echo date("F j, Y"); ?></td>
                </tr>
            </tfoot>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $subjectCode = isset($row['subject_code']) ? $row['subject_code'] : 'N/A';
                    $subjectName = isset($row['subject_name']) ? $row['subject_name'] : 'N/A';
                    $allocated1 = isset($row['Allocated_1']) ? $row['Allocated_1'] : 'N/A';
                    $allocated2 = isset($row['Allocated_2']) ? $row['Allocated_2'] : 'N/A';
                    $allocated3 = isset($row['Allocated_3']) ? $row['Allocated_3'] : 'N/A';
                ?>
                    <tr>
                        <td><?php echo $subjectCode ?></td>
                        <td><?php echo $subjectName ?></td>
                        <td><?php echo $allocated1 ?></td>
                        <td><?php echo $allocated2 ?></td>
                        <td><?php echo $allocated3 ?></td>
                        <td>
                            <button class="btn-primary btn-sm" onclick="openEditModal('<?php echo $subjectCode; ?>')">Edit</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <!-- Edit Modal -->
        <div class="overlay" id="editOverlay"></div>
        <div class="edit-modal" id="editModal">
            <h2>Edit Allotment - <span id="editSubjectCode"></span></h2>
            <form id="editForm" method="post">
                <label for="updatedAllocated1">Allocated 1:</label>
                <input type="text" name="updatedAllocated1" id="updatedAllocated1" required>

                <label for="updatedAllocated2">Allocated 2:</label>
                <input type="text" name="updatedAllocated2" id="updatedAllocated2" required>

                <label for="updatedAllocated3">Allocated 3:</label>
                <input type="text" name="updatedAllocated3" id="updatedAllocated3" required>

                <button type="button" onclick="updateAllotment()">Update</button>
                <button type="button" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>

        <script>
            // Inside your script tag in index.php
            function openEditModal(subjectCode) {
                document.getElementById('editSubjectCode').innerText = subjectCode;

                // Fetch existing data for the subjectCode and pre-fill the form
                // You can use AJAX to fetch data from the server and update the form

                // For now, let's assume you have the data available in JavaScript variables
                var allocated1 = "Fetched Allocated 1";
                var allocated2 = "Fetched Allocated 2";
                var allocated3 = "Fetched Allocated 3";

                document.getElementById('updatedAllocated1').value = allocated1;
                document.getElementById('updatedAllocated2').value = allocated2;
                document.getElementById('updatedAllocated3').value = allocated3;

                // Add the following lines to open edit_allotment.php with parameters
                var editUrl = "delete/edit_allotment.php?subjectCode=" + encodeURIComponent(subjectCode);
                window.location.href = editUrl;

                // The rest of your code remains the same
                // document.getElementById('editOverlay').style.display = 'block';
                // document.getElementById('editModal').style.display = 'block';
            }


            function closeEditModal() {
                document.getElementById('editOverlay').style.display = 'none';
                document.getElementById('editModal').style.display = 'none';
            }

            function updateAllotment() {
                // Perform the update operation here
                // You can use AJAX to send the updated data to the server and handle the update

                // After the update is successful, close the modal
                closeEditModal();
            }
        </script>
    </div>
</body>

</html>
<?php
} else {
    echo 'Error fetching data from the database: ' . mysqli_error($conn);
}

mysqli_close($conn);
?>
