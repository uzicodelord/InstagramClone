let sliderImages = document.querySelectorAll('.slider-image');
let currentImage = 0;
setInterval(() => {
    sliderImages[currentImage].classList.remove('active');
    currentImage = (currentImage + 1) % sliderImages.length;
    sliderImages[currentImage].classList.add('active');
}, 3000);
