document.getElementById("signupForm").addEventListener("submit", function(event) {
    var error = 0;
	
    // Check Firstname
    var err = document.getElementById("firstnameError");
    var elm = document.getElementById("firstname");
    if(elm.value == ""){
        err.innerHTML = "Insert firstname";
        error = error + 1;
    }
    else {
        // Per riportare alla situazione iniziale
        err.innerHTML = "";
    }
	
    // Check Lastname
    err = document.getElementById("lastnameError");
    elm = document.getElementById("lastname");
    if(elm.value == ""){
        err.innerHTML = "Insert lastname";
        error = error + 1;
    }
    else {
        // Per riportare alla situazione iniziale
        err.innerHTML = "";
    }
	
    // Check Email
    err = document.getElementById("emailError");
    elm = document.getElementById("email");
    if(elm.value == ""){
        err.innerHTML = "Insert email";
        error = error + 1;
    }
    else {
        // Per riportare alla situazione iniziale
        err.innerHTML = "";
    }
	
    // Check Password
    err = document.getElementById("passwordError");
    elm = document.getElementById("pass");
    if(elm.value.length < 8){
        err.innerHTML = "Insert at least 8 characters";
        error = error + 1;
    }
    else {
        // Per riportare alla situazione iniziale
        err.innerHTML = "";
    }
	
    // Check Confirm
    err = document.getElementById("confirmError");
    elm = document.getElementById("confirm");
    if(elm.value != document.getElementById("pass").value){
        err.innerHTML = "Passwords do not match";
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
		var succ = document.getElementById("regSucc");
		succ.innerHTML = "Success registration";	
	}
});