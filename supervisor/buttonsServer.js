var sys         = require("util");
var exec        = require("child_process").exec;
var dash_button = require("node-dash-button");
var mysql       = require("mysql");
var config      = require("../config/_config.json");


console.log("[Buttons Server] Starting...");

// DATABASE CONNECTION

var database  = mysql.createConnection({
	host     : config.database.host,
	user     : config.database.username,
	password : config.database.password,
	database : config.database.name
});

database.connect();

database.query('SELECT id,name,button_mac FROM devices WHERE visible = 1 AND button_mac <> "0"', function(error, results, fields){
	if(error)
		throw error;

	// Creating an array of all devices with mac adresses
	var devices = [];
	var buttons = [];

	for(var i in results){
		devices.push([results[i].id, results[i].name, results[i].button_mac]);
		buttons.push(results[i].button_mac);
	}

	if(config.debug == true){
		console.log("[Buttons Server] Devices with mac adresses:")
		console.log(devices);
	}

	// LISTEN TO THE DASH BUTTONS

	var dash = dash_button(buttons, null, null, 'all'); 


	dash.on("detected", function (dash_id){
	    
		console.log("[Buttons Server] Dash button " + dash_id + " was clicked!");

		// LOOP ALL THE DEVICES
		for(var i = 0 ; i < devices.length ; i++){
			if(devices[i][2] == dash_id){
				console.log("[Buttons Server]  => Let's invert " + devices[i][1] + " state!");
				exec("./command.php command=INVERT devices=" + devices[i][0] + " origin=MANUAL");
			}
		}

	});

});



process.on('SIGINT', () => {
	console.log('[Buttons Server] Received SIGINT. Exiting...');
	database.end();
	process.exit();
});
