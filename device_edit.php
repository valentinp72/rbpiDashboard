<?php
require '_config.php';
// Get device data
$query = $DB->query('SELECT * FROM devices WHERE id = ' . $_GET['id']);
$data = $query->fetch();
?>


<!-- Top Navbar-->
<div class="navbar">
	<div class="navbar-inner">
		<div class="left">
			<a href="#" class="back link">
				<i class="icon icon-back"></i>
				<span>Retour</span>
			</a>
		</div>
		<div class="center sliding"><?php echo $data['name']; ?></div>
		<div class="right">
		</div>
	</div>
</div>
<div class="pages">
	<div data-page="adddevice" class="page no-toolbar">
		<div class="page-content">
			<form action="device_edit.php" method="POST">

				<!-- REGLAGES -->

				<div class="content-block-title">RÉGLAGES</div>
				<div class="list-block">
					<ul>
						<!-- NOM -->
						<li>
							<div class="item-content">
								<div class="item-inner">
									<div class="item-title label">Nom</div>
									<div class="item-input">
										<input class="right" type="text" value="<?php echo $data['name']; ?>" name="name">
									</div>
								</div>
							</div>
						</li>
						<!-- CODE -->
						<li>
							<div class="item-content">
								<div class="item-inner">
									<div class="item-title label">Code</div>
									<div class="item-input">
										<input class="right" type="text" value="<?php echo $data['code']; ?>" name="code">
									</div>
								</div>
							</div>
						</li>

					</ul>
				</div>

				<!-- PROGRAMMATION - ALLUMAGE -->

				<div class="content-block-title">PROGRAMMATION - ALLUMAGE</div>
				<div class="list-block">
					<ul>
						<!-- ACTIF -->
						<li>
							<div class="item-content">
								<div class="item-inner">
									<div class="item-title label">Actif</div>
									<div class="item-input right">
										<label class="label-switch">
											<input type="checkbox" name="prog_on_state" id="device_active_100">
											<div class="checkbox"></div>
										</label>
									</div>
								</div>
							</div>
						</li>
						<script type="text/javascript">
						$$('#device_active_100').prop('checked', 1);
						</script>

						<!-- HEURE -->
						<li>
							<div class="item-content">
								<div class="item-inner">
									<div class="item-title label">Heure</div>
									<div class="item-input">
										<input type="time" class="right" name="prog_on_time" value="<?php echo $data['prog_on_time']; ?>">
									</div>
								</div>
							</div>
						</li>

					</ul>
				</div>


			</form>

			<?php
			//	echo '<script type="text/javascript">';
			//	echo "changeDeviceState(1, true);";
			//	echo '</script>';
			?>
		</div>
	</div>
</div>
