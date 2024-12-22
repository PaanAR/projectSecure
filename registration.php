<?php
error_reporting(E_ALL);
include('includes/dbconnection.php');
require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if (isset($_POST['submit'])) {
  // Retrieve user inputs
  $fullname = $_POST['fullname'];
  $contact = $_POST['contact'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $password = md5($_POST['password']); // Encrypt password using md5
  $type = 3; // Force the type to 3 (Guest)

   // Insert user details into the database
   $sql = "INSERT INTO users (fullname, contact, address, email, password, type) VALUES (:fullname, :contact, :address, :email, :password, :type)";
   $query = $dbh->prepare($sql);
   $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
   $query->bindParam(':contact', $contact, PDO::PARAM_STR);
   $query->bindParam(':address', $address, PDO::PARAM_STR);
   $query->bindParam(':email', $email, PDO::PARAM_STR);
   $query->bindParam(':password', $password, PDO::PARAM_STR);
   $query->bindParam(':type', $type, PDO::PARAM_STR);
   $query->execute();

   // Check if the data was inserted successfully
   $LastInsertId = $dbh->lastInsertId();

   if ($LastInsertId > 0) {
    // Configure PHPMailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->Username = "eazysurvey123@gmail.com";
    $mail->Password = "cqlprqrgtttssphq";

    // Set email details
    $mail->setFrom("eazysurvey123@gmail.com", "EazySurvey | Sales Management System");
    $mail->addAddress($email, $fullname);

    $mail->Subject = "Welcome to EazySurvey's Sales Platform";
    $mail->Body = "Dear $fullname,

Thank you for joining EazySurvey as a guest user. We're excited to have you on board!

Here are your details:
- Full Name: $fullname
- Contact: $contact
- Address: $address
- Email: $email

As a guest, you can explore our sales platform, where we aim to simplify survey management for businesses.

For any questions or support, feel free to reach out to us at eazysurvey123@gmail.com.

Best regards,  
The EazySurvey Sales Team";

    // Send the email
    $mail->send();

    // Display success message and redirect
    echo '<script>alert("Successfully Registered as a Guest. Thank You for joining us.")</script>';
    echo "<script>window.location.href ='login.php'</script>";
} else {
    // Display error message if insertion fails
    echo '<script>alert("Something Went Wrong. Please try again.")</script>';
}
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EazySurvey | Registration</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link rel="icon" href="images/icon.png" type="image/icon type">

    <!-- Fonts -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">

    <!-- JavaScript -->
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/move-top.js"></script>
    <script src="js/easing.js"></script>

    <!-- Smooth Scrolling -->
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();
                $('html,body').animate({ scrollTop: $(this.hash).offset().top }, 900);
            });
        });
    </script>
</head>
<body>

    <!-- Header -->
    <?php include_once('includes/header.php'); ?>

    <!-- Banner -->
    <div class="banner banner5">
        <div class="container">
            <h2>Registration</h2>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="contact">
        <div class="container">
            <div class="contact-info">
                <h3 class="c-text">Participate Here</h3>
            </div>

            <!-- Registration Form -->
            <div class="contact-grids">
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" name="fullname" id="fullname" class="form-control" style="width: 50%;" required>
                    </div>

                    <div class="form-group">
                        <label for="contact">Contact</label>
                        <input type="text" name="contact" id="contact" class="form-control" style="width: 50%;" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="form-control" rows="3" style="width: 50%;" required></textarea>
                    </div>

                    <h3>Login Details</h3>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" style="width: 50%;" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" style="width: 50%;" required>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>

</body>
</html>
