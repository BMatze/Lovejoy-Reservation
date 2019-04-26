function myFunction() {
    window.print();
}

function dailyDate(){
	var d = new Date();
	document.getElementById("dailyDate").innerHTML = d.toDateString();
}

$(document).ready(function() {
	  dailyDate();
	});