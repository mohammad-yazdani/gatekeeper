<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 6/28/2017
 * Time: 9:41 AM
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
    <div class="jumbotron">
        <div class="loading-header">
            <h>Loading...</h>
        </div>
        <br/>
        <div class="loader"></div>
    </div>
</div>
<style>
    .application-button {
        margin-top: 20px;
        background-color: darkgrey;
        border: none;
        font-weight: 300;
    }

    .loader {
        margin-left: auto;
        margin-right: auto;
        border: 16px solid darkgrey; /* Light grey */
        border-top: 16px solid grey; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .loading-header {
        font-family: "Segoe UI";
        font-weight: 300;
        font-size: 22px;
        color: black;
        margin-left: auto;
        m
</style>
</body>
</html>
