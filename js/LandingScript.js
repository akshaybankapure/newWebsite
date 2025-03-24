function updateLayout() {
    const container = document.querySelector('.container');
    const cutoutLayer = document.querySelector('.cutout-layer');
    const logo = document.querySelector('.logo');
    
    const width = container.offsetWidth;
    const height = container.offsetHeight;
    
    if (width>=800){
        // Cutout layer logic
        const cutoutStartX = width * 0.3;
        const cutoutStartY = height * 0.53;
        const cutoutEndY = height * 0.62;
        
        const path = `
            M 0 0 
            H ${width} 
            V ${height} 
            H 0 
            V 0 
            M ${cutoutStartX} ${cutoutStartY} 
            V ${cutoutEndY} 
            L ${width} ${height} 
            V ${height * 0.1} 
            Z
        `.replace(/\s+/g, ' ').trim();

        cutoutLayer.style.clipPath = `path('${path}')`;
        
        // Logo positioning logic
        const logoAspectRatio = 340.87 / 269.93; // Width / Height of the SVG
        const logoHeightRatio = 0.15; // Reduced from 0.18 to make the logo smaller
        const logoHeight = Math.min(height * logoHeightRatio, width * logoHeightRatio / logoAspectRatio);
        const logoWidth = logoHeight * logoAspectRatio;

        const logoTop = cutoutStartY - (logoHeight * 0.01); // Adjusted to move the logo up slightly
        const logoLeft = cutoutStartX - (logoWidth * 1.2); // Adjusted to move the logo left slightly

        logo.style.width = `${logoWidth*logoAspectRatio}px`;
        logo.style.height = `${logoHeight*logoAspectRatio}px`;
        logo.style.top = `${logoTop}px`;
        logo.style.left = `${logoLeft-(height*0.03)}px`;
    }
}

window.addEventListener('load', updateLayout);
window.addEventListener('resize', updateLayout);