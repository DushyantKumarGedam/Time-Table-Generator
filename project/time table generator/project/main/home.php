<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>

<nav class="navbar navbar-expand-custom navbar-mainbg">
<a class="navbar-brand navbar-logo" href="../index.php"><img src="../image/time-table generator.png" alt="logo"></a>
    <button class="navbar-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars text-white"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <div class="hori-selector"><div class="left"></div><div class="right"></div></div>
            <li class="nav-item">
                <a class="nav-link" href="teacher.php"><i class="fas fa-tachometer-alt"></i>Add Teacher</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="subject.php"><i class="far fa-clone"></i>Add Suject</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="classroom.php"><i class="far fa-calendar-alt"></i>Add Classroom</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="allotment.php"><i class="far fa-chart-bar"></i>Allotment</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="generate.php"><i class="far fa-copy"></i>Generate Timetable</a>
            </li>
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="java/home.js"></script>

</body>
</html>
