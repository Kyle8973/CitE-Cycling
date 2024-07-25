<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Menu</title>
	<link rel="icon" type="image/x-icon" href="navicon.png">
    <!-- Link to custom CSS file -->
    <link rel="stylesheet" href="styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: rgb(2,0,36);
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%);
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #000;
            font-weight: bold;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        a {
            display: block;
            padding: 10px;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff !important; /* Ensure text color is white */
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cit-E Cycling Admin Portal</h1>
        <ul>
            <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
            <!-- Display admin links if they are logged in -->
            <li><a href="index.html">Return Home</a></li>
            <li><a href="search_form.php">Search For Clubs And Participants</a></li>
            <li><a href="view_participants_edit_delete.php">Edit And Delete Participants</a></li>
            <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
            <!-- Display error message if not logged in as admin -->
            <li class="text-center">You Are Not Authorised, Please Login As An Admin</li>
            <li class="text-center"><a href="admin_login.html">Click Here To Login</a></li>
            <?php endif; ?>
        </ul> 
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>