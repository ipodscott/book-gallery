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
    foreach (glob($path . '/*.{jpg,jpeg,png,webp,zip,cbr,cbz,pdf}', GLOB_BRACE) as $file) {

        if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $file)) {
            $images[] = $file;
        } elseif (preg_match('/\.(zip|cbr|cbz|pdf)$/i', $file)) {
            $archiveUrl = $file;
        }
    }
}

// Initialize an array to hold archive URLs
$archiveUrls = [];

// Check if the path is a directory
if (is_dir($path)) {
    // Use glob to find all relevant files in the directory
    foreach (glob($path . '/*.{pdf,zip,cbr,cbz}', GLOB_BRACE) as $file) {
        // Add file to the array of archives
        $archiveUrls[] = $file;
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

// Assuming $gallery is already set based on the query string

// Set the path to the gallery's data.json file
$jsonFilePath = 'gallery/' . $gallery . '/data.json';

// Initialize variables to hold the JSON data
$galleryTitle = '';
$galleryInfo = '';
$galleryInfoImg = '';

// Check if the data.json file exists
if (file_exists($jsonFilePath)) {
    // Read and decode the JSON file
    $jsonData = json_decode(file_get_contents($jsonFilePath), true);
    
    // Assign the JSON data to variables
    $galleryTitle = $jsonData['title'] ?? '';
    $galleryInfo = $jsonData['info'] ?? '';
    $galleryInfoImg = $jsonData['info-img'] ?? '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Your App Name">
    <link rel="apple-touch-icon" sizes="180x180" href="path/to/icon-180x180.png">
    <link rel="apple-touch-startup-image" href="path/to/launch-screen.png">

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

<symbol id="download" viewBox="0 0 164.3 164.1">
  <path d="M155.8,101.6c-4.7,0-8.5,3.8-8.5,8.5v37H17v-37c0-4.7-3.8-8.5-8.5-8.5S0,105.4,0,110.1v45.5c0,4.7,3.8,8.5,8.5,8.5h147.3
    c4.7,0,8.5-3.8,8.5-8.5v-45.5C164.3,105.4,160.5,101.6,155.8,101.6z"/>
  <path d="M25.8,79.2l51,41c1.6,1.3,3.4,1.9,5.3,1.9s3.8-0.6,5.3-1.9l51-41c3.7-2.9,4.2-8.3,1.3-12c-2.9-3.7-8.3-4.2-12-1.3
    L90.6,95.8V8.5c0-4.7-3.8-8.5-8.5-8.5s-8.5,3.8-8.5,8.5v87.3L36.5,66c-3.7-2.9-9-2.4-12,1.3C21.6,70.9,22.2,76.3,25.8,79.2z"/>
</symbol>


<symbol id="info-btn" viewBox="0 0 165.7 165.7">
  <path d="M83.8,64.7c-4.7,0-8.5,3.8-8.5,8.5v52.2c0,4.7,3.8,8.5,8.5,8.5s8.5-3.8,8.5-8.5V73.2C92.3,68.5,88.5,64.7,83.8,64.7z"/>
  <path d="M83.8,36.8c-4.7,0-8.5,3.8-8.5,8.5v0.2c0,4.7,3.8,8.5,8.5,8.5s8.5-3.8,8.5-8.5v-0.2C92.3,40.6,88.5,36.8,83.8,36.8z"/>
  <path d="M82.8,0C37.2,0,0,37.2,0,82.8s37.2,82.8,82.8,82.8c45.7,0,82.8-37.2,82.8-82.8S128.5,0,82.8,0z M82.8,148.7
    c-36.3,0-65.8-29.5-65.8-65.8S46.5,17,82.8,17c36.3,0,65.8,29.5,65.8,65.8S119.2,148.7,82.8,148.7z"/>
</symbol>


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

<?php if ($archiveUrl !== ''): ?>
  <div id="download-window" class="download-window">
    <?php foreach ($archiveUrls as $archiveUrl): ?>
      <?php
        // Extract the file extension and convert it to uppercase for display
        $fileExtension = strtoupper(pathinfo($archiveUrl, PATHINFO_EXTENSION));
      ?>
      <a class="dl-link" href="<?= htmlspecialchars($archiveUrl); ?>"><svg><use href="#download"></use></svg>Download | <?= $fileExtension; ?></a>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<div id="info-window" class="info-window">
    <div class="info-contents">
      <?php if ($galleryTitle): ?>
          <h1 class="info-title"><?= htmlspecialchars($galleryTitle); ?></h1>
      <?php endif; ?>
      <?php if ($galleryInfoImg): ?>
          <img src="<?= htmlspecialchars($galleryInfoImg); ?>" alt="Gallery Information Image" class="info-img">
      <?php endif; ?>
      <?php if ($galleryInfo): ?>
          <div class="info-copy"><?= htmlspecialchars($galleryInfo); ?></div>
      <?php endif; ?>
      <div class="additional-info"><?php echo($infoContents); ?></div>
    </div>
    <svg id="close-info" class="close-info"><use href="#close"></use></svg>
</div>

<script src="scripts.js"></script>
</body>
</html>

