$(document).ready(function() {
    
$('#res_date').change(function(){
    var date = $(this).val()
    var building = $('#res_building').val()
    var num = $('#res_num').val()
    $("#res_end").empty()
    $("#res_end").append("<option value='' disabled selected>Select End Time</option>")
    $.ajax({
        method: "POST",
        url: "availStartTimesStudent.php",
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
        url: "availEndTimesStudent.php",
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
        url: "genRoomsStudent.php",
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
        url: "genDescStudent.php",
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
        url: "addResStudent.php",
        data: { t: time, d: date, b: building, n: num, e: eid, end: end},
        success: function(response) {
            console.log(response)
        }    
    })
    return false;
});

});