document.addEventListener('DOMContentLoaded', function() {
	const slides = document.querySelectorAll('.slide');
	let activeSlide = 0;
	slides[activeSlide].classList.add('active');

	const menuItems = document.querySelectorAll('#menu ul li');
	menuItems[activeSlide].classList.add('active');

	const menuToggle = document.getElementById('menu-toggle');
	const menu = document.getElementById('menu');
	const slideshow = document.getElementById('slideshow');
	const menuLink = document.querySelectorAll('.menu-link');
	
	// Select all elements with the class 'menu-link'
	const menuLinks = document.querySelectorAll('.menu-link');
	
	// Iterate over each 'menu-link' element
	menuLinks.forEach(link => {
		// Attach a click event listener to each link
		link.addEventListener('click', function() {
			// Select the element with the ID 'slideshow'
			const slideshow = document.getElementById('slideshow');
			
			// Remove the 'menu-active' class from the 'slideshow' element
			slideshow.classList.remove('menu-active');
			menu.classList.remove('show');
		});
	});

	// Event listener for the toggle button
	menuToggle.addEventListener('click', function() {
		menu.classList.toggle('show');
		slideshow.classList.toggle('menu-active');
	});
	
	// Event listener for the slideshow
	slideshow.addEventListener('click', function() {
		menu.classList.remove('show');
		slideshow.classList.remove('menu-active');
	});
	
	
	// Function to go to a specific slide with scroll to top
	function changeSlide(direction) {
		slides[activeSlide].classList.remove('active');
		menuItems[activeSlide].classList.remove('active');
		activeSlide = (activeSlide + direction + slides.length) % slides.length;
		slides[activeSlide].classList.add('active');
		menuItems[activeSlide].classList.add('active');
	
		// Scroll to the top of the slideshow element
		scrollToSlide();
	}
	
	// Utility function to scroll to the top of the current active slide
	function scrollToSlide() {
		// Assuming the slideshow container is the scroll target
		slideshow.scrollIntoView({ });
	}


	// Event listeners for previous and next buttons
	document.getElementById('prev').addEventListener('click', function() {
		changeSlide(-1);
	});

	document.getElementById('next').addEventListener('click', function() {
		changeSlide(1);
	});

	// New: Keyboard navigation with scroll to top functionality
	document.addEventListener('keydown', function(event) {
		if (event.key === 'ArrowRight') {
			changeSlide(1);
			// No need to call scrollToSlide here since changeSlide already includes it
		} else if (event.key === 'ArrowLeft') {
			changeSlide(-1);
			// No need to call scrollToSlide here since changeSlide already includes it
		}
	});


	// Menu item click to go to slide
	menuItems.forEach((item, index) => {
		item.addEventListener('click', () => {
			goToSlide(index);
		});
	});

	function goToSlide(index) {
		slides[activeSlide].classList.remove('active');
		menuItems[activeSlide].classList.remove('active');
		activeSlide = index;
		slides[activeSlide].classList.add('active');
		menuItems[activeSlide].classList.add('active');
	}
	
	
});
