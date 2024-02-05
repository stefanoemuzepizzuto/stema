document.getElementById("loginForm").addEventListener("submit", function (event) {
    var error = 0;

    // Check email
    var err = document.getElementById("emailError");
    var elm = document.getElementById("email");
    if (elm.value == "") {
        err.innerHTML = "Insert email";
        error = error + 1;
    }
    else {
        // Per riportare alla situazione iniziale
        err.innerHTML = "";
    }

    // Check password
    var err = document.getElementById("passError");
    var elm = document.getElementById("pass");
    if (elm.value == "" || (elm.value.length < 8)) {
        err.innerHTML = "Password should have at least 8 characters";
        error = error + 1;
    }
    else {
        // Per riportare alla situazione iniziale
        err.innerHTML = "";
    }

    // Do not send form in case of error
    if (error) {
		event.preventDefault();
	}
	else {
		var succ = document.getElementById("logSucc");
		succ.innerHTML = "Success login";
	}
    
});