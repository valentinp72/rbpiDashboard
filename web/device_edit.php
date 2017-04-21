<?php
require '../config/_config.php';

// Get device data
$query = $DB->query('SELECT * FROM devices WHERE id = ' . $_GET['id']);
$data = $query->fetch();

?>


<!-- Top Navbar-->
<div class="navbar">
	<div class="navbar-inner">
		<div class="left">
			<a href="#" class="back link" data-ignore-cache="true" data-force="true">
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
			<form id="device_edit_form" action="post_device_edit.php" class="ajax-submit-onchange" method="POST">

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
											<input
												type="checkbox"
												name="prog_on_state"
												<?php if($data['prog_on_state']) echo "checked"; ?>>
											<div class="checkbox"></div>
										</label>
									</div>
								</div>
							</div>
						</li>

						<!-- HEURE -->
						<li>
							<div class="item-content">
								<div class="item-inner">
									<div class="item-title label">Heure</div>
									<div class="item-input">
										<label class="time_editor">
											<div class="time_separator"></div>
											<input type="time" class="right" name="prog_on_time" value="<?php echo $data['prog_on_time']; ?>" />
										</label>
									</div>
								</div>
							</div>
						</li>

					</ul>
				</div>


				<!-- PROGRAMMATION - EXTINCTION -->

				<div class="content-block-title">PROGRAMMATION - EXTINCTION</div>
				<div class="list-block">
					<ul>
						<!-- ACTIF -->
						<li>
							<div class="item-content">
								<div class="item-inner">
									<div class="item-title label">Actif</div>
									<div class="item-input right">
										<label class="label-switch">
											<input
												type="checkbox"
												name="prog_off_state"
												<?php if($data['prog_off_state']) echo "checked"; ?>>
											<div class="checkbox"></div>
										</label>
									</div>
								</div>
							</div>
						</li>

						<!-- HEURE -->
						<li>
							<div class="item-content">
								<div class="item-inner">
									<div class="item-title label">Heure</div>
									<div class="item-input">
										<label class="time_editor">
											<div class="time_separator"></div>
											<input type="time" class="right" name="prog_off_time" value="<?php echo $data['prog_off_time']; ?>" />
										</label>
									</div>
								</div>
							</div>
						</li>

					</ul>

				</div>

				<input type="hidden" name="id" value="<?php echo $data['id']; ?>">
			</form>
		</div>
	</div>
</div>
