let currentIndex = 0;
let screenshots = [];

function initScreenshotCarousel(screenshotData) {
    screenshots = screenshotData;
    if (screenshots.length > 0) {
        updateMainImage();
    }
}

function updateMainImage() {
    const mainImage = document.getElementById('main-screenshot');
    if (mainImage && screenshots.length > 0) {
        mainImage.src = screenshots[currentIndex].image;
    }
}

function nextImage() {
    currentIndex = (currentIndex + 1) % screenshots.length;
    updateMainImage();
}

function prevImage() {
    currentIndex = (currentIndex - 1 + screenshots.length) % screenshots.length;
    updateMainImage();
}

document.addEventListener('DOMContentLoaded', () => {
    const leftArrow = document.querySelector('.arrow-left');
    const rightArrow = document.querySelector('.arrow-right');

    if (leftArrow) leftArrow.addEventListener('click', prevImage);
    if (rightArrow) rightArrow.addEventListener('click', nextImage);

    const screenshotDataElement = document.getElementById('screenshot-data');
    if (screenshotDataElement) {
        const screenshotData = JSON.parse(screenshotDataElement.textContent);
        initScreenshotCarousel(screenshotData);
    }
});
