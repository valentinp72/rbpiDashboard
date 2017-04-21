<?php require '../config/_config.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link rel="apple-touch-icon" href="/images/icon.png">
	<link rel="apple-touch-startup-image" href="/images/launch.png">
	 <!-- iPhone 6 startup image -->
	<link href="/images/launch_750x1294.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
	<meta name="apple-mobile-web-app-title" content="Dashboard">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">

	<title>Dashboard</title>

	<link rel="stylesheet" href="css/framework7.ios.min.css">
	<link rel="stylesheet" href="css/framework7-icons.css">
	<link rel="stylesheet" href="css/framework7.ios.colors.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="statusbar-overlay"></div>
	<div class="panel-overlay"></div>

	<div class="views">
		<div class="view view-main">

			<!-- NAVBAR -->
			<div class="navbar">
				<div class="navbar-inner">
					<div class="center sliding">Dashboard</div>
					<div class="right">
						<a href="javascript:history.go(0);">Rafraîchir</a>
					</div>
				</div>
			</div>

			<script type="text/javascript" src="js/framework7.min.js"></script>
			<script type="text/javascript" src="js/nobounce.min.js"></script>
			<script type="text/javascript" src="js/jquery.min.js"></script>
			<script type="text/javascript" src="js/dashboard_main.js"></script>

			<!-- PAGE CONTENT -->
			<div class="pages navbar-through toolbar-through">
				<div data-page="index" class="page">
					<div class="page-content">

						<div id="date_heure" class="center">
							<?php
								// Display temp date & time before javascript loading

								setlocale(LC_ALL, 'fr_FR', 'fr_FR.UTF-8');

								$today = getdate();

								$hours = $today['hours'];
								$minutes = $today['minutes'];
								$seconds = $today['seconds'];

								$date = strftime("%A %e %B %Y", time());
								$time = $hours . ":" . $minutes . ":" . $seconds;
								// Lundi 17 avril 2017
								// 20:24:03
							?>
							<a href="datetime_edit.php" id="date"><?php echo $date; ?></a><br/>
							<a href="datetime_edit.php" id="time"><?php echo $time; ?></a>
						</div>

						<div class="content-block-title">APPAREILS</div>

						<div class="list-block">
						<form action="post_device_update.php" method="GET" class="ajax-submit-onchange">
							<ul>
								<?php
								// LIST ALL DEVICES
								$query = $DB->query('SELECT * FROM devices');
								while($data = $query->fetch()) {
									if($data['visible'] == true){
									?>
									<li class="swipeout">
										<div class="swipeout-content item-content">
											<div class="item-inner">
												<div class="item-title label"><?php echo $data['name']; ?></div>
												<div class="item-input right">
													<a href="device_edit.php?id=<?php echo $data['id']; ?>" data-ignore-cache="true" data-force="true"><div class="f7-icons edit_device">chevron_right</div></a>
													<label class="label-switch">
														<input
															type="checkbox"
															name='<?php echo $data['id']; ?>'
															value="1"
															class="device_switch"
															id="device_active_<?php echo $data['id']; ?>"
															<?php if($data['state']) echo "checked"; ?>
														>
														<div class="checkbox"></div>
													</label>
												</div>
											</div>
										</div>
										<div class="swipeout-actions-right">
											<!-- We add data-close-on-cancel attribute to close swipeout automatically -->
											<a
												href="#"
												id="device_delete_<?php echo $data['id']; ?>"
												class="swipeout-delete delete_device"
											>
												Supprimer l'appareil
											</a>
										</div>
									</li>
								<?php
									}
								}
								?>
							</ul>
						</form>
						</div>
					</div>
				</div>
			</div>

			<!-- TOOLBAR -->
			<div class="toolbar">
				<div class="toolbar-inner">
					<a class="link"></a>
					<a href="device_add.php" class="link">Ajouter un appareil</a>
					<a class="link"></a>
				</div>
			</div>

		</div>
	</div>
	<script type="text/javascript" src="js/framework7.min.js"></script>
	<script type="text/javascript" src="js/nobounce.min.js"></script>
	<script type="text/javascript" src="js/dashboard_main.js"></script>

	<!-- TIME AND DATE -->
	<script type="text/javascript">
		var ctoday = <?php echo time() * 1000 ?>;
	</script>
	<script type="text/javascript" src="js/date_time.js"></script>

</body>
</html>
