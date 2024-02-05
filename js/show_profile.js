document.getElementById("showprofileForm").addEventListener("submit", function(event) {
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
	
    // Do not send form in case of error
    if (error) {
        event.preventDefault();
    }
	else {
		succ = document.getElementById("uptSucc");
		succ.innerHTML = "Success change";
	}
});