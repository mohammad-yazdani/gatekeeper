<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/23/2017
 * Time: 12:17 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Client Portal</h2>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <a href="#"><input type="button" class="btn btn-block btn-primary" value="View Files"></a>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <a href="#"><input type="button" class="btn btn-block btn-info" value="Download Files"></a>
            </div>
        </div>
        <p></p>
        <a onclick="delete_cookie('token');" href="<?php echo site_url('HomeController/Login'); ?>"><p>Sign out</p></a>
    </div>
<script>
    console.log("Client portal script running...");

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function delete_cookie( name ) {
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }
    var token = getCookie('token');

    console.log("The token: " + token);
</script>
</body>
</html>