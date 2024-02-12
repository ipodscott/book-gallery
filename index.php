<?php
$gallery = isset($_GET['gallery']) ? preg_replace('/[^A-Za-z0-9_\-]/', '', $_GET['gallery']) : $defaultDir;
$images = array_diff(scandir($gallery), array('..', '.'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<style>
	@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap')
	</style>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Image Slideshow</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>

<div id="slideshow">
	<div class="slides" id="slides">
		<?php foreach ($images as $image): ?>
			<div class="slide"><img src="/<?= $gallery ?>/<?= $image ?>"></div>
		<?php endforeach; ?>
	</div>
	<button id="prev"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			 viewBox="0 0 5.6 10.2" style="enable-background:new 0 0 5.6 10.2;" xml:space="preserve">
		<path style="fill:#fff" d="M5.1,10.2L0,5.1L5.1,0l0.5,0.5L1,5.1l4.6,4.6L5.1,10.2z"/>
		</svg>
</button>
	<button id="next">
		<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			 viewBox="0 0 5.6 10.2" style="enable-background:new 0 0 5.6 10.2;" xml:space="preserve">
		<path style="fill:#fff" d="M4.6,5.1L0,0.5L0.5,0l5.1,5.1l-5.1,5.1L0,9.7L4.6,5.1z"/>
	</button>
</div>

<div class="menu" id="menu">
	<div class="menu-btn" id="menu-toggle">
		<span></span>
		<span></span>
		<span></span>
	</div>
	<div class="menu-title">Main Menu</div>
	<ul>
		<?php foreach ($images as $index => $image): ?>
			<li data-index="<?= $index ?>">Page <?= $index - 1 ?></li>
		<?php endforeach; ?>
	</ul>
</div>

<script src="script.js"></script>
</body>
</html>