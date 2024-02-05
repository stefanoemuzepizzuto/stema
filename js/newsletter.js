document.getElementById("newsletterForm").addEventListener("submit", function (event) {
    var error = 0;

    // Check subject
    var err = document.getElementById("subjectError");
	var elm = document.getElementById("subject");
    if (elm.value == "") {
        err.innerHTML = "Insert subject email";
        error = error + 1;
    }
    else {
        // Per riportare alla situazione iniziale
        err.innerHTML = "";
    }

    // Check text
    var err = document.getElementById("textError");
	var elm = document.getElementById("newsletter");
    if (elm.value == "") {
        err.innerHTML = "Insert text email";
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
		var succ = document.getElementById("sendSuccess");
		succ.innerHTML = "Success send";
	}

    
});