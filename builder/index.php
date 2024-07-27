<?php
//Project Title: Data Builder
// Initialize the items array and other fields
$data = [
	'background-image' => isset($_POST['background-image']) ? $_POST['background-image'] : '',
	'site-title' => isset($_POST['site-title']) ? $_POST['site-title'] : '',
	'description' => isset($_POST['description']) ? $_POST['description'] : '',
	'position' => isset($_POST['position']) ? $_POST['position'] : 'above',
	'books' => isset($_POST['books']) ? $_POST['books'] : [['title' => '', 'link' => '']]
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['add_item'])) {
		// Add only one new book item
		$data['books'][] = ['title' => '', 'link' => ''];
	} elseif (isset($_POST['remove_item'])) {
		$index = $_POST['remove_item'];
		unset($data['books'][$index]);
		$data['books'] = array_values($data['books']);
	} elseif (isset($_POST['update_order']) || isset($_POST['render_json'])) {
		// Reorder books based on the order in the form
		$newbooks = [];
		if (isset($_POST['books'])) {
			foreach ($_POST['books'] as $book) {
				if (!empty($book['title']) || !empty($book['link'])) {
					$newbooks[] = $book;
				}
			}
			$data['books'] = $newbooks;
		}
	}
}

// Generate JSON
$json = json_encode($data, JSON_PRETTY_PRINT);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>JSON Playlist Generator</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
	<style>
		body {
			font-family: "Open Sans", sans-serif;
			font-optical-sizing: auto;
			display: flex;
			background-color: #000;
			overflow: hidden;
		}
		
		::-webkit-scrollbar {
		  width: 8px;
		  border-radius: 4px;	
		  background-color: #333;
		}
		 
	::-webkit-scrollbar-track {
		  box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
		  border-radius: 5px;
		}
		 
	::-webkit-scrollbar-thumb {
		  background-color: #fff;
		  border-radius: 4px;
		  outline: 1px solid slategrey;
		}
		
		.left-half{
			box-sizing: border-box;
		}
		
		.left-half, .right-half {
			width: 50%;
			padding: 20px 20px 20px 20px;
		}
		input[type="text"] {
			display: flex;
			position: relative;
			width: 100% !important;
			padding: 10px;
			font-size: 16px;
			color: #fff;
			background-color: #000;
			font-family: "Open Sans", sans-serif;
			border-radius: 6px 6px 0 0;
			border: none;
			transition: all 0.5s;
		}
		
		input[type="text"]:hover{
			background-color: #fff;
			color: #000;
		}
		
		input[type="text"]:nth-child( even ){
			border-radius: 0 0 6px 6px;
		}
		
	.json-inputs{
		display: flex;
		position: relative;
		width: 100%;
		flex-direction: column;
	}
		
	.remove-btn {
			position: relative;
			margin-top: 0;
			background-color: #000;
			color: #fff;
			height: 32px;
			width: 36px;
			border-radius: 18px;
			display: flex;
			justify-content: center;
			align-items: center;
			padding: 0;
			margin-left: 20px;
			line-height: 0;
			font-size: 20px;
			border: 2px solid #fff;
		}
		.remove-btn:hover{
			background-color: #fff;
			color: #000;
		}
		
		button {
			width: 50%;
			margin-top: 0;
			font-family: "Open Sans", sans-serif;
			cursor: pointer;
			border: none;
		}
		pre {
			margin: 0;
			padding: 0;
			background-color: #000;
			color: #fff;
			padding: 10px;
			white-space: pre-wrap;
			word-wrap: break-word;
			font-family: "Open Sans", sans-serif;
			border-radius: 10px;
			max-height: calc(100vh - 108px);
			overflow-y: auto;
		}
		
		.json-item{
			display: flex;
			flex-direction: row;
			gap: 20px;
			max-width: calc(100% - 10px);
			border-style: solid;
			border-width: 0 0 1px 0;
			border-color: #333;
			padding: 10px 0 10px 0;
			justify-content: center;
			align-items: center;
		}
		
		.book-list{
			overflow-y: auto;
			height: auto;
			max-height: calc(100vh - 160px);
		}
		
		.left-buttons{
			display: flex;
			position: relative;
			margin-top: 20px;
			justify-content: center;
			align-items: center;
			flex-direction: row;
			gap: 20px;
		}
		.left-buttons button{
			padding: 10px;
			border-radius: 10px;
			background-color: #333;
			color: #fff;
			transition: all 0.5s;
		}
		
		.left-buttons button:hover{
			background-color: #555;
		}
		
		
		.left-form{
			max-height: calc(100vh - 200px);
		}
		
		.copy-playlist{
			padding: 10px;
			border-radius: 10px;
			background-color: #333;
			color: #fff;
			width: 100%;
		}
		
		.form-group {
			margin-bottom: 15px;
		}
		.form-group label {
			display: block;
			margin-bottom: 5px;
			color: #fff;
		}
		.form-group input[type="text"], .form-group select {
			box-sizing: border-box;
			width: 100%;
			padding: 10px;
			font-size: 16px;
			color: #fff;
			background-color: #000;
			font-family: "Open Sans", sans-serif;
			border-radius: 6px;
			border: 1px solid #333;
			transition: all 0.5s;
		}
		.form-group input[type="text"]:hover, .form-group select:hover {
			background-color: #333;
		}
		h3 {
			color: #fff;
			margin-top: 20px;
		}
		
		/* book Array Dray */
		.drag-handle {
			cursor: move;
			padding: 5px;
			color: #fff;
		}
		
		.json-item.dragging {
			opacity: 0.5;
		}
		
		
		.main-head, .book-header {
			color: #fff;
			border-style: solid;
			border-width: 1px;
			border-color: #333;
			padding: 5px 10px;
			margin-bottom: 10px;
			cursor: pointer;
			user-select: none;
		}
		
		.book-header {
			cursor: none;
		}
		
		.main-info {
			overflow: hidden;
			transition: max-height 0.3s ease-out;
		}
		
		.arrow {
			float: right;
			transition: transform 0.3s ease-out;
		}
		
		.main-head.active{
			background-color: #333;
		}
		.main-head.active .arrow {
			transform: rotate(45deg);
		}
		
		/* Tabs */
		
		.tabs {
			display: flex;
			border: 1px solid #333;
			margin-bottom: 20px;
		}
		
		.tab-button {
			background-color: #000;
			border: none;
			color: #fff;
			padding: 10px 20px;
			cursor: pointer;
			transition: background-color 0.3s;
		}
		
		.tab-button:hover {
			background-color: #333;
		}
		
		.tab-button.active {
			background-color: #333;
		}
		
		.tab-content {
			display: none;
		}
		
		.tab-content.active {
			display: block;
		}
		
		/* Right Button Container */
		
		.button-container {
			display: flex;
			gap: 10px;
			margin-top: 10px;
		}
		
		.copy-playlist, .save-playlist {
			flex: 1;
			padding: 10px;
			border-radius: 10px;
			background-color: #333;
			color: #fff;
			border: none;
			cursor: pointer;
			transition: background-color 0.3s;
		}
		
		.copy-playlist:hover, .save-playlist:hover {
			background-color: #555;
		}
		
	</style>
