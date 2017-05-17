/**
 * Created by wpan on 5/12/2017.
 */



function validatePassword() {
    var pass1 = document.getElementById("password").value;
    var pass2 = document.getElementById("password_confirm").value;
    if (pass1 != pass2) {
        alert("Passwords Do not match");
        document.getElementById("password").style.borderColor = "#E34234";
        document.getElementById("password_confirm").style.borderColor = "#E34234";
    }
}

function validateEmail() {
    var email = document.getElementById("email").value;
    var email = document.getElementById("email_confirm").value;
    if (email != email) {
        alert("Emails Do not match");
        document.getElementById("email").style.borderColor = "#E34234";
        document.getElementById("email_confirm").style.borderColor = "#E34234";
    }
}