$( document ).ready(function() {
    $('#formMod').hide();
});

window.id = null

$('#formtest').submit(function () {
    var rb = $("#room_building").val(); 
    var rn = $("#room_number").val();

    $.ajax({
      method: "POST",
      url: "getRoomInfo.php",
      data: { building: rb, number: rn } ,
      success: function(response) {
        $('#formtest').hide();
        $('#formMod').show();
        response = JSON.parse(response)
        $("#current_building").text(response[0])
        $("#rm_num").attr('value',response[1])
        $("#current_number").text(response[2])
        $("#room_description").attr('placeholder',response[3])
        window.id = response[4]
      }
    })
    return false;
})

$('#formMod').submit(function () {
    var bld = $("#bld").val(); 
    var bnum = $("#rm_num").val();
    var bflr = $("#flr_number").val(); 
    var bdesc = $("#room_description").val();
    var id = window.id

    $.ajax({
      method: "POST",
      url: "modRoomDb.php",
      data: { building: bld, number: bnum, floor: bflr, description: bdesc, id: id },
      success: function(response) {
        console.log(response)
        $('#formtest').show();
        $('#formMod').hide();
        $("#room_building").val($("#room_building option:first").val());
        $("#room_number").val($("#room_number option:first").val());
        $('#room_number').empty().append('<option value="" disabled selected>Select Room Number</option>')
        $("#bld").val($("#bld option:first").val());
        $("#flr_number").val($("#flr_number option:first").val());
        $("#room_description").attr('placeholder','')
        $("#room_description").val('')
        $("#inputIssue").empty().append('<label for="room_number">Room Number:</label><input type="text" class="form-control" name="rm_num" id="rm_num" value="">')
        if(response == "success"){
          $("#mes").html("<div id='message' class='alert alert-success alertdiv text-center'><strong  id='success'>Successfully modified room!</strong></div>")
          $("#message").fadeOut(5000, "linear")
        }
        else if(response == "exits"){
          $("#mes").html("<div id='message' class='alert alert-danger alertdiv text-center'><strong  id='success'>Room already exists!</strong></div>")
          $("#message").fadeOut(5000, "linear")
        }
        else if(response == "not modified"){
          $("#mes").html("<div id='message' class='alert alert-warning alertdiv text-center'><strong  id='success'>No changes made!</strong></div>")
          $("#message").fadeOut(5000, "linear")
        }
      }
    })
    return false;
})

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