</head>
<body>
	<div class="left-half">
		<form class="left-form" method="post">
			<input type="hidden" name="update_order" value="1">
			
			<div class="tabs">
				<button type="button" class="tab-button active" data-tab="main-info">Main Info</button>
				<button type="button" class="tab-button" data-tab="books">Books</button>
			</div>
			
			<div class="tab-content active" id="main-info">
				
				<div class="main-info">
					<div class="form-group">
						<label for="background-image">Background Image URL:</label>
						<input type="text" placeholder="Background Image" id="background-image" name="background-image" value="<?php echo htmlspecialchars($data['background-image']); ?>">
					</div>
					<div class="form-group">
						<label for="site-title">Site Title:</label>
						<input type="text" id="site-title" name="site-title" placeholder="Site Title" value="<?php echo htmlspecialchars($data['site-title']); ?>">
					</div>
					<div class="form-group">
						<label for="description">Description:</label>
						<input type="text" id="description" name="description" placeholder="Site Desciption" value="<?php echo htmlspecialchars($data['description']); ?>">
					</div>
					<div class="form-group">
						<label for="position">Position:</label>
						<select id="position" name="position">
							<option value="above" <?php echo $data['position'] == 'above' ? 'selected' : ''; ?>>Above</option>
							<option value="below" <?php echo $data['position'] == 'below' ? 'selected' : ''; ?>>Below</option>
							<option value="none" <?php echo $data['position'] == 'none' ? 'selected' : ''; ?>>None</option>
						</select>
					</div>
				</div>
				
			</div>
			
			<div class="tab-content" id="books">
				<div class="book-list" id="book-list">
					<?php foreach ($data['books'] as $index => $book): ?>
						<div class="json-item" draggable="true" data-index="<?php echo $index; ?>">
							<div class="drag-handle">☰</div>
							<div class="json-inputs">
								<input type="text" name="books[<?php echo $index; ?>][title]" placeholder="Title" value="<?php echo htmlspecialchars($book['title']); ?>">
								<input type="text" name="books[<?php echo $index; ?>][link]" placeholder="Source URL" value="<?php echo htmlspecialchars($book['link']); ?>">
							</div>
							<button class="remove-btn" type="submit" name="remove_item" value="<?php echo $index; ?>">-</button>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="left-buttons">
					<button type="button" id="add-book-btn">+ New Book</button>
					<button type="submit" name="render_json">Render JSON</button>
					<input type="file" id="import-json" accept=".json" style="display: none;">
					<button type="button" id="import-json-btn">Import JSON</button>
				</div>
			
			</div>
		</form>
	</div>
	<div class="right-half">
		<pre><code id="json-output"><?php echo htmlspecialchars($json); ?></code></pre>
		<div class="button-container">
			<button class="copy-playlist" onclick="copyToClipboard()">Copy Playlist</button>
			<button class="save-playlist" onclick="savePlaylist()">Save Playlist</button>
		</div>
	</div>

	<script>
		function copyToClipboard() {
			const jsonOutput = document.getElementById('json-output');
			const tempTextArea = document.createElement('textarea');
			tempTextArea.value = jsonOutput.textContent;
			document.body.appendChild(tempTextArea);
			tempTextArea.select();
			document.execCommand('copy');
			document.body.removeChild(tempTextArea);
			alert('Playlist copied to clipboard!');
		}
		
		const addbookBtn = document.getElementById('add-book-btn');
		addbookBtn.addEventListener('click', () => {
			const bookList = document.getElementById('book-list');
			const newIndex = bookList.children.length;
			const newbook = document.createElement('div');
			newbook.className = 'json-item';
			newbook.draggable = true;
			newbook.dataset.index = newIndex;
			newbook.innerHTML = `
				<div class="drag-handle">☰</div>
				<div class="json-inputs">
					<input type="text" name="books[${newIndex}][title]" placeholder="Title" value="">
					<input type="text" name="books[${newIndex}][link]" placeholder="Source URL" value="">
				</div>
				<button class="remove-btn" type="submit" name="remove_item" value="${newIndex}">-</button>
			`;
			bookList.appendChild(newbook);
			updatebookOrder();
		});
		
		/* Drag JS */
		
		document.addEventListener('DOMContentLoaded', (event) => {
			// Tabs
			
			const tabButtons = document.querySelectorAll('.tab-button');
			const tabContents = document.querySelectorAll('.tab-content');
			
			tabButtons.forEach(button => {
				button.addEventListener('click', () => {
					const tabId = button.getAttribute('data-tab');
					
					tabButtons.forEach(btn => btn.classList.remove('active'));
					tabContents.forEach(content => content.classList.remove('active'));
			
					button.classList.add('active');
					document.getElementById(tabId).classList.add('active');
				});
			});
			
			const bookList = document.getElementById('book-list');
			let draggingEle;
		
			bookList.addEventListener('dragstart', (e) => {
				draggingEle = e.target.closest('.json-item');
				e.dataTransfer.setData('text/plain', draggingEle.dataset.index);
				setTimeout(() => {
					draggingEle.classList.add('dragging');
				}, 0);
			});
		
			bookList.addEventListener('dragend', (e) => {
				draggingEle.classList.remove('dragging');
			});
		
			bookList.addEventListener('dragover', (e) => {
				e.preventDefault();
				const closestItem = e.target.closest('.json-item');
				if (closestItem && closestItem !== draggingEle) {
					const rect = closestItem.getBoundingClientRect();
					const midY = rect.top + rect.height / 2;
					if (e.clientY < midY) {
						bookList.insertBefore(draggingEle, closestItem);
					} else {
						bookList.insertBefore(draggingEle, closestItem.nextSibling);
					}
				}
			});
		
			bookList.addEventListener('dragend', (e) => {
				updatebookOrder();
			});
		
			// Update the updatebookOrder function
			function updatebookOrder() {
				const items = bookList.querySelectorAll('.json-item');
				items.forEach((item, index) => {
					item.dataset.index = index;
					item.querySelectorAll('input').forEach(input => {
						const name = input.getAttribute('name');
						input.setAttribute('name', name.replace(/\d+/, index));
					});
				});
			
				// Use AJAX to submit the form
				const formData = new FormData(document.querySelector('.left-form'));
				fetch(window.location.href, {
					method: 'POST',
					body: formData
				})
				.then(response => response.text())
				.then(html => {
					const parser = new DOMParser();
					const doc = parser.parseFromString(html, 'text/html');
					const jsonOutput = doc.getElementById('json-output');
					if (jsonOutput) {
						document.getElementById('json-output').textContent = jsonOutput.textContent;
					} else {
						console.error('JSON output element not found in response');
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('An error occurred while updating the JSON. Please try again.');
				});
			}
			
			// Import
			const importJsonBtn = document.getElementById('import-json-btn');
			const importJsonInput = document.getElementById('import-json');
			
			importJsonBtn.addEventListener('click', () => {
				importJsonInput.click();
			});
			
			importJsonInput.addEventListener('change', (e) => {
				const file = e.target.files[0];
				if (file) {
					const reader = new FileReader();
					reader.onload = function(e) {
						try {
							const importedData = JSON.parse(e.target.result);
							updateFormWithImportedData(importedData);
						} catch (error) {
							console.error('Error parsing JSON:', error);
							alert('Error parsing JSON file. Please make sure it\'s a valid JSON file.');
						}
					};
					reader.readAsText(file);
				}
			});
			
			function updateFormWithImportedData(data) {
				// Update main info
				document.getElementById('background-image').value = data['background-image'] || '';
				document.getElementById('site-title').value = data['site-title'] || '';
				document.getElementById('description').value = data['description'] || '';
				document.getElementById('position').value = data['position'] || 'above';
			
				// Update books
				const bookList = document.getElementById('book-list');
				bookList.innerHTML = ''; // Clear existing books
			
				if (data.books && Array.isArray(data.books)) {
					data.books.forEach((book, index) => {
						const newbook = document.createElement('div');
						newbook.className = 'json-item';
						newbook.draggable = true;
						newbook.dataset.index = index;
						newbook.innerHTML = `
							<div class="drag-handle">☰</div>
							<div class="json-inputs">
								<input type="text" name="books[${index}][title]" placeholder="Title" value="${book.title || ''}">
								<input type="text" name="books[${index}][link]" placeholder="Source URL" value="${book.link || ''}">
							</div>
							<button class="remove-btn" data-index="<?php echo $index; ?>">-</button>
						`;
						bookList.appendChild(newbook);
					});
				}
			
				// Update JSON output
				updatebookOrder();
			}
			// Optional: Add an arrow indicator
			mainHead.innerHTML += ' <span class="arrow">+</span>';
			
		});
		
		// Function to handle item removal
		function handleRemove(event) {
			if (event.target.classList.contains('remove-btn')) {
				const item = event.target.closest('.json-item');
				if (item) {
					item.remove();
					updatebookOrder();
				}
			}
		}
		
		const bookList = document.getElementById('book-list');
		bookList.addEventListener('click', handleRemove);
		
		// Save File
		function savePlaylist() {
			const jsonContent = document.getElementById('json-output').textContent;
			const blob = new Blob([jsonContent], { type: 'application/json' });
			const url = URL.createObjectURL(blob);
			
			const a = document.createElement('a');
			a.href = url;
			a.download = 'playlist.json';
			document.body.appendChild(a);
			a.click();
			document.body.removeChild(a);
			URL.revokeObjectURL(url);
		}
		
	</script>
</body>
</html>