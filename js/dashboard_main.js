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
