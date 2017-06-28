<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 1/27/2017
 * Time: 3:20 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <!-- TODO : INCLUDE BOOTSTRAP AND JQUERY JS, AND BOOTSTRAP CSS -->
    <script src="assets/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/twbs/bootstrap/dist/css/bootstrap.min.css">
    <script src="assets/components/jquery/jquery.min.js"></script>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Welcome</title>
</head>
<body>
<div class="container">
    <h3 class="header">Welcome to OGAM</h3>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <a href="<?php echo site_url('HomeController/Login'); ?>"><input type="button" class="btn btn-block btn-primary" value="Login"></a>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <a href="<?php echo site_url('HomeController/Admin'); ?>"><input type="button" class="btn btn-block btn-primary" value="Admin"></a>
            </div>
        </div>
</div>
<style>
    .row div {
        margin-top: 10px;
    }
</style>
</body>
</html>