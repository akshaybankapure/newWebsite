// Service detail page specific JavaScript
class ServiceDetailPage {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeAnimations();
        this.setupImageGallery();
    }

    setupEventListeners() {
        // Handle back to services button
        const backButton = document.querySelector('.absoftz-back-to-services');
        if (backButton) {
            backButton.addEventListener('click', (e) => {
                e.preventDefault();
                router.navigate('/services');
            });
        }

        // Handle contact button
        const contactButton = document.querySelector('.absoftz-contact-button');
        if (contactButton) {
            contactButton.addEventListener('click', (e) => {
                e.preventDefault();
                router.navigate('/contact');
            });
        }
    }

    initializeAnimations() {
        // Animate service content on scroll
        ScrollTrigger.batch('.absoftz-service-content', {
            onEnter: batch => gsap.to(batch, {
                opacity: 1,
                y: 0,
                stagger: 0.15,
                overwrite: true
            }),
            start: 'top 80%'
        });

        // Animate service images
        ScrollTrigger.batch('.absoftz-service-image', {
            onEnter: batch => gsap.to(batch, {
                opacity: 1,
                scale: 1,
                stagger: 0.15,
                overwrite: true
            }),
            start: 'top 80%'
        });
    }

    setupImageGallery() {
        // Initialize Fancybox for image gallery
        Fancybox.bind('[data-fancybox="gallery"]', {
            // Custom options
            loop: true,
            buttons: [
                "zoom",
                "slideShow",
                "fullScreen",
                "close"
            ],
            animationEffect: "fade"
        });
    }
}

// Initialize the service detail page when the script loads
document.addEventListener('DOMContentLoaded', () => {
    new ServiceDetailPage();
}); 