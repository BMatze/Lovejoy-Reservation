function showRoomNum(str) {
	var value = str.options[ str.selectedIndex ].value;
    if (value == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("room_number").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getRoomNum.php?q="+value,true);
        xmlhttp.send();
    }
}