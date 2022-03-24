<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["userName"])) {
    session_destroy();
    die(Header("Location: index.php"));
}

?>

<!doctype html>
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
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Bank of ITSafe</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
                <li><a id="logout" href="#" onclick="logout();"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
              </ul>
          <ul class="nav navbar-nav navbar-left">
            <li><a href="main.php">Dashboard</a></li>
            <li class="active"><a href="money_transfer.php">Money Transfer</a></li>
            <li><a href="profile.php">Profile</a></li>
          </ul>
        </div>
      </div>
    </nav>
        <br><br><br>
        <div class="col-md-4 col-md-offset-4" style="background-color: white; border-radius: 10px;">
            <h3 style="text-align: center;">Transfer Details</h3>
            <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="destinationUserName" type="text" class="form-control" name="destinationUserName" placeholder="Destination user name">
                </div>
                <br />
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                    <input id="amount" type="text" class="form-control" name="amount" placeholder="Amount">
                </div>
                <br />
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                    <input id="notes" type="text" class="form-control" name="notes" placeholder="Notes">
                </div><br /><div class="text-center">
                <button name="moneyTransferButton" id="moneyTransferButton" type="button" class="btn btn-primary">Transfer</button></div><br/>
        </div>
        <script>
            function logout() {
                $.post("api.php", {"action": "logout"}, function() {
                    location.href = "index.php";
                });
            }

        $("#logoutButton").click(function() {
            $.post("api.php", {"action": "logout"}, function() {
                location.href = "index.php";
            });
        });

        $("#moneyTransferButton").click(function() {
            var $postData = {
                "action": "moneyTransfer", 
                "userName": <?php echo "'".$_SESSION["userName"]."'"; ?>, 
                "destinationUserName": $("#destinationUserName").val(),
                "amount": $("#amount").val(), 
                "notes": $("#notes").val()
            };

            $.post("api.php", $postData, function(data) {
                if (data["success"] == true) {
                    alert("Money transferred successfully!");
                    location.href = "main.php";
                } else {
                    alert("Error transferring money!");
                }
            });
        });
    </script>
    </body>
</html>