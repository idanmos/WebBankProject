<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["userName"])) {
    header("Location: ./main.php");
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <title>Bank of ITSafe</title>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body class="text-center" style="background-color: #ecedf0; width: 100%;">
        <div>
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                  <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">Bank of ITSafe</a>
                  </div>
                  <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="register.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                    <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                  </ul>
                </div>
            </nav>
            
            <div class="col-md-4 col-md-offset-4" style="background-color: white; border-radius: 10px;">
                <h3 style="text-align: center;">Join us!</h3>

                <div id ="alertDiv" class="alert alert-danger text-left" role="alert" hidden>
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    <span id="errorMessage"></span>
                </div>
                <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="userName" type="text" class="form-control" name="userName" placeholder="User Name">
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                        
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password2" type="password" class="form-control" name="password2" placeholder="Password Again">
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input id="address" type="text" class="form-control" name="address" placeholder="Address">
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                        <input id="phoneNumber" type="text" class="form-control" name="phoneNumber" placeholder="Phone Number">
                    </div>
                    <br />
                    <button id="sendButton" class="btn btn-primary">Register</button><br /><br/>
            </div><br/>
        </div><br/>
        <script>
            function showErrorMessage(errorMessage) {
                $("#errorMessage").text(errorMessage);
                $("#alertDiv").show();
            }

            function validate() {
                $("#alertDiv").hide();

                if (!$("#userName").val()) {
                    showErrorMessage("User name cannot be empty!");
                    return false;
                }

                if (!$("#password").val() || !$("#password2").val()) {
                    showErrorMessage("Passwords cannot be empty!");
                    return false;
                }

                if ($("#password").val() != $("#password2").val()) {
                    showErrorMessage("Passwords must be equal!");
                    return false;
                }

                return true;
            }

            $("#sendButton").click(function() {
                if (!validate()) { return; }

                var $address = $("#address").val() != '' ? $("#address") : "NULL";
                var $phoneNumber = $("#phoneNumber").val() != '' ? $("#phoneNumber") : "NULL";

                var $postData = {
                    "action": "register",
                    "userName": $("#userName").val(),
                    "password": $("#password").val(),
                    "address": $address,
                    "phoneNumber": $phoneNumber
                };

                $.post("api.php", $postData, function(data) {
                    if (data["success"] == true) {
                        alert("You have successfully registered!");

                        $.post("api.php", {"action": "getUserId", "userName": $("#userName").val()}, function(userId) {
                            if (userId["success"] == true) {
                                // success
                            }
                            location.href = "main.php";
                        });
                    } else {
                        showErrorMessage("An unexpected error occurred. Please try again later.");
                    }
                });
            });
        </script>
    </body>
</html>