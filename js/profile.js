document.getElementById("profileForm").addEventListener("submit", function(event) {
    var error = 0;
	
    // Check Bio
    var err = document.getElementById("bioError");
    var elm = document.getElementById("bio");
    if(elm.value == ""){
        err.innerHTML = "Insert bio";
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
		var succ = document.getElementById("bioSucc");
		succ.innerHTML = "Success change";
	}

});