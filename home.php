<?php
    include 'db_connection.php';
    error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Consultation</title>
    <link rel="stylesheet" href="homep.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .image-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 50px;
            animation: fadeIn 1s ease;
        }

        .image-item {
            margin: 10px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .image-item:hover {
            transform: translateY(-5px);
        }

        .image-item img {
            width: 300px; /* Adjust as needed */
            height: 300px; /* Adjust as needed */
            border-radius: 10px 10px 0 0;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .image-item:hover img {
            transform: scale(1.1);
        }

        .hospital-name {
            text-align: center;
            margin-top: 5px;
            font-weight: bold;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>MY Doctor Consultation</h1>
    </header>
    
    <nav>
        <ul>
            <li><a href="about.html">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="http://localhost:5000">predict</a></li>
        </ul>
    </nav>
    
    <main>
      
    <?php
    session_start();


    if(isset($_SESSION['selectedLocation'])) {

        $session_name = $_SESSION['selectedLocation'];
        $sql = "SELECT * FROM location WHERE locations= '$session_name'";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            echo '<div class="image-container">';
            while($row = $result->fetch_assoc()) {
                echo '<div class="image-item">';
                echo "<a href='form.php?hospital_name=" . urlencode($row['hospital_name']) . "'>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($row["image"]) . "' alt='Image'>";
                echo '</a>';
                echo '<div class="hospital-name">' . $row['hospital_name'] . '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo "No images found.";
        }

        $conn->close();
    } else {
        echo "Session name not set.";
    }
    ?>

    </main>
    
    <footer>
        <p>&copy; 2024 Doctor Consultation. All rights reserved.</p>
    </footer>
    
    <script src="script.js"></script>
</body>
</html>
