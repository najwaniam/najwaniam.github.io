// Toggle the hamburger menu
const hamburger = document.getElementById('hamburger');
const nav = document.querySelector('nav');

hamburger.addEventListener('click', () => {
  nav.classList.toggle('active');
});

// Dark mode toggle
const darkModeToggle = document.getElementById('dark-mode-toggle');
const darkModeIcon = darkModeToggle.querySelector('i');

function setDarkMode(isDark) {
  document.body.classList.toggle('dark-mode', isDark);
  localStorage.setItem('darkMode', isDark);
  updateDarkModeIcon(isDark);
}

function updateDarkModeIcon(isDark) {
  darkModeIcon.className = isDark ? 'fa-solid fa-moon' : 'fa-solid fa-sun';
}

darkModeToggle.addEventListener('click', () => {
  const isDark = !document.body.classList.contains('dark-mode');
  setDarkMode(isDark);
});

// Check for saved dark mode preference or set default to dark
const savedDarkMode = localStorage.getItem('darkMode');
setDarkMode(savedDarkMode === null ? true : savedDarkMode === 'true');

// Slideshow functionality
let slideIndex = 0;
const slides = document.getElementsByClassName("mySlides");

function showSlides() {
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides, 5000); // Change image every 5 seconds
}

// Start the slideshow when the page loads
if (slides.length > 0) {
  showSlides();
}

// Function to move to the next or previous slide
function plusSlides(n) {
  slideIndex += n - 1;
  showSlides();
}

document.getElementById('teamForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the form from submitting immediately
  
  // Display pop-up message
  alert('Tim Anda Berhasil Didaftarkan');
  
  // Submit the form after showing the message
  this.submit();
});