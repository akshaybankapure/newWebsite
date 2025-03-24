// Portfolio page specific JavaScript
class PortfolioPage {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializePortfolioGrid();
    }

    setupEventListeners() {
        // Add portfolio-specific event listeners
        document.querySelectorAll('.portfolio-item').forEach(item => {
            item.addEventListener('click', (e) => {
                this.handlePortfolioItemClick(e);
            });
        });
    }

    initializePortfolioGrid() {
        // Initialize portfolio grid layout
        const grid = document.querySelector('.portfolio-grid');
        if (grid) {
            // Add any portfolio-specific grid initialization
            this.setupMasonryGrid(grid);
        }
    }

    setupMasonryGrid(grid) {
        // Example of setting up a masonry grid
        // You can use libraries like Masonry.js or implement your own
        const items = grid.querySelectorAll('.portfolio-item');
        items.forEach(item => {
            // Add any specific styling or layout logic
        });
    }

    handlePortfolioItemClick(event) {
        const item = event.currentTarget;
        const projectId = item.dataset.projectId;
        
        // Handle portfolio item click
        // You can navigate to project details or show a modal
        console.log(`Portfolio item clicked: ${projectId}`);
    }
}

// Initialize the portfolio page when the script loads
document.addEventListener('DOMContentLoaded', () => {
    new PortfolioPage();
}); 