<?php
include 'db_connection.php';
error_reporting(0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
$user1 = $_GET['hospital_name'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form for <?php echo htmlspecialchars($user1); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #c6d6e6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        
        header {
            background-color: #004a98;
            color: white;
            text-align: center;
            padding: 20px;
        }

        form {

            width: 50%;
            margin-top:5%;
            margin-bottom:5%;
            margin-left:20%;
            
            background-color: #ffffff;
            padding-left: 12%;
            padding-top:5%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        label{
            color:black;
            font-size:20px;
        }
        

        form input[type="text"],
        form input[type="email"],
        form input[type="number"],
        form input[type="date"],
        form textarea,
        form input[type="submit"] {
            width: calc(100% - 30%);
            padding: 10px;
            margin-bottom: 15px;
            border: 3px solid #c6d6e6;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            background:#c6d6e6;
        }

        form input[type="submit"] {
            background-color: #004a98;
            color: white;
            border: none;
            cursor: pointer;
        }

        form input[type="submit"] {
            font-weight: bold;
        }
        .highlight {
    color: green;
    font-weight: bold;}
        
    </style>
</head>
<body>
    <header>
        <h1>Appointment Form for <?php echo "$user1"; ?></h1>
    </header>
    
    <form method="POST">
        
        <label for="name1">Patient Name:</label><br>
        <input type="text" id="name1" name="name1" required><br>
        
        <label for="age">Patient Age:</label><br>
        <input type="number" id="age" name="age" required><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        
        <label for="phone">Phone No:</label><br>
        <input type="number" id="phone" name="phone" required><br>

        <label>Gender:</label><br>
        <input type="radio" id="male" name="gender" value="male">
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="female">
        <label for="female">Female</label><br><br>

        <label for="appointment_date">Preferred Appointment Date:</label><br>
        <input type="date" id="appointment_date" name="appointment_date" required><br>
        
        <label for="message">Address:</label><br>
        <textarea id="address" name="address" rows="4" cols="50"></textarea><br>
        
        <input type="submit" value="Submit" id="submit" name="submit">
    </form>
    <?php
    $time_str = '10:00:00';
    $time_pre=15;
    $time_obj = DateTime::createFromFormat('H:i:s', $time_str);


   
    if (isset($_POST['submit'])) {
        $name1 = $_POST['name1'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $appointment_date = $_POST['appointment_date'];
        $address = $_POST['address'];

        $sql = "INSERT INTO details (hospital_name, name, age, email, phone, gender, appointment_date, address, submission_time) 
                VALUES ('$user1', '$name1', $age, '$email', $phone, '$gender', '$appointment_date', '$address', NOW())";

        if ($conn->query($sql) === TRUE) {
            $last_insert_id = $conn->insert_id;
            $select_sql = "SELECT * FROM details WHERE id = $last_insert_id"; 
            $result = $conn->query($select_sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "Hospital Name: " . $row['hospital_name'] . "<br>";
                echo "Patient Name: " . $row['name'] . "<br>";
                //echo "Email: " . $row['email'] . "<br>";
                echo "Appointment Date: " . $row['appointment_date'] . "<br>";
                $submission= $row['submission_time'];
                $user3= $row['name'];
                $user4= $row['age'];
                $user5= $row['phone'];
                $user6= $row['gender'];
                $user7= $row['address'];
                $user8= $row['appointment_date'];
                $user9= $row['email'];
            } else {
                echo "No data found.";
            }




            $sql_count = "SELECT COUNT(*) AS count FROM details WHERE hospital_name = '$user1' AND appointment_date = '$appointment_date'";
            $result_count = $conn->query($sql_count);

            if ($result_count->num_rows > 0) {
            $row_count = $result_count->fetch_assoc();
            $count = $row_count['count'];
            echo "Your Appointment Number Is : $count<br>";
            $samp = $count - 1;
            $mins = $time_pre * $samp;
            $time_obj = DateTime::createFromFormat('H:i:s', $time_str);
            $subm = date('H:i:s', strtotime($time_str . " +$mins minutes"));
            $subm1 = date('H:i:s', strtotime($submission . " +60 minutes"));

            $aptime = ''; // Initialize aptime variable
            if ($count <= 5) {
                $aptime = $subm;
                }
            elseif ($subm > $submission) {
            $aptime = $subm;
            } else {
             $aptime = $subm1;
            }

            echo "Your Appointment Time: $aptime <br>";
           

            $sql5 = "SELECT * FROM location where hospital_name ='$user1'";
            $result5 = $conn->query($sql5);
        
            if ($result5->num_rows > 0) {
                // Output data of each row
                $row5 = $result5->fetch_assoc();
                
                    $send_to1 = $row5["email"];
                    $add=$row5["address"];
            }
        try {
            // Recipient 1
            $mail1 = new PHPMailer(true); // Passing `true` enables exceptions
            $mail1->isSMTP(); 
            $mail1->Host       = 'smtp.gmail.com'; 
            $mail1->SMTPAuth   = true; 
            $mail1->Username   = '20093cm010@gmail.com'; 
            $mail1->Password   = 'fisl wkqx aanw dvjp'; 
            $mail1->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail1->Port       = 587; 
            $mail1->setFrom('20093cm010@gmail.com', 'MY DOCTOR CONSULTATION');
            $mail1->addAddress($send_to1);
            $mail1->isHTML(true); 
            $mail1->Subject = 'Patient Details'; 
            $mail1->Body = '<html><body><h3>Patient Name:</h3></body></html>'.$user3.'<html><body><h3>Patient Email:</h3></body></html>'.$user9.'<html><body><h3>Patient Contact:</h3></body></html>'.$user5.'<html><body><h3>Age:</h3></body></html>'.$user4.'<html><body><h3>Gender</h3></body></html>'.$user6.'<html><body><h3>Location</h3></body></html>'.$user7.'<html><body><h3>Appointment Date In Your Hospital:</h3></body></html>'.$user8.'<html><body><h3>Appointment Time:</h3></body></html>'.$aptime;
        
            // Recipient 2
            $mail2 = new PHPMailer(true); 
            $mail2->isSMTP(); 
            $mail2->Host       = 'smtp.gmail.com'; 
            $mail2->SMTPAuth   = true; 
            $mail2->Username   = '20093cm010@gmail.com'; 
            $mail2->Password   = 'fisl wkqx aanw dvjp'; 
            $mail2->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail2->Port       = 587; 
            $mail2->setFrom('20093cm010@gmail.com', 'MY DOCTOR CONSULTATION');
            $mail2->addAddress($user9);
            $mail2->isHTML(true); 
            $mail2->Subject = 'YOUR APPOINTMENT IS FIXED'; 
            $mail2->Body = '<html><body><h3>Dear Patient:</h3></body></html>'.$user3.'<html><body><h3>You Have Appiontment in:</h3></body></html>'.$user1.'<html><body><h3>Your Appiontment No:</h3></body></html>'.$count.'<html><body><h3>On:</h3></body></html>'.$user8.'<html><body><h3>At</h3></body></html>'.$aptime.'<html><body><h3>Location:</h3></body></html>'.$add;
        
            // Sending emails
            $mail1->send(); 
            $mail2->send(); 
            echo 'Emails sent successfully!';
        } catch (Exception $e) {
            echo "Failed to send emails. Error: {$e->getMessage()}";
        }








            } else {
            echo "No rows found for the hospital: $user1 and appointment date: $appointment_date";
            }
        } else {
            echo "Error inserting form data: " . $conn->error;
        }
    }
    ?>
</body>
</html>




