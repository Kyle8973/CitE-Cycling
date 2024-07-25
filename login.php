<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
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
            color: #fff !important;
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
        <?php
        session_start();
        include 'dbconnect.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['username']) && !empty($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];

                try {
                    $stmt = $pdo->prepare("SELECT password FROM user WHERE username = ?"); //Check database for login credentials
                    $stmt->execute([$username]);
                    $user = $stmt->fetch();

                    if ($user && $password === $user['password']) {
                        $_SESSION['admin'] = true; // Set admin to true
                        echo "<center><h1>Welcome Admin</h1></center>";
                        echo "<ul class='menu'>";
                        echo "<li><a href='admin_menu.php'>Visit Admin Menu</a></li>";
                        echo "<li><a href='index.html'>Return To Home Page</a></li>";
                        echo "<li><a href='logout.php'>Logout</a></li>";
                        echo "</ul>";
                    } else {
                        echo "<a href='admin_login.html'>Invalid Credentials, Click Here To Return</a>";
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage());
                    echo "<p>Error: " . $e->getMessage() . "</p>"; //Error handling, displays error message
                }
            } else {
                echo "<script>alert('Please Fill In Both Username And Password Fields');</script>";
            }  
        } else {
            echo "<h1>You're Not Meant To Be Here, Something Has Gone Wrong</h1>";
            echo "<a href='admin_login.html'>Return To Login Page</a>";
            exit;
        }
        ?>
    </div>
</body>
</html>
