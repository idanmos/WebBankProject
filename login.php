<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["userName"])) {
    Header("Location: main.php");
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
    <body style="background-color: #ecedf0; width: 100%;">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
              <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Bank of ITSafe</a>
              </div>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                <li class="active"><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
              </ul>
            </div>
        </nav>

        <div id="loginDiv" class="col-md-4 col-md-offset-4" style="background-color: white; border-radius: 10px;">
            <h3 style="text-align: center;">Login</h3>
            <div id ="alertDiv" class="alert alert-danger" role="alert" hidden>
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                <span id="errorMessage"></span>
            </div>
            <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    <input id="userName" type="text" class="form-control" name="userName" placeholder="User Name">
                </div>
                <br />
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <br />
                <div class="text-center">
                    <button id="sendButton" class="btn btn-primary">Login</button>
                </div>
            <br />
        </div>
        <script>
            $("#sendButton").click(function() {
                $("#alertDiv").hide();

                if (!$("#userName").val()) {
                    $("#errorMessage").text("User name cannot be empty!");
                    $("#alertDiv").show();
                    return;
                }

                if (!$("#password").val()) {
                    $("#errorMessage").text("Password cannot be empty!");
                    $("#alertDiv").show();
                    return;
                }

                var $postData = {
                    "action": "login",
                    "userName": $("#userName").val(),
                    "password": $("#password").val()
                };

                $.post("api.php", $postData, function(data) {
                    if (data["success"] == true) {
                        $.post("api.php", {"action": "getUserId", "userName": $("#userName").val()}, function(userId) {
                            if (userId["success"] == true) {
                                // success
                            }
                            location.href = "main.php";
                        });
                    }
                });
            });
        </script>
    </body>
</html>