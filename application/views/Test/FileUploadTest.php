<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/29/2017
 * Time: 1:34 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html>
<head>
<title>Upload Form TEST</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type = "text/javascript" src = "//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.js"></script>
</head>
<body>

<?php echo form_open_multipart('Test/ClientFiles/index_post');?>

<script>
    var httpStatus;

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
        };

        this.validate = function () {
            console.log("validating");
            let request = [this.get()];
            let result = parseInt(this.server.get(request));
            console.log("Validation result: " + httpStatus);
            return parseInt(httpStatus, 10);
        };
    }

    let tokenHandler = new TokenHandler();
    console.log("Token: " + tokenHandler.get());

</script>

<input type="file" name="file" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>