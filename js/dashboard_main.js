// Initialize your app
var dashboard = new Framework7();

// Export selectors engine
var $$ = Dom7;

// Add view
var mainView = dashboard.addView('.view-main', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true
});

function changeDeviceState(id, state){
	$$('#device_active_' + id).prop('checked', state);
}


/*$$('.device_switch').on('click', function (e) {
    var isChecked = $$('input').prop('checked');
	//alert("hllo" + this.id);
	$.ajax({
		url : 'ajax.php', // La ressource ciblée
		type : 'GET' // Le type de la requête HTTP.
		data : 'utilisateur=fd';
	});
});
*/
