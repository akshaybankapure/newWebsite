// Publication page specific JavaScript
class PublicationPage {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeAnimations();
        this.setupPublicationGrid();
    }

    setupEventListeners() {
        // Handle publication card clicks
        const publicationCards = document.querySelectorAll('.absoftz-publication-card');
        publicationCards.forEach(card => {
            card.addEventListener('click', (e) => {
                const link = card.querySelector('a');
                if (link) {
                    e.preventDefault();
                    router.navigate(link.getAttribute('href'));
                }
            });
        });

        // Handle filter buttons
        const filterButtons = document.querySelectorAll('.absoftz-filter-button');
        filterButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const category = button.getAttribute('data-category');
                this.filterPublications(category);
            });
        });
    }

    initializeAnimations() {
        // Animate publication cards on scroll
        ScrollTrigger.batch('.absoftz-publication-card', {
            onEnter: batch => gsap.to(batch, {
                opacity: 1,
                y: 0,
                stagger: 0.15,
                overwrite: true
            }),
            start: 'top 80%'
        });

        // Animate filter buttons
        ScrollTrigger.batch('.absoftz-filter-button', {
            onEnter: batch => gsap.to(batch, {
                opacity: 1,
                x: 0,
                stagger: 0.1,
                overwrite: true
            }),
            start: 'top 80%'
        });
    }

    setupPublicationGrid() {
        // Initialize Masonry grid for publications
        const grid = document.querySelector('.absoftz-publication-grid');
        if (grid) {
            const masonry = new Masonry(grid, {
                itemSelector: '.absoftz-publication-card',
                columnWidth: '.absoftz-publication-card',
                percentPosition: true,
                transitionDuration: '0.3s'
            });

            // Layout Masonry after images are loaded
            imagesLoaded(grid).on('progress', () => {
                masonry.layout();
            });
        }
    }

    filterPublications(category) {
        const cards = document.querySelectorAll('.absoftz-publication-card');
        const buttons = document.querySelectorAll('.absoftz-filter-button');

        // Update active button
        buttons.forEach(button => {
            button.classList.remove('absoftz-active');
            if (button.getAttribute('data-category') === category) {
                button.classList.add('absoftz-active');
            }
        });

        // Filter cards
        cards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });

        // Re-layout grid
        const grid = document.querySelector('.absoftz-publication-grid');
        if (grid) {
            const masonry = Masonry.data(grid);
            if (masonry) {
                masonry.layout();
            }
        }
    }
}

// Initialize the publication page when the script loads
document.addEventListener('DOMContentLoaded', () => {
    new PublicationPage();
}); 