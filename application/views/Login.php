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
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" placeholder="Enter username" name="user">
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" placeholder="Enter password" name="pwd">
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="remember"> Remember me</label>
    </div>
    <p style="color: red" id="error"></p>
    <input type="button" class="btn btn-primary" value="Login" onclick="new Login();">
    <p></p>
    <a href="#"><p>Forgot your password?</p></a>

    <script>
        console.log("Login script running...");

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

        var token = getCookie('token');

        console.log("The token: " + token);

        if (token.length > 1) {
            new Login();
        }

        var httpStatus = -1;

        /**
         * Created by Mohammad Yazdani on 2017-05-18.
         */


        function Server(address) {
            this.baseAddress = "http://localhost/gatekeeper/index.php/";
            this.address = this.baseAddress + address;
            this.get = function (param) {
                let args = "";
                for (let i = 0; i < param.length; i++) {
                    args += ("/" + param[i]);
                }
                var result = 0;
                $.ajax({
                    type: "GET",
                    url: this.address + args,
                    async: false,
                    success:function(data, args, code){
                        console.log("Callback response: " + data);
                        result = data;
                        httpStatus = code.status;
                    }
                });
                return result;
            };

            this.post = function (param) {
                console.log(param.length);
                let args = "";
                for (let i = 0; i < param.length; i++) {
                    args += ("/" + param[i]);
                }
                var result = 0;
                $.ajax({
                    type: "POST",
                    url: this.address + args,
                    success:function(data, args, code){
                        console.log("Callback response: " + data);
                        httpStatus = code.status;
                    }
                });
            };
        }

        function Login() {
            this.address = "ClientAuth";

            this.username = document.getElementById("username").value;
            this.password = document.getElementById("password").value;
            this.error = document.getElementById("error");

            this.server = new Server(this.address);

            this.login = function () {
                console.log("Login begin..");

                let request;
                request = ["null", this.username, this.password];

                let result = this.server.get(request);
                this.error = result;

                if (httpStatus === 202) {
                    // TODO : FOR TEST
                    console.log("Login successful.");
                    console.log(result);
                    document.cookie = "token=" + result;
                    this.moveToPortal();
                }
                return result;
            };

            this.upDateToken = function (token) {
                return this.server.get([token, null, null]);
            };

            this.moveToPortal = function () {
                window.location.href = "<?php echo site_url('HomeController/ClientPortal'); ?>";
            };

            this.login();
        }
    </script>
</div>
</body>
</html>
