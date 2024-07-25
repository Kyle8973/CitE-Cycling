<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete Participant</title>
	<link rel="icon" type="image/x-icon" href="navicon.png">
    <!-- Link to custom CSS file -->
    <link rel="stylesheet" href="styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            font-weight: bold;
        }
		a {
			color: black !important;
			font-weight: bold;
		}
    </style>
</head>
<body>
    <?php
    include 'dbconnect.php';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
            // Check if ID exists in the database
            $id = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM participant WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $participant = $stmt->fetch();
            if (!$participant) {
                echo "<div class='container'>";
                echo "<p>No Participant With The ID $id Exists</p>";
				echo "<center><a href='view_participants_edit_delete.php'>Click Here To Return To All Users</a></center>";
                echo "</div>";
            } else {
                // Delete participant
                $stmt = $conn->prepare("DELETE FROM participant WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                echo "<div class='container'>";
                echo "</center><p>The Participant With The ID $id Has Been Deleted</p></center>";
				echo "<center><a href='view_participants_edit_delete.php'>Click Here To Return To All Users</a></center>";
                echo "</div>";
            }
        } else {
            echo "<div class='container'>";
            echo "<center><p>No ID Provided</p></center>";
			echo "<center><a href='view_participants_edit_delete.php'>Return To All Users</a></center>";
            echo "</div>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</body>
</html>