<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link rel="apple-touch-icon" href="/images/icon.png">
	<link rel="apple-touch-startup-image" href="/images/launch.png">
	 <!-- iPhone 6 startup image -->
	<link href="/images/launch_750x1294.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
	<meta name="apple-mobile-web-app-title" content="Dashboard">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">

	<title>Dashboard</title>

	<link rel="stylesheet" href="css/framework7.ios.min.css">
	<link rel="stylesheet" href="css/framework7.ios.colors.min.css">
	<link rel="stylesheet" href="css/framework7-icons.css">
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

			<!-- PAGE CONTENT -->
			<div class="pages navbar-through toolbar-through">
				<div data-page="index" class="page">
					<div class="page-content">

						<div id="date_heure" class="center">
							<a href="datetime_edit.php" id="date">Date  (problème de javascript)</a><br/>
							<a href="datetime_edit.php" id="time">Heure (problème de javascript)</a>
						</div>

						<div class="content-block-title">APPAREILS</div>
						<div class="list-block">
							<ul>
								<li>
									<div class="item-content">
										<div class="item-inner">
											<div class="item-title label">Lampe bureau</div>
											<div class="item-input right">
												<a class="f7-icons edit_device" href="device_edit.php?id=1">chevron_right</a>

												<label class="label-switch">
													<input type="checkbox">
													<div class="checkbox"></div>
												</label>
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="item-content">
										<div class="item-inner">
											<div class="item-title label">Lampe chevet</div>
											<div class="item-input right">
												<a class="f7-icons edit_device" href="device_edit.php?id=2">chevron_right</a>

												<label class="label-switch">
													<input type="checkbox">
													<div class="checkbox"></div>
												</label>
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="item-content">
										<div class="item-inner">
											<div class="item-title label">Ventilateur</div>
											<div class="item-input right">
												<a class="f7-icons edit_device" href="device_edit.php?id=3">chevron_right</a>

												<label class="label-switch">
													<input type="checkbox">
													<div class="checkbox"></div>
												</label>
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="item-content">
										<div class="item-inner">
											<div class="item-title label">Raspberry Pi</div>
											<div class="item-input right">
												<a class="f7-icons edit_device" href="device_edit.php?id=4">chevron_right</a>

												<label class="label-switch">
													<input type="checkbox">
													<div class="checkbox"></div>
												</label>
											</div>
										</div>
									</div>
								</li>

							</ul>
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
