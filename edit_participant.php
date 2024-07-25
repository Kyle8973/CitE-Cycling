<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Participants Score</title>
	<link rel="icon" type="image/x-icon" href="navicon.png">
    <!-- Link to custom CSS file -->
    <link rel="stylesheet" href="styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        a {
            color: #000 !important;
            font-weight: bold;
        }
	.result-box {
    max-width: 400px; /* Limit maximum width of result box */
    margin: 20px auto; /* Center the result box horizontally */
    padding: 30px; /* Add padding inside the result box */
    background-color: #fff; /* White background for result box */
    border-radius: 8px; /* Rounded corners for result box */
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Box shadow for result box */
    margin-bottom: 20px; /* Add margin between each result box */
    color: black; /* Black text colour */
}
    </style>
</head>
<body>
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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Update participant scores
            $id = $_POST['id'];
            $power_output = $_POST['power_output'];
            $distance = $_POST['distance'];
            $stmt = $conn->prepare("UPDATE participant SET power_output = :power_output, distance = :distance WHERE id = :id");
            $stmt->bindParam(':power_output', $power_output);
            $stmt->bindParam(':distance', $distance);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            echo "<div class='result-box'>";
            echo '<center><a href="view_participants_edit_delete.php">Updated, Click Here To Go Back To The Participant List</a></center>';
            echo "</div>";
            echo '</div>';
        } else {
            // Fetch participant data for editing
            $id = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM participant WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $participant = $stmt->fetch(PDO::FETCH_ASSOC);
            include "edit_participant_form.php";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</body>
</html>