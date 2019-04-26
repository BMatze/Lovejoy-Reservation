
$(document).ready(function() {
    
$('#res_date').change(function(){
    var date = $(this).val()
    var building = $('#res_building').val()
    var num = $('#res_num').val()
    $("#res_end").empty()
    $("#res_end").append("<option value='' disabled selected>Select End Time</option>")
    $.ajax({
        method: "POST",
        url: "availStartTimes.php",
        data: { date: date, build: building, rnum: num} ,
        success: function(response) {
            response = JSON.parse(response)
            $("#res_start").empty()
            $("#res_start").append("<option value='' disabled selected>Select Start Time</option>")
            for(i = 0; i < response.length; i++){
                $("#res_start").append(response[i])
            }
        }
    })
})

$('#res_start').change(function(){
    var time = $('#res_start').val()
    var date = $('#res_date').val()
    var building = $('#res_building').val()
    var num = $('#res_num').val()
    //console.log(time)
    $.ajax({
        method: "POST",
        url: "availEndTimes.php",
        data: { t: time, date: date, build: building, rnum: num},
        success: function(response) {
            //console.log(response)
            response = JSON.parse(response)
            $("#res_end").empty()
            $("#res_end").append("<option value='' disabled selected>Select End Time</option>")
            for(i = 0; i < response.length; i++){
                $("#res_end").append(response[i])
            }
        }
    })
})

$('#res_building').change(function(){
    var building = $('#res_building').val()
    $("#res_desc").empty()
    //console.log(building)
    $.ajax({
        method: "POST",
        url: "genRooms.php",
        data: { b: building},
        success: function(response) {
            //console.log(response)
            response = JSON.parse(response)
            $("#res_num").empty()
            $("#res_num").append("<option value='' disabled selected>Select Room Number</option>")
            for(i = 0; i < response.length; i++){
                $("#res_num").append(response[i])
            }
        }
    })
})

$('#res_num').change(function(){
    var building = $('#res_building').val()
    var num = $('#res_num').val()
    $.ajax({
        method: "POST",
        url: "genDesc.php",
        data: { bdesc: building, n: num},
        success: function(response) {
            //console.log(response)
            $("#res_desc").empty()
            $("#res_desc").html(response)
        }
    })
})

$("form").submit(function(){
    var time = $('#res_start').val()
    var date = $('#res_date').val()
    var building = $('#res_building').val()
    var num = $('#res_num').val()
    var eid = $('#res_id').val()
    var end = $('#res_end').val()
    $.ajax({
        method: "POST",
        url: "addRes.php",
        data: { t: time, d: date, b: building, n: num, e: eid, end: end},
        success: function(response) {
            if(response == "success"){
                $("#mes").html("<div id='message' class='alert alert-success alertdiv text-center'><strong  id='success'>Reservation added!</strong></div>")
                $("#message").fadeOut(5000, "linear")
            }
            else if(response == "failed"){
                $("#mes").html("<div id='message' class='alert alert-danger alertdiv text-center'><strong  id='success'>Failed to add reservation!</strong></div>")
                $("#message").fadeOut(5000, "linear")
            }
            else if(response == "already reserved"){
                $("#mes").html("<div id='message' class='alert alert-warning alertdiv text-center'><strong  id='success'>Already has reservation for the day!</strong></div>")
                $("#message").fadeOut(5000, "linear")
            }
            $('#res_building').empty()
            $('#res_building').append("<option value='' disabled selected>Select Building</option><option>Lovejoy</option><option>Engineering</option>")
            $("#res_date").datepicker('setDate', null);
            $("#res_date").val("Select Date")
            $("#res_start").empty()
            $("#res_start").append("<option value='' disabled selected>Select Start Time</option>")
            $("#res_end").empty()
            $("#res_end").append("<option value='' disabled selected>Select End Time</option>")
            $('#res_id').empty()
            $('#res_id').val("")
            $("#res_num").empty()
            $("#res_num").append("<option value='' disabled selected>Select Room Number</option>")
            $("#res_desc").empty()
        }    
    })
    return false;
});


	 
});