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
            success:function(data){
                console.log("Callback response: " + data);
                result = data;
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
            success:function(data){
                console.log("Callback response: " + data);
            }
        });
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
            this.error.innerHTML = "username already exists!";
            return;
        } else {
            this.error.innerHTML = "";
        }

        if (!this.confirmEmail()) {
            this.error.innerHTML = "Emails don't match!";
            return;
        }
        if (!this.confirmPassword()) {
            this.error.innerHTML = "Passwords don't match!";
            return;
        }
        this.error.innerHTML = "";
        request = [null, this.username, this.email, this.password, null];
        this.server.post(request);
    };

    this.confirmPassword = function () {
        let nonEmpty = (this.password.length !== 0);
        let confirm = (this.password === this.password_repeat);
        return nonEmpty && confirm;
    };

    this.confirmEmail = function () {
        let nonEmpty = (this.email.length !== 0);
        let confirm = (this.email_repeat === this.email_repeat);
        return nonEmpty && confirm;
    };

    this.validateUsername = function () {
        console.log("validating");
        let request = ["check", this.username];
        let result = parseInt(this.server.get(request));
        return result;
    };

    this.signUp();
}

function Login() {
    this.address = "ClientAuth";

    this.username = document.getElementById("username").value;
    this.password = document.getElementById("password").value;
    this.error = document.getElementById("error");

    this.server = new Server(this.address);

    this.login = function () {
        let request;
        request = ["null", this.username, this.password];
        let result = this.server.get(request);
        console.log(result);
        return result;
    };

    this.moveToPortal = function () {

    };
}