<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/23/2017
 * Time: 10:10 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Register New Client Account</h2>
    <div>
        <div class="row">
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label for="Email">Email Address:</label>
                <input class="form-control" id="email" name="email" type="email" placeholder="Enter email address" required>
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label for="Email_confirm">Confirm Email Address:</label>
                <input class="form-control" id="email_confirm" name="email_confirm" type="email" placeholder="Re-enter email address" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label for="username">Username:</label>
                <input class="form-control" id="username" name="username" type="text" placeholder="Enter username" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label for="password">Password:</label>
                <input class="form-control" id="password" name="password" type="password" placeholder="Enter password" required>
            </div>
            <div class="form-group col-sm-6 col-md-6 col-lg-6">
                <label for="Email_confirm">Confirm Password:</label>
                <input class="form-control" id="password_confirm" name="password_confirm" type="password" placeholder="Re-enter password" required>
            </div>
        </div>
        <p style="color: red" id="error"></p>
        <a href="#"><input value="Register" type="button" class="btn btn-info" id="sign_up_button" onclick="new Register();"></a>
        <p></p>
        <a href="<?php echo site_url('HomeController/Admin'); ?>"><p>Return to admin portal</p></a>
    </div>
</div>
<script>
    /**
     * Created by Mohammad Yazdani on 2017-05-18.
     */

    console.log("Register script running...");

    console.log("The cookie: " + document.cookie);

    var httpStatus = -1;

    function Server(address) {
        this.baseAddress = "http://192.168.68.145/gatekeeper/index.php/";
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
                async: false,
                success:function(data, args, code){
                    console.log("Callback response: " + data.indexOf("flush done"));
                    result = data;
                    httpStatus = code.status;
                }
            });
            return result;
        };
    }

    function Register() {
        this.address = "ClientAuth";

        this.username = document.getElementById("username").value;
        this.email = document.getElementById("email").value;
        this.email_repeat = document.getElementById("email_confirm").value;
        this.password = document.getElementById("password").value;
        this.password_repeat = document.getElementById("password_confirm").value;
        this.error = document.getElementById("error");

        this.server = new Server(this.address);

        this.signUp = function () {
            let request;

            if (this.validateUsername() === 0) {
                this.error.innerHTML = "This username is taken!";
                return;
            }

            if (!this.confirmEmail()) {
                this.error.innerHTML = "Emails don't match!";
                return;
            }

            if (!this.confirmPassword()) {
                this.error.innerHTML = "Passwords don't match!";
                return;
            }

            if (!this.nonEmptyField()) {
                this.error.innerHTML = "Fields should not be empty!";
                return;
            }

            this.error.innerHTML = "";
            request = [null, this.username, this.email, this.password, null];
            let result = this.server.post(request);
            return result;
        };

        this.confirmPassword = function () {
            return (this.password === this.password_repeat);
        };

        this.confirmEmail = function () {
            return (this.email === this.email_repeat);
        };

        this.nonEmptyField = function () {
            return (this.email.length !== 0 && this.password.length !== 0);
        };

        this.validateUsername = function () {
            console.log("validating");
            let request = ["check", this.username];
            let result = parseInt(this.server.get(request));
            return result;
        };

        this.upDateToken = function (token) {
            return this.server.get([token, null, null]);
        };

        console.log("Registering...");
        let result = this.signUp();
        console.log("Registering finished!");
        if (!result) console.log("Register failed!");
        else {
            console.log("Server response: " + result);
            // TODO : Store JWT
            console.log("Saving: " + "token=" + result + "; " + (new Date(Date.now() + 18000000)) + "; path=/;");
            document.cookie = "token=" + result + "; path=/;";
            console.log("The cookie: " + document.cookie);
            console.log("Back to server: " + this.upDateToken(result));
            console.log("Status: " + httpStatus);
            if (parseInt(httpStatus, 10) === 202) window.location.href = "<?php echo site_url('HomeController/ClientPortal'); ?>";
        }
    }
</script>
</body>
</html>
