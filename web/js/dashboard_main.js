// Initialize your app
var dashboard = new Framework7();

// Export selectors engine
var $$ = Dom7;

// Add view
var mainView = dashboard.addView('.view-main', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true
});

$$(document).on('click', '.delete_device', function (e){
//	var id = $$(this).attr('id');
	alert(id);
});

// DELETE DEVICES IN THE INDEX PAGE
$(".delete_device").on('click', function () {
	// Send request to device_remove.php
	$.post('post_device_remove.php', {
		id: $(this).attr('id'),
	}, function(error) {
		// We print the error if there is one
		if(error){
			alert(error);
		}
	});
});
