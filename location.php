<?php
include "db_connection.php";
error_reporting(0);
session_start(); // Starting the session

if(isset($_POST['submit'])){
    // Retrieving the selected location from the form
    $selected_location = $_POST['location'];

    // Storing the selected location in the session variable
    $_SESSION['selectedLocation'] = $selected_location;
    
    // Redirecting to another page or performing other actions if needed
    header('Location: home.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Location</title>
    <link rel="stylesheet" href="styles.css">
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #c6d6e6;
        }

        header {
            background-color: #004a98;
            color: white;
            padding: 20px;
            text-align: center;
        }

        main {
            padding: 20px;
        }

        .locations {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            height: 350px;
            margin: 20px;
            width: 40%;
            margin-left: 28%;
            margin-top: 60px;
            animation: slideInUp 1s ease;
        }

        .locations h2 {
            margin-top: 90px;
            margin-bottom: 20px;
            text-align: center;
        }

        #location-select {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-left: 10%;
        }

        #submit-btn {
            display: block;
            width: 20%;
            margin-left: 38%;
            padding: 10px;
            margin-top: 20px;
            background-color: #004a98;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #submit-btn:hover {
            background-color: #003366;
        }

        footer {
            background-color: #004a98;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>My Doctor Consultation</h1>
    </header>
    
    <main>
        <section class="locations">
            <h2>Choose a Location</h2>
            <form method="POST">
                <select id="location-select" name="location"> <!-- Added 'name' attribute -->
                    <option value="BHIMAVARAM">BHIMAVARAM</option>
                    <option value="PALAKOLU">PALAKOLU</option>
                    <option value="NARASAPURAM">NARASAPURAM</option>
                    <option value="TADEPILI GUDEM">TADEPILI GUDEM</option>
                    <option value="THANUKU">THANUKU</option>
                </select>
                <input type="submit" value="submit" id="submit-btn" name="submit">
            </form>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2024 Doctor Consultation. All rights reserved.</p>
    </footer>
</body>
</html>
