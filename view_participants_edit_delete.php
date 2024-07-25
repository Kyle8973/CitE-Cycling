<?php
session_start();
// Include database connection
include 'dbconnect.php';

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
    <title>Edit Participants</title>
	<link rel="icon" type="image/x-icon" href="navicon.png">
    <!-- Link to custom CSS file -->
    <link rel="stylesheet" href="styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        h1 {
            color: white !important;
        }
		a {
			color: white !important;
		}
        .result-box {
            margin: 20px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
        }
        .form-container {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
        }
        .filter-form {
            margin-top: 10px;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            width: 100%;
            max-width: 365px;
        }
		.btn,
		.btn-primary,
		.btn-danger
		{
			color: white !important;
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
    <div class="container d-flex flex-column align-items-center">
        <center><h1>Edit And Delete Participants</h1></center>
        <center><h3><a href="admin_menu.php">Click Here To Return To The Admin Menu</a></h3></center>
        
        <!-- Filter Form -->
        <form method="GET" action="" class="filter-form">
            <div class="form-group">
                <label for="participantID">Filter By Participant ID</label>
                <input type="number" class="form-control" id="participantID" name="participantID" placeholder="Enter Participant ID">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <div class="participant-list d-flex flex-column align-items-center">
            <?php
            try {
                $conn = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Prepare SQL statement based on whether an ID is provided
                if (isset($_GET['participantID']) && !empty($_GET['participantID'])) {
                    $participantID = $_GET['participantID'];
                    $stmt = $conn->prepare("SELECT * FROM participant WHERE id = :id");
                    $stmt->bindParam(':id', $participantID, PDO::PARAM_INT);
                    $id = $participantID; // Assigning $id the value of $participantID
                } else {
                    $stmt = $conn->prepare("SELECT * FROM participant");
                    $id = ''; // If no ID is provided, assign an empty string to $id
                }

                $stmt->execute();
                $participants = $stmt->fetchAll();

                // Check if there are participants in the database
                if (empty($participants)) {
                    echo "<br>";
                    echo "<div class='result-box'>";
                    echo "<center><p>The Database Is Either Empty Or No Participant With The ID <strong>$id</strong> Exists</p></center>"; // Error handling for if database is empty
                    echo "</div>"; // Close result-box div
                } else {
                    // Display participant data
                    foreach ($participants as $row) {
                        echo "<div class='result-box'>";
                        echo "<h3>Participant ID: {$row['id']}</h3>";
                        echo "<p>First Name: {$row['firstname']}</p>";
                        echo "<p>Last Name: {$row['surname']}</p>";
						echo "<p>Email: {$row['email']}</p>";

                        // Fetch and display club name
                        $clubId = $row['club_id'];
                        $stmtClub = $conn->prepare("SELECT name FROM club WHERE id = ?");
                        $stmtClub->execute([$clubId]);
                        $club = $stmtClub->fetch(PDO::FETCH_ASSOC);
                        if ($club) {
                            echo "<p>Club Associated With: {$club['name']}</p>";
                        } else {
                            echo "<p>This Person Is Not Associated With A Club</p>";
                        }

                        echo "<p>Power Output: {$row['power_output']} Watts</p>";
                        echo "<p>Distance Travelled: {$row['distance']} KM</p>";
                        echo "<p>Actions: <a href='edit_participant.php?id={$row['id']}' class='btn btn-primary'>Edit</a> <a href='delete.php?id={$row['id']}' class='btn btn-danger' onclick='return confirm(\"Are You Sure You Wish To Delete This Participant?\")'>Delete</a></p>";
                        echo "</div>"; // Close result-box div
                    }
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </div> <!-- Close participant-list div -->
    </div> <!-- Close container div -->
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>