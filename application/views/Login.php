<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-20
 * Time: 1:10 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Client Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="scripts/index.js"></script>
</head>

<body>
<div class="container">
    <h2>Client Login</h2>
    <div class="form-group">
        <label for="username">Username or Email Address:</label>
        <input type="text" class="form-control" id="username" placeholder="Enter username or email address" name="user">
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" placeholder="Enter password" name="pwd">
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="remember"> Remember me</label>
    </div>
    <p style="color: red" id="error"></p>
    <input type="button" class="btn btn-primary" value="Login" href="#" onclick="new Login();">
    <p></p>
    <a href="ForgotPassword.html"><p>Forgot your password?</p></a>

    <script>
        console.log("Login script running...");
    </script>
</div>
</body>
</html>
