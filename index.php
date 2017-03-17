<?php 
$title = "Dashboard"; 
require "header.php";
?>

<script>

	var ctoday = <?php echo time() * 1000 ?>;
	setInterval(function() {
		ctoday += 1000;
	}, 1000);

	function startTime() {
		var today = new Date(ctoday);

		var monthArray = new Array(
							"janvier",
							"février",
							"mars",
							"avril",
							"mai",
							"juin",
							"juillet",
							"août",
							"septembre",
							"octobre",
							"novembre",
							"décembre"
						);
		var dayArray = new Array(
							"Dimanche",
							"Lundi",
							"Mardi",
							"Mercredi",
							"Jeudi",
							"Vendredi",
							"Samedi"
						);

		var year    = today.getFullYear();
		var month   = today.getMonth();
		var day_n   = today.getDate();
		var day_s   = today.getDay();
		var hours   = today.getHours();	
		var minutes = today.getMinutes();
		var seconds = today.getSeconds();
		
		year    = checkTime(year);
		day_n   = checkTime(day_n);
		hours   = checkTime(hours);
		minutes = checkTime(minutes);
		seconds = checkTime(seconds);
	
		document.getElementById('date').innerHTML = dayArray[day_s] + " " + day_s  + " " + monthArray[month] + " " + year; 
		document.getElementById('time').innerHTML = hours + ":" + minutes + ":" + seconds; 
		
		setTimeout(startTime, 1000);
	}

	function checkTime(i) {
		if (i < 10){
			i = "0" + i
		};
		return i;
	}

	window.onload = function(){
		startTime();
	};

</script>
<div class="text-center">
	<h1 id="date">Date  (problème de javascript)</h1>
	<h1 id="time">Heure (problème de javascript)</h1>
</div>
<?php require "footer.php"; ?>
