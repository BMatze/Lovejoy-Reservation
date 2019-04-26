
$('#delteroomFrom').submit(function () {
	var building = $("#room_building").val()
    var number = $("#room_number").val()
    $.ajax({
        method: "POST",
        url: "delete.php",
        data: { building: building, number: number},
        success: function(response) {
            console.log(response)
            if(response == "success"){
                $("#room_building").empty()
                $("#room_building").append("<option value='' disabled selected>Select Building</option><option value='Lovejoy'>Lovejoy Library</option><option value='Engineering'>Engineering Building</option>")
                $("#room_number").empty()
                $("#room_number").append("<option value='' disabled selected>Select Room Number</option>")
                $("#mes").html("<div id='message' class='alert alert-success alertdiv text-center'><strong  id='success'>Successfully deleted room from database!</strong></div>")
                $("#message").fadeOut(5000, "linear")
            }
            else{
                $("#mes").html("<div id='message' class='alert alert-danger alertdiv text-center'><strong  id='success'>Room not deleted!</strong></div>")
                $("#message").fadeOut(5000, "linear")
            }
        }
    })
    return false;
});

$('#room_building').change(function () {
	var building = $("#room_building").val()
    $.ajax({
        method: "POST",
        url: "getnum.php",
        data: { building: building},
        success: function(response) {
            $("#room_number").empty()
            $("#room_number").html(response)
        }
    })
});






