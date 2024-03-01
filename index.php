<?php
// Check if the gallery query string is set
$gallery = isset($_GET['gallery']) ? $_GET['gallery'] : '';

// Set the path to the gallery
$path = 'gallery/' . $gallery;

// Initialize an array to hold the image URLs
$images = [];

// Initialize variables to hold the archive file URL
$archiveUrl = '';

// Check if the path is a directory
if (is_dir($path)) {
    // Use glob to find all JPEG, PNG, ZIP, CBR, and CBZ files in the directory
    foreach (glob($path . '/*.{jpg,jpeg,png,webp,zip,cbr,cbz}', GLOB_BRACE) as $file) {

        if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $file)) {
            $images[] = $file;
        } elseif (preg_match('/\.(zip|cbr|cbz)$/i', $file)) {
            $archiveUrl = $file;
        }
    }
}

// Initialize a variable to hold the contents of info.txt, if it exists
$infoContents = '';

// Check if the path is a directory and if info.txt exists in that directory
$infoPath = $path . '/info.txt';
if (is_dir($path) && file_exists($infoPath)) {
    // Read the contents of info.txt
    $infoContents = file_get_contents($infoPath);
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
    
<svg xmlns="http://www.w3.org/2000/svg" style="display:none" id="customSvgLibrary">
    
<symbol id="arrow-left" viewBox="0 0 29 56"><path d="M28.7.3c.4.4.4 1 0 1.4l-26.3 26.3 26.3 26.3c.4.4.4 1 0 1.4-.4.4-1 .4-1.4 0l-27-27c-.4-.4-.4-1 0-1.4l27-27c.3-.3 1-.4 1.4 0z"></path></symbol>

<symbol id="arrow-right" viewBox="0 0 29 56"><path d="M.3 55.7c-.4-.4-.4-1 0-1.4l26.3-26.3-26.3-26.3c-.4-.4-.4-1 0-1.4.4-.4 1-.4 1.4 0l27 27c.4.4.4 1 0 1.4l-27 27c-.3.3-1 .4-1.4 0z"></path></symbol>

<symbol id="download" viewBox="0 -960 960 960" width="36" height="36"><path d="M480-342 356-466l20-20 90 90v-352h28v352l90-90 20 20-124 124ZM272-212q-26 0-43-17t-17-43v-90h28v90q0 12 10 22t22 10h416q12 0 22-10t10-22v-90h28v90q0 26-17 43t-43 17H272Z"/></symbol>

<symbol id="info-btn" viewBox="0 -960 960 960" width="36" height="36"><path d="M466-306h28v-214h-28v214Zm14-264q8.5 0 14.25-5.75T500-590q0-8.5-5.75-14.25T480-610q-8.5 0-14.25 5.75T460-590q0 8.5 5.75 14.25T480-570Zm.174 438Q408-132 344.442-159.391q-63.559-27.392-110.575-74.348-47.015-46.957-74.441-110.435Q132-407.652 132-479.826q0-72.174 27.391-135.732 27.392-63.559 74.348-110.574 46.957-47.016 110.435-74.442Q407.652-828 479.826-828q72.174 0 135.732 27.391 63.559 27.392 110.574 74.348 47.016 46.957 74.442 110.435Q828-552.348 828-480.174q0 72.174-27.391 135.732-27.392 63.559-74.348 110.575-46.957 47.015-110.435 74.441Q552.348-132 480.174-132ZM480-160q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></symbol>

  <symbol id="close" viewBox="0 0 30 30"><path d="M15 0c-8.3 0-15 6.7-15 15s6.7 15 15 15 15-6.7 15-15-6.7-15-15-15zm5.7 19.3c.4.4.4 1 0 1.4-.2.2-.4.3-.7.3s-.5-.1-.7-.3l-4.3-4.3-4.3 4.3c-.2.2-.4.3-.7.3s-.5-.1-.7-.3c-.4-.4-.4-1 0-1.4l4.3-4.3-4.3-4.3c-.4-.4-.4-1 0-1.4s1-.4 1.4 0l4.3 4.3 4.3-4.3c.4-.4 1-.4 1.4 0s.4 1 0 1.4l-4.3 4.3 4.3 4.3z"/></symbol>


</svg>
    
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
<button class="arrows" id="next"><svg><use href="#arrow-right"></button>

<div class="progress-box">
    <div id="progress-bar"></div>
</div>

<div class="left-buttons">
    
    <?php if ($infoContents !== ''): ?>
        <div id="infoButton" class="info-btn"><svg><use href="#info-btn"></use></svg></div>
    <?php endif; ?>
    
    <?php if ($archiveUrl !== ''): ?>
        <div id="download-btn" class="download-btn"><svg><use href="#download"></use></svg></div>
    <?php endif; ?>
    
</div>

<div id="download-window" class="download-window">
    <?php if ($archiveUrl !== ''): ?>
        <a class="dl-link" href="<?= htmlspecialchars($archiveUrl); ?>"> <svg><use href="#download"></use></svg> Download</a>
    <?php endif; ?>
</div>

<div id="info-window" class="info-window">
    <svg id="close-info" class="close-info"><use href="#close"></use></svg>
    <?php echo($infoContents); ?>
</div>

<script src="scripts.js"></script>
</body>
</html>

