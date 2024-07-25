<?php
include 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $terms = isset($_POST['terms']) ? 1 : 0; // Check if terms checkbox is checked

    // Validate form data
    if (!empty($firstname) && !empty($surname) && !empty($email) && isset($_POST['terms'])) {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Insert data into the interest table
            $stmt = $conn->prepare("INSERT INTO interest (firstname, surname, email, terms) VALUES (:firstname, :surname, :email, :terms)");
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':surname', $surname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':terms', $terms); // Bind terms value
            $stmt->execute();
            // Redirect to registration.php
            header('Location: registered.php');
            exit; // Ensure that no other code after redirection
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "All Fields Are Required, You Must Also Accept The Terms And Conditions";
    }
}
?>