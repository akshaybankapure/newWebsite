// Services page specific JavaScript
class ServicesPage {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeAnimations();
        this.setupServiceCards();
    }

    setupEventListeners() {
        // Handle service card clicks
        const serviceCards = document.querySelectorAll('.absoftz-service-card');
        serviceCards.forEach(card => {
            card.addEventListener('click', (e) => {
                const serviceLink = card.querySelector('a');
                if (serviceLink) {
                    e.preventDefault();
                    router.navigate(serviceLink.getAttribute('href'));
                }
            });
        });
    }

    initializeAnimations() {
        // Animate service cards on scroll
        ScrollTrigger.batch('.absoftz-service-card', {
            onEnter: batch => gsap.to(batch, {
                opacity: 1,
                y: 0,
                stagger: 0.15,
                overwrite: true
            }),
            start: 'top 80%'
        });

        // Animate service details
        ScrollTrigger.batch('.absoftz-service-detail', {
            onEnter: batch => gsap.to(batch, {
                opacity: 1,
                y: 0,
                stagger: 0.15,
                overwrite: true
            }),
            start: 'top 80%'
        });
    }

    setupServiceCards() {
        // Initialize hover effects for service cards
        const cards = document.querySelectorAll('.absoftz-service-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                gsap.to(card, {
                    scale: 1.05,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });

            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    scale: 1,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
        });
    }
}

// Initialize the services page when the script loads
document.addEventListener('DOMContentLoaded', () => {
    new ServicesPage();
}); 