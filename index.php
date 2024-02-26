<?php
// Check if the gallery query string is set
$gallery = isset($_GET['gallery']) ? $_GET['gallery'] : '';

// Set the path to the gallery
$path = 'gallery/' . $gallery;

// Initialize an array to hold the image URLs
$images = [];

// Check if the path is a directory
if (is_dir($path)) {
    // Use glob to find all JPEG and PNG images in the directory
    foreach (glob($path . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE) as $file) {
        $images[] = $file;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document Slider</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap')
    </style>

</head>
<body class="body" id="body">
    
<svg xmlns="http://www.w3.org/2000/svg" style="display:none" id="customSvgLibrary"> <symbol id="arrow-left" viewBox="0 0 29 56"><path d="M28.7.3c.4.4.4 1 0 1.4l-26.3 26.3 26.3 26.3c.4.4.4 1 0 1.4-.4.4-1 .4-1.4 0l-27-27c-.4-.4-.4-1 0-1.4l27-27c.3-.3 1-.4 1.4 0z"></path></symbol>
<symbol id="arrow-right" viewBox="0 0 29 56"><path d="M.3 55.7c-.4-.4-.4-1 0-1.4l26.3-26.3-26.3-26.3c-.4-.4-.4-1 0-1.4.4-.4 1-.4 1.4 0l27 27c.4.4.4 1 0 1.4l-27 27c-.3.3-1 .4-1.4 0z"></path></symbol></svg>
    
<div class="slider" id="slider">
    <?php foreach ($images as $index => $image): ?>
        <div class="slide<?php echo $index === 0 ? ' active' : ''; ?>">
            <img src="<?php echo htmlspecialchars($image); ?>" alt="Slide <?php echo $index + 1; ?>">
        </div>
    <?php endforeach; ?>
</div>

<div class="slider-menu" id="slider-menu">
    <?php foreach ($images as $index => $image): ?>
        <div class="menu-item<?php echo $index === 0 ? ' active' : ''; ?>" data-slide="<?php echo $index; ?>">Page <?php echo $index + 1; ?></div>
    <?php endforeach; ?>
</div>

<div id="menu-toggle" class="menu-toggle">
    <span></span>
    <span></span>
    <span></span>
</div>

<button class="arrows" id="prev"><svg><use href="#arrow-left"></use></svg></button>
<button class="arrows" id="next"><svg><use href="#arrow-right"><</button>

<div class="progress-box">
    <div id="progress-bar"></div>
</div>

<script src="scripts.js"></script>
</body>
</html>

