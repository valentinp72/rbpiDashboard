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
      <div class="content-block">
        <p>EDIT A DEVICE</p>
		<?php
			echo $_GET['id'];

			echo $data['name'];
		?>
      </div>
    </div>
  </div>
</div>
