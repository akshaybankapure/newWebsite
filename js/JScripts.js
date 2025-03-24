document.addEventListener('DOMContentLoaded', (event) => {
  // Get a reference to the logo image
  const logoImg = document.getElementById('logo');

  // Function to change the logo based on viewport width
  function changeLogoBasedOnWidth() {
    // Check viewport width
    const viewportWidth = window.innerWidth || document.documentElement.clientWidth;

    // Check if viewport width is less than 1000px
    if (viewportWidth < 1000) {
      // Change the logo source to white version
      logoImg.src = './img/logo/Logo-h-white.png';
    } else {
      // Change the logo source to black version
      logoImg.src = './img/logo/Logo-h-black.svg';
    }
  }

  // Call the function initially
  changeLogoBasedOnWidth();

  // Listen for window resize events to update the logo
  window.addEventListener('resize', changeLogoBasedOnWidth);
});
