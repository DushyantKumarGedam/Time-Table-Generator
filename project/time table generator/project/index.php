<?php
require("login.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Automated Timetable Generator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Logo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                
                <li class="nav-item">
                    <a class="nav-link" href="About.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="help.php">Help</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="#myModal" class="nav-link" id="loginLink" data-toggle="modal">Login</a>
                </li>
                <li class="nav-item">
                    <a href="signUp.php" class="nav-link">Sign Up</a>
                </li>
                <li class="nav-item">
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div id="title" class="slide header">
        <h1>Time-Table Generator</h1>
        <h3>The secret of your future is hidden in your daily routine <br> - Mike Murdock </h3>
        
    </div>

    <div id="slide1" class="slide">
        <div class="title">
            <h1>About Us</h1>
            <p>The proposed timetable generation algorithm employs a genetic approach, utilizing a structured object hierarchy with classrooms, weeks, days, and timeslots. The fitness score assesses conflicts, ensuring optimal faculty utilization. The use of a composite design pattern enhances flexibility for adding or removing responsibilities, promoting scalability.</p>
           
        </div>
    </div>

    <div id="slide2" class="slide">
        <div class="title">
            <h1>Contact Us</h1>
            <p>For any inquiries, feel free to reach out to us:</p>
            <div class="contact-info">
                <p><strong>Email:</strong> info@example.com</p>
                <p><strong>Phone:</strong> +1 (555) 123-4567</p>
                <p><strong>Address:</strong> 123 Main Street, Cityville</p>
            </div>
           
        </div>
        
    </div>

    <div id="slide3" class="slide">
        <div class="title">
            <h1>Help</h1>
            <h2>Frequently Asked Questions (FAQs)</h2>
            <p><strong>Q: How do I create an account?</strong></p>
            <p>A: To create an account, click on the "Sign Up" button on the homepage and follow the instructions.</p>

            <p><strong>Q: I forgot my password. What should I do?</strong></p>
            <p>A: Click on the "Forgot Password" link on the login page and follow the steps to reset your password.</p>
        </div>
    </div>
    

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#loginLink').on('click', function () {
                $('#myModal').modal('show');
            });
        });
       
    </script>
</body>

</html>
