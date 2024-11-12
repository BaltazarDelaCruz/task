<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0) {
    header("Location:./");
    exit;
}
require_once('./DBConnection.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="login.css" rel="stylesheet">
    <title>Login | Task</title>
</head>
<body>
    <div class="container d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">
        <div class="w-100" style="max-width: 500px;">
            <h1>Task Management System</h1>
            <form id="login-form">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="Email">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>
                <button class="btn btn-success w-100" type="submit">Login</button>
            </form>
            <div class="d-flex justify-content-between mt-3">
                <a href="#" class="link">Forgot Password?</a>
               <a href="signup.php" class="btn-signup">Don't have an account?Sign Up</a>
            </div>
        </div>
    </div>
    <script>
    $(function() {
    $('#login-form').submit(function(e) {
        e.preventDefault();
        $('.pop_msg').remove(); // Remove any previous messages
        var _this = $(this);
        var _el = $('<div>'); // Create a new div element for the alert message
        _el.addClass('pop_msg'); // Add a class to the alert element

        // Disable the submit button and update its text
        _this.find('button').attr('disabled', true);
        _this.find('button[type="submit"]').text('Logging in...');

        $.ajax({
            url: './../actions.php?a=login',
            method: 'POST',
            data: _this.serialize(),
            dataType: 'JSON',
            error: err => {
                console.log(err); // Log the error for debugging

                // Set up the error message
                _el.addClass('alert alert-danger');
                _el.html('<a href="#" class="close float-right" data-dismiss="alert">&times;</a>     An error occurred. Please try again.');

                // Prepend the alert to the form and show it
                _this.prepend(_el);
                _el.show('slow');

                // Re-enable the submit button and reset the text
                _this.find('button').attr('disabled', false);
                _this.find('button[type="submit"]').text('Login');
            },
            success: function(resp) {
                if (resp.status === 'success') {
                    _el.addClass('alert alert-success');
                    _el.html('<a href="#" class="close" data-dismiss="alert">&times;</a>' + resp.msg);
                    
                    // Redirect to the home page after a short delay
                    setTimeout(() => {
                        location.replace('./');
                    }, 2000);
                } else {
                    _el.addClass('alert alert-danger');
                    _el.html('<a href="#" class="close" data-dismiss="alert">&times;</a>' + resp.msg);
                }

                // Prepend the alert to the form and show it
                _this.prepend(_el);
                _el.show('slow');

                // Re-enable the submit button and reset the text
                _this.find('button').attr('disabled', false);
                _this.find('button[type="submit"]').text('Login');
            }
        });
    });
});

    </script>
</body>
</html>
