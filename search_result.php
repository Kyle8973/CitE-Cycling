<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Results</title>
    <link rel="icon" type="image/x-icon" href="navicon.png">
    <!-- Link to custom CSS file -->
    <link rel="stylesheet" href="styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        h1, h2 {
            color: white !important;
        }
        a {
            color: white;
        }
        .black-text {
            color: black !important;
        }
    </style>
</head>
<body>
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
    <br>
    <div class="container">
        <?php
            session_start();

            // Check if the user is not logged in, redirect to login page
            if (!isset($_SESSION['admin'])) {
                header('Location: admin_login.html');
                exit;
            }

            include 'dbconnect.php';

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if ($_POST['participant'] == "1") {
                    // Search for an individual participant
                    $searchQuery = $_POST['firstname'];
                    $stmt = $conn->prepare("SELECT * FROM participant WHERE firstname LIKE ? OR surname LIKE ?");
                    $stmt->execute(["%$searchQuery%", "%$searchQuery%"]);
                    $participants = $stmt->fetchAll();

                    if (count($participants) > 0) {
                        echo "<center><h2>Search Results For Participant '$searchQuery':</h2></center>";
                        echo "<center><h3><a href='admin_menu.php'>Click Here To Return To The Admin Menu</a></h3></center>";
                        echo "<div class='result-box-container'>";
                        foreach ($participants as $participant) {
                            echo "<div class='result-box'>";
                            echo "<h3>Results Found For: {$participant['firstname']} {$participant['surname']}</h3>";
                            echo "<p>Participant ID: {$participant['id']}</p>";
                            echo "<p>Email: {$participant['email']}</p>";

                            // Fetch and display club name
                            $clubId = $participant['club_id'];
                            $stmt = $conn->prepare("SELECT name FROM club WHERE id = ?");
                            $stmt->execute([$clubId]);
                            $club = $stmt->fetch();
                            if ($club) {
                                echo "<p>Club Associated With: {$club['name']}</p>";
                            } else {
                                echo "<p>This Person Is Not Associated With A Club</p>";
                            }
                            echo "<p>Distance Travelled: " . number_format($participant['distance'], 2) . " KM</p>";
                            echo "<p>Power Output: " . number_format($participant['power_output'], 2) . " Watts</p>";
                            echo "</div>";
                        }
                        echo "</div>";
                    } else {
                        echo "<div class='result-box-container'>";
                        echo "<div class='result-box'>";
                        echo '<center><p class="text-dark">No Participants Found With The Given Name <a href="search_form.php" class="text-dark"><br><br><strong>Click Here To Search Again</strong></a></p></center>';
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    // Search for a club
                    $searchQuery = $_POST['club'];
                    $stmt = $conn->prepare("SELECT * FROM club WHERE name LIKE ?");
                    $stmt->execute(["%$searchQuery%"]);
                    $clubs = $stmt->fetchAll();

                    if (count($clubs) > 0) {
                        echo "<center><h2>Search Results For Club '$searchQuery':</h2></center>";
                        echo "<center><h3><a href='admin_menu.php'>Click Here To Return To The Admin Menu</a></h3></center>";
                        foreach ($clubs as $club) {
                            $clubId = $club['id'];
                            $stmt = $conn->prepare("SELECT * FROM participant WHERE club_id = ?");
                            $stmt->execute([$clubId]);
                            $participants = $stmt->fetchAll();

                            $totalDistance = 0;
                            $totalPowerOutput = 0;
                            $participantCount = count($participants);

                            foreach ($participants as $participant) {
                                $totalDistance += $participant['distance'];
                                $totalPowerOutput += $participant['power_output'];
                            }

                            $averageDistance = $participantCount > 0 ? $totalDistance / $participantCount : 0;
                            $averagePowerOutput = $participantCount > 0 ? $totalPowerOutput / $participantCount : 0;

                            echo "<div class='result-box'>";
                            echo "<h3>Results Found For: {$club['name']}</h3>";
                            echo "<p>Total Distance Travelled: " . number_format($totalDistance, 2) . " KM</p>";
                            echo "<p>Total Power Output: " . number_format($totalPowerOutput, 2) . " Watts</p>";
                            echo "<p>Average Distance Travelled: " . number_format($averageDistance, 2) . " KM</p>";
                            echo "<p>Average Power Output: " . number_format($averagePowerOutput, 2) . " Watts</p>";
                            echo "</div>";

                            // Display participants details
                            echo "<div class='result-box'>";
                            echo "<h3>Participants In This Club:</h3>";
                            foreach ($participants as $participant) {
                                echo "<div class='result-box'>";
                                echo "<p>Participant Name: {$participant['firstname']} {$participant['surname']}</p>";
                                echo "<p>Participant ID: {$participant['id']}</p>";
                                echo "<p>Email: {$participant['email']}</p>";
                                echo "<p>Distance Travelled: " . number_format($participant['distance'], 2) . " KM</p>";
                                echo "<p>Power Output: " . number_format($participant['power_output'], 2) . " Watts</p>";
                                echo "</div>";
                            }
                            echo "</div>";
                        }
                    } else {
                        echo "<div class='result-box-container'>";
                        echo "<div class='result-box'>";
                        echo '<center><p class="text-dark">No Clubs Found With The Given Name <a href="search_form.php" class="text-dark"><br><br><strong>Click Here To Search Again</strong></a></p></center>';
                        echo "</div>";
                        echo "</div>";
                    }
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        ?>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
