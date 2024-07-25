 <?php
            session_start();

            // Check if the user is not logged in, redirect to login page
            if (!isset($_SESSION['admin'])) {
                header('Location: admin_login.html');
                exit;
			}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search For Participant Or Club</title>
	<link rel="icon" type="image/x-icon" href="navicon.png">
    <!-- Link to custom CSS file -->
    <link rel="stylesheet" href="styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        a {
            color: black !important
        }
		.btn-primary {
			font-weight: bold;
		}
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.html">
            <img src="navicon.png" alt="Cit-E Cycling Logo" height="40" class="mr-2"> Cit-E Cycling
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="register_form.html">Register For Future Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_menu.php">Admin Menu</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <div class="container">
        <div class="login-container">
            <h1>Participant Search</h1>
            <form action="search_result.php" method="POST">
                <input type="text" name="firstname" class="form-control" placeholder="Participant First Name or Surname" required>
                <input type="hidden" name="participant" value="1">
                <input type="submit" value="Search" class="btn btn-primary">
            </form>
            <br>
            <h1>Club Search</h1>
            <form action="search_result.php" method="POST">
                <input type="text" name="club" class="form-control" placeholder="Club Name" required>
                <input type="submit" value="Search" class="btn btn-primary">
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
