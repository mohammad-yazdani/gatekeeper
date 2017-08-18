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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<!-- TODO : TEMP
    <div class="container">
        <h2>Client Portal</h2>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <a href="#"><input type="button" class="btn btn-block btn-primary" value="Download Files"></a>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <a href="<?php echo site_url('HomeController/UploadUtility'); ?>"><input
                            type="button" class="btn btn-block btn-info" value="Upload Files"></a>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <button class="btn btn-primary" onclick="tokenHandler.go_to_angular();" ><input
                            type="button" class="btn btn-block btn-info" value="Apps"></button>
            </div>
        </div>
        <p></p>
        <a onclick="tokenHandler.erase();" href="<?php echo site_url('HomeController/Login'); ?>"><p>Sign out</p></a>
    </div>
-->
<script>
    console.log("Client portal script running...");
    var user = window.localStorage.getItem('user');
    console.log("User: "  + user);

    var httpStatus;

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

    function TokenHandler() {

        this.cname = 'token';
        this.address = "DeviceAuth";
        this.server = new Server(this.address);

        this.get = function() {
            let name = this.cname + "=";
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
        };

        this.erase = function() {
            let name = this.cname;
            console.log('Deleting token...');
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/;";
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;";
            console.log("Cookies after delete: " + document.cookie);
            window.localStorage.clear();
        };

        this.validate = function () {
            console.log("validating");
            let request = [this.get()];
            let result = parseInt(this.server.get(request));
            console.log("Validation result: " + httpStatus);
            return parseInt(httpStatus, 10);
        };

        this.go_to_angular = function () {
            // TODO : FOR NOW
            let app_url = "http://192.168.68.145:9000?token=" + this.get() + "&user=" + user;
            console.log("App url: " + app_url);
            window.location.href = app_url;
        }
    }

    // TODO : Validate if session is not expired
    let tokenHandler = new TokenHandler();
    console.log("Present token: " + tokenHandler.get());
    if (tokenHandler.validate() === 202) {
        console.log("Valid session.");
    } else {
        console.log("Invalid session.");
        tokenHandler.erase();
        window.location.href = "<?php echo site_url('HomeController/Login'); ?>";
    }

    tokenHandler.go_to_angular();
</script>
</body>
</html>