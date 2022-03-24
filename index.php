<?php

  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }

  if(isset($_SESSION["userName"])) {
      Header("Location: ./main.php");
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
    <nav class="navbar navbar-inverse">
            <div class="container-fluid">
              <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Bank of ITSafe</a>
              </div>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
              </ul>
            </div>
        </nav>
        <br><br><br>
        <div class="container">
          <div class="starter-template">
            <h1>Online Banking</h1>
            <p class="lead">What would you like the power to do?<br>For you and your family, your business and your community.<br>At Bank of ITSafe, our purpose is to help make financial lives better<br>through the power of every connection.</p>
          </div>
        </div>
  </body>
</html>
