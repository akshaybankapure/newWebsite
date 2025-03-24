// Home page specific JavaScript
class HomePage {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeAnimations();
        this.setupScrollEffects();
    }

    setupEventListeners() {
        // Handle scroll down button
        const scrollDownBtn = document.querySelector('.absoftz-circle-text');
        if (scrollDownBtn) {
            scrollDownBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const aboutSection = document.getElementById('about');
                if (aboutSection) {
                    aboutSection.scrollIntoView({ behavior: 'smooth' });
                }
            });
        }

        // Handle "What we do" button
        const whatWeDoBtn = document.querySelector('a[href="services.html"]');
        if (whatWeDoBtn) {
            whatWeDoBtn.addEventListener('click', (e) => {
                e.preventDefault();
                router.navigate('/services');
            });
        }

        // Handle "View works" button
        const viewWorksBtn = document.querySelector('a[href="portfolio-1.html"]');
        if (viewWorksBtn) {
            viewWorksBtn.addEventListener('click', (e) => {
                e.preventDefault();
                router.navigate('/portfolio');
            });
        }
    }

    initializeAnimations() {
        // Initialize GSAP animations
        gsap.from('.absoftz-banner-content', {
            duration: 1,
            y: 100,
            opacity: 0,
            ease: 'power4.out'
        });

        // Animate service cards on scroll
        ScrollTrigger.batch('.absoftz-service-card-sm', {
            onEnter: batch => gsap.to(batch, {
                opacity: 1,
                y: 0,
                stagger: 0.15,
                overwrite: true
            }),
            start: 'top 80%'
        });
    }

    setupScrollEffects() {
        // Setup scroll progress bar
        const progressBar = document.querySelector('.absoftz-progress');
        if (progressBar) {
            window.addEventListener('scroll', () => {
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                progressBar.style.width = scrolled + '%';
            });
        }
    }
}

// Initialize the home page when the script loads
document.addEventListener('DOMContentLoaded', () => {
    new HomePage();
}); 