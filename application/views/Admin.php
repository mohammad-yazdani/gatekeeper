<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-20
 * Time: 1:14 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Admin Portal</h2>
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
            <a href="#"><input type="button" class="btn btn-block btn-primary" value="Upload Files"></a>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <a href="#"><input type="button" class="btn btn-block btn-primary" value="Download Files"></a>
        </div>
    </div>
    <p></p>
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
            <a href="Register.html"><input type="button" class="btn btn-block btn-primary" value="Register New Client"></a>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <a href="#"><input type="button" class="btn btn-block btn-primary" value="Assign Permissions"></a>
        </div>
    </div>
</div>
</body>
</html>
</html>
