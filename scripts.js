document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.slide');
    const body = document.getElementById('body');
    const menuItems = document.querySelectorAll('.menu-item');
    const menuItem = document.querySelectorAll('.menu-item');
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');
    const menuToggle = document.getElementById('menu-toggle');
    const sliderMenu = document.getElementById('slider-menu');
    const progressBar = document.getElementById('progress-bar');
    const slider = document.getElementById('slider');
    const downloadBtn = document.getElementById('download-btn');
    const downloadWindow = document.getElementById('download-window');
    const infoButton = document.getElementById('infoButton');
    const infoWindow = document.getElementById('info-window');
    const closeInfo = document.getElementById('close-info');
    let currentSlide = 0;
    
    
    function closeAll() {
        sliderMenu.classList.remove('show');
        menuToggle.classList.remove('show');
        slider.classList.remove('show');
        body.classList.remove('show');
        infoWindow.classList.remove('show');
        if (downloadBtn) {
            downloadWindow.classList.remove('show');
        }
    }
    
    if (downloadBtn) {
        downloadBtn.addEventListener('click', function() {
           downloadWindow.classList.toggle('show');
        });
    }
    
    if (infoButton) {
        infoButton.addEventListener('click', function() {
           infoWindow.classList.toggle('show');
           slider.classList.toggle('show');
           body.classList.toggle('show');
           if (downloadBtn) {
               downloadWindow.classList.remove('show');
           }
        });
    }
    if (closeInfo) {
    closeInfo.addEventListener('click', function() {
        closeAll();
    });
    }
    
    menuToggle.addEventListener('click', function() {
        sliderMenu.classList.toggle('show');
        menuToggle.classList.toggle('show');
        if(slider){
            slider.classList.toggle('show');
            }
        body.classList.toggle('show');
        if (downloadBtn) {
            downloadWindow.classList.remove('show');
        }
    });

    if(slider){
                slider.addEventListener('click', function() {
                    closeAll();
                });
       
    
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove('active');
                menuItems[i].classList.remove('active');
                if (i === index) {
                    slide.classList.add('active');
                    menuItems[i].classList.add('active');
                    slide.style.opacity = 0;
                    setTimeout(() => slide.style.opacity = 1, 100);
                }
            });
            updateProgressBar(index);
            // Scroll to the top of the slider or document when changing slides.
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
            document.body.scrollTop = 0; // For Safari
        }
        
        if(progressBar){
        function updateProgressBar(index) {
            const progress = ((index + 1) / slides.length) * 100;
            progressBar.style.width = `${progress}%`;
        }
        }
    }
    function navigateSlides(direction) {
        if (direction === 'next') {
            currentSlide = (currentSlide + 1) % slides.length;
        } else if (direction === 'prev') {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        }
        showSlide(currentSlide);
    }
    if(prevButton){
        prevButton.addEventListener('click', () => navigateSlides('prev'));
    }
    if(nextButton){
    nextButton.addEventListener('click', () => navigateSlides('next'));
    }
    
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            closeAll();
            const slideIndex = parseInt(this.getAttribute('data-slide'));
            currentSlide = slideIndex;
            showSlide(currentSlide);
        });
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === "ArrowRight") {
            navigateSlides('next');
        } else if (e.key === "ArrowLeft") {
            navigateSlides('prev');
        }
    });
 if(slider){
    // Initialize the slider
    showSlide(currentSlide);
}
});
