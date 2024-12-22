<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login | Online Sales System</title>
  
  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="css/style.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
  <!-- Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  
  <style>
    body {
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-image: url('images/background_login.jpg');
        background-size: cover;
        background-position: center;
        font-family: 'Open Sans', sans-serif;
		margin: 0;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.9);
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: 400px;
    }

    .login-container .logo img {
        display: block;
        margin: 0 auto 20px;
        width: 120px;
    }

    .login-container h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #333;
    }

    .login-container .form-group label {
        font-weight: 600;
        color: #555;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        font-weight: 600;
        text-transform: uppercase;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .auth-link {
        display: block;
        text-align: center;
        margin-top: 10px;
        font-size: 0.9rem;
        color: #007bff;
        text-decoration: none;
    }

    .auth-link:hover {
        text-decoration: underline;
    }

    .alert-danger {
        margin-bottom: 15px;
    }
  </style>

  <?php 
    if(isset($_SESSION['login_id'])) 
        header("location:index.php?page=home");
  ?>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <a href="index.php"><img src="images/login.jpg" alt="Online Sales System Logo"></a>
        </div>
        <h2>Login</h2>
        <form id="login-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Login</button>
            <a href="forgot-password.php" class="auth-link">Forgot password?</a>
        </form>
    </div>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.js"></script>

    <script>
        $('#login-form').submit(function(e) {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true).html('Logging in...');
    if ($(this).find('.alert-danger').length > 0) 
        $(this).find('.alert-danger').remove();
    $.ajax({
        url: 'ajax.php?action=login',
        method: 'POST',
        data: $(this).serialize(),
        error: err => {
            console.log("AJAX Error:", err);
            $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
        },
        success: function(resp) {
            console.log("Server Response:", resp); // Debug response from the server
            if (resp == 1) {
                location.href = 'index.php?page=home';
            } else {
                $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
                $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
            }
        }
    })
	
})
$('.number').on('input',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9 \,]/, '');
        $(this).val(val)
    });

    </script>
</body>
</html>
