<!DOCTYPE html>
<?php
// Include database connection
include 'dbconnect.php';

// Check if participant ID is provided in the URL
if (isset($_GET['id'])) {
    try {
        // Connect to the database
        $conn = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch participant information based on the provided ID
        $participant_id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM participant WHERE id = ?");
        $stmt->execute([$participant_id]);
        $participant = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if participant exists
        if (!$participant) {
            throw new Exception("No Participant With The ID $participant_id Was Found");
        }

        // Assign fetched values to variables
        $firstname = $participant['firstname'];
        $surname = $participant['surname'];
        $id = $participant['id'];
        $power_output = $participant['power_output'];
        $distance = $participant['distance'];
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    } catch(Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "";
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Participant Scores</title>
    <link rel="icon" type="image/x-icon" href="navicon.png">
    <!-- Link to custom CSS file -->
    <link rel="stylesheet" href="styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        a {
            display: block;
            padding: 10px;
            border-radius: 5px;
            color: #000 !important; /* Ensure text color is black */
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            transition: background-color 0.3s ease;
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
            <?php if (isset($firstname)) : ?>
                <form action="edit_participant.php" method="POST">
                    <div class="form-group">
                        <label for="firstname">Participant First Name</label>
                        <input type="text" name="firstname" id="firstname" readonly value="<?php echo htmlspecialchars($firstname); ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="surname">Participant Surname</label>
                        <input type="text" name="surname" id="surname" readonly value="<?php echo htmlspecialchars($surname); ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="id">Participant ID</label>
                        <input type="text" name="id" id="id" readonly value="<?php echo htmlspecialchars($id); ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="power_output">Power Output In Watts</label>
                        <input type="text" name="power_output" id="power_output" pattern="^[0-9]+(\.[0-9]+)?$" title="Only Numbers 0 Or Higher Are Allowed" value="<?php echo htmlspecialchars($power_output); ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="distance">Distance In KM</label>
                        <input type="text" name="distance" id="distance" pattern="^[0-9]+(\.[0-9]+)?$" title="Only Numbers 0 Or Higher Are Allowed" value="<?php echo htmlspecialchars($distance); ?>" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update This Participant</button>
                </form>
            <?php else : ?>
                <p class="text-center">No Participant With The ID <?php echo htmlspecialchars($_GET['id']); ?> Was Found</p>
                <a class="nav-link text-center" href="view_participants_edit_delete.php">Click Here To Return To The Participant List</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
