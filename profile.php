<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["userName"])) {
    session_destroy();
    die(Header("Location: index.php"));
}

$userName = (isset($_SESSION["userName"])) ? $_SESSION["userName"] : '';

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
                        <li><a href="money_transfer.php">Money Transfer</a></li>
                        <li class="active"><a href="profile.php">Profile</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <br><br><br>
            <div class="col-md-4 col-md-offset-4" style="background-color: white; border-radius: 10px;">
                <h3 style="text-align: center;">Profile Update</h3>                    
                <div class="input-group">
                        <span class="input-group-addon">@</span>
                        <input id="userName" type="text" class="form-control" placeholder="User Name" value='<?php echo $userName ?>' disabled>
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="fullName" type="text" class="form-control" placeholder="Full Name">
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input id="email" type="text" class="form-control" placeholder="Email">
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input id="address" type="text" class="form-control" placeholder="Address">
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                        <input id="phoneNumber" type="text" class="form-control" placeholder="Phone Number">
                    </div>
                    <br/><button id="saveButton" type="button" class="btn btn-primary">Save</button><br/><br/>
                </div>
            </div>
        <script>
            function logout() {
                $.post("api.php", {"action": "logout"}, function() {
                    location.href = "index.php";
                });
            }

            $("#saveButton").click(function() {
                var $userName = '<?php echo $userName ?>';
                var $fullName = $("#fullName").val() != '' ? $("#fullName").val() : "NULL";
                var $address = $("#address").val() != '' ? $("#address").val() : "NULL";
                var $phoneNumber = $("#phoneNumber").val() != '' ? $("#phoneNumber").val() : "NULL";
                var $email = $("#email").val() != '' ? $("#email").val() : "NULL";

                var $postData = {
                    "action": "updateProfile",
                    "userName": $userName,
                    "address": $address,
                    "phoneNumber": $phoneNumber,
                    "email": $email,
                    "fullName": $fullName
                };
                
                $.post("api.php", $postData, function(data) {
                    if (data["success"] == true) {
                        location.reload();
                    }
                });
            });

            $(document).ready(function() {
                var $userName = '<?php echo $userName ?>';
                
                var $postData = {
                    "action": "getProfile", 
                    "userName": $userName
                };

                $.post("api.php", $postData, function(data) {                    
                    if (data["success"] == true && data["data"]) {
                        var $profileData = data["data"];

                        if ($profileData["fullName"] && $profileData["fullName"] != 'NULL') {
                            $("#fullName").val($profileData["fullName"]);
                        }

                        if ($profileData["email"] && $profileData["email"] != 'NULL') {
                            $("#email").val($profileData["email"]);
                        }

                        if ($profileData["address"] && $profileData["address"] != 'NULL') {
                            $("#address").val($profileData["address"]);
                        }
                        
                        if ($profileData["phoneNumber"] && $profileData["phoneNumber"] != 'NULL') {
                            $("#phoneNumber").val($profileData["phoneNumber"]);
                        }
                    }
                });
            });
        </script>
    </body>
</html>