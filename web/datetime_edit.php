<!-- Top Navbar-->
<div class="navbar">
	<div class="navbar-inner">
		<div class="left">
			<a href="#" class="back link" data-ignore-cache="true" data-force="true">
				<i class="icon icon-back"></i>
				<span>Retour</span>
			</a>
		</div>
		<div class="center sliding">Date & Heure</div>
		<div class="right">
		</div>
	</div>
</div>
<div class="pages">
	<div data-page="datetime" class="page no-toolbar">
		<div class="page-content">
			<div class="content-block">
				<script type="text/javascript" src="js/jquery.min.js"></script>
				<p>
					<a href="#" id="updateTime" class="button button-big button-fill">Mise à jour automatique de la date et de l'heure</a>
				</p>
				<script type="text/javascript">
					var element = document.getElementById('updateTime');

					element.onclick = function() {
						alert("Vous m'avez cliqué !");
					};
					$("#updateTime").click(function(event) {
						$.ajax({
							type: "POST",
							url : 'post_time_autoUpdate.php',
							success: function(html) {
								if(html){
									alert(html);
								}
							}
						});
					});
				</script>
			</div>
		</div>
	</div>
</div>
