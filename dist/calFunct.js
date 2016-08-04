// A $( document ).ready() block.
$( document ).ready(function() {
	$("#calModal").on("hidden.bs.modal", function(){
	    $('#modalContent').html('');
	    $('#modal-title').html('');
	});
});


function displayCalendarEvent(event){
	if(event.allDay){
		var startDate = event.start.format("dddd, MMMM Do YYYY");
		if(event.end !== null){
			var endDate = event.end.format("dddd, MMMM Do YYYY");
		}else{
			var endDate = startDate;
		}
	}else{
		var startDate = event.start.format("dddd, MMMM Do YYYY, h:mm a");
		var endDate = event.end.format("dddd, MMMM Do YYYY, h:mm a");
	}
	// console.log(event);
    var header = event.title;
    var data = 
    		"<div class='row inner-side-pad'><div class='col-xs-12 col-sm-6'><h3>Start Time:"+startDate+"</h3></div>"+
    		"<div class='col-xs-12 col-sm-6'><h3>End Time:"+endDate+"</h3></div></br>"+
    		"<div class='col-xs-12 '>"+event.description+"</div>";

    $('#calModal').modal('show')
                .find('#modalContent')
                .html(data);
    $('#modal-title').html(header);
    $('#modal-title').wrap( "<div class='text-center'></div>" );

}
