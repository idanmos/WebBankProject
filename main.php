<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION["userName"])) {
  Header("Location: index.php");
}

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bank of ITSafe</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bank project for web development for pentesters">
    <meta name="author" content="Idan Moshe">
    <link rel="icon" href="favicon.ico">
    <link rel="canonical" href="http://localhost/bank">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" crossorigin="anonymous"></script>
  </head>

  <body>
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
            <li class="active"><a href="main.php">Dashboard</a></li>
            <li><a href="money_transfer.php">Money Transfer</a></li>
            <li><a href="profile.php">Profile</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
      <div class="row">
        <div class="jumbotron">
          <h1 class="page-header">Dashboard</h1>

          <h2 class="sub-header">Transactions</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>User Name</th>
                  <th>Amount</th>
                  <th>Destination User Name</th>
                  <th>Notes</th>
                </tr>
              </thead>
              <tbody id="transactionHistory">

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <script>
      function logout() {
        $.post("api.php", {"action": "logout"}, function() {
          location.href = "index.php";
        });
      }

        $.post("api.php", {"action": "getTransactions", "userName": <?php echo "'".$_SESSION['userName']."'"; ?>}, function(data) {
            if (data["success"] == true) {
                $("#transactionHistory").html(data["data"]);
            }
        });
    </script>
  </body>
</html>
