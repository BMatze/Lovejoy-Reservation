/**File: roomControl.js
 * Purpose: Handle AJAX communication with server
 * for removing and/or modifying reservations.
 * 
 */




$(window).on('load', function() {




	function fixInterface() {
		$modal.detach();
		$(".monthly-event-list").after($modal);

	}

	var $modal = $("#confirm-modal");
	var $name = $modal.find("#name");
	var $startdate = $modal.find("#start-date");
	var $starttime = $modal.find("#start-time");
	var $endtime = $modal.find('#end-time');
	//var eventID = -1;
	fixInterface();
	var eventID=-1;
//	Handle clicking on an event
	$(".monthly-event-list").on('click',".listed-event", function(e) {

		//identify which event the user wishes to remove
		eventID = $(e.currentTarget).attr('data-eventid');
		var event = null;
		for (var k in listofevents["monthly"]) {
			var entry = listofevents["monthly"][k];
			if (entry['id'] == eventID) {
				event = entry;
				break;
			}
		}
		if (event==null) {
			console.log("We could not locate the entry!");
			return;
		}
		//found entry, populate the variables for modal
		$name.text(entry.name);
		$startdate.text(entry.startdate);
		$starttime.text(entry.starttime);
		$endtime.text(entry.endtime);

		//open modal for confirming deletion
		$modal.show();
		$modal.css("transform","scale(1)");


	});

//	Handle removing reservation
	$("#confirmRemoveBtn").on('click',function(e) {
		console.log("Clicked confirm!");
		//send request to remove to server
		$.ajax({
			type: "POST",
			url: "removeEvent.php",
			data: {
				requestType: (faculty ? 1 : 0),
				eventid: eventID
			},
			//response from server handled here
			success:function(data,textStatus) {
				console.log(data +":"+textStatus);

			}
		});
	});
//	Handle canceling remove
	$("#cancelRemoveBtn").on('click',function(e) {
		//Return to previous screen
		$modal.css("transform","scale(0)");
	});


//	Handle clicking off the modal
	$(window).on('click',function(e) {

	});
	});