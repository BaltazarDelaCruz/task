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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="login.css" rel="stylesheet">
    <title>Sign Up | Task Management System</title>
</head>
<body>
    <div class="container d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">
        <div class="w-100" style="max-width: 500px;">
            <h1>Sign Up</h1>
            <form id="signup-form">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingName" placeholder="Full Name" required>
                    <label for="floatingFirstName">First Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingName" placeholder="Full Name" required>
                    <label for="floatingLastName">Last Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingEmail" placeholder="Email" required>
                    <label for="floatingEmail">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>
                <button class="btn btn-success w-100" type="submit">Sign Up</button>
            </form>
            <div class="d-flex justify-content-center mt-3">
                <a href="login.php" class="link">Already have an account? Login</a>
            </div>
        </div>
    </div>
    <script>
    $(function signup() {
        $('#signup-form').submit(function(e) {
            e.preventDefault();
            $('.pop_msg').remove(); 
            var _this = $(this);
            var _el = $('<div>');
            _el.addClass('pop_msg'); 

            
            _this.find('button').attr('disabled', true);
            _this.find('button[type="submit"]').text('Signing up...');

            $.ajax({
                url: './../actions.php?a=signup',
                method: 'POST',
                data: {
                    first_name: $('#floatingFirstName').val(),
                    last_name: $('#floatingLastName').val(),
                    email: $('#floatingEmail').val(),
                    password: $('#floatingPassword').val()
                },
                dataType: 'JSON',
                error: err => {
                    console.log(err); 

                    
                    _el.addClass('alert alert-danger');
                    _el.html('<a href="#" class="close" data-dismiss="alert">&times;</a> An error occurred. Please try again.');

                    
                    _this.prepend(_el);
                    _el.hide().fadeIn('slow');

                   
                    _this.find('button').attr('disabled', false);
                    _this.find('button[type="submit"]').text('Sign Up');
                },
                success: function(resp) {
                    if (resp.status === 'success') {
                        _el.addClass('alert alert-success');
                        _el.html('<a href="#" class="close" data-dismiss="alert">&times;</a>' + resp.msg);
                        
                      y
                        setTimeout(() => {
                            location.replace('login.php');
                        }, 2000);
                    } else {
                        _el.addClass('alert alert-danger');
                        _el.html('<a href="#" class="close" data-dismiss="alert">&times;</a>' + resp.msg);
                    }

                  
                    _this.prepend(_el);
                    _el.show('slow');

                
                    _this.find('button').attr('disabled', false);
                    _this.find('button[type="submit"]').text('Sign Up');
                }
            });
        });
    });
    </script>
</body>
</html>
