function messageError() {
	document.getElementById("success").innerHTML = "Room already exists!";
	document.getElementById("message").style.visibility = "visible";
	document.getElementById("message").className = "alert alert-danger alertdiv text-center";
}

function messageSuccess() {
	document.getElementById("success").innerHTML = "Successfully added room to database!";
	document.getElementById("message").style.visibility = "visible";
	document.getElementById("message").className = "alert alert-success alertdiv text-center";
}
  