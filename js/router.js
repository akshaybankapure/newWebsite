// Router configuration
const routes = {
    '/': {
        page: 'home',
        script: 'js/pages/home.js'
    },
    '/portfolio': {
        page: 'portfolio',
        script: 'js/pages/portfolio.js'
    },
    '/services': {
        page: 'services',
        script: 'js/pages/services.js'
    },
    '/services/character-concept': {
        page: 'service-detail',
        script: 'js/pages/service-detail.js'
    },
    '/services/location-concept': {
        page: 'service-detail',
        script: 'js/pages/service-detail.js'
    },
    '/services/storyboard': {
        page: 'service-detail',
        script: 'js/pages/service-detail.js'
    },
    '/services/motion-poster': {
        page: 'service-detail',
        script: 'js/pages/service-detail.js'
    },
    '/services/title-design': {
        page: 'service-detail',
        script: 'js/pages/service-detail.js'
    },
    '/services/vfx': {
        page: 'service-detail',
        script: 'js/pages/service-detail.js'
    },
    '/publication': {
        page: 'publication',
        script: 'js/pages/publication.js'
    },
    '/contact': {
        page: 'contact',
        script: 'js/pages/contact.js'
    }
};

// Page loader
class PageLoader {
    constructor() {
        this.currentPage = null;
        this.currentScript = null;
        this.mainContent = document.getElementById('main-content');
        this.setupEventListeners();
    }

    setupEventListeners() {
        // Handle browser navigation events
        window.addEventListener('popstate', (e) => {
            this.loadPage(window.location.pathname);
        });

        // Handle link clicks
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (link && !link.hasAttribute('data-no-swup')) {
                e.preventDefault();
                const href = link.getAttribute('href');
                if (href && href.startsWith('/')) {
                    this.loadPage(href);
                    window.history.pushState({}, '', href);
                }
            }
        });
    }

    async loadPage(path) {
        try {
            const route = routes[path] || routes['/'];
            const pageName = route.page;
            
            // Load page content
            const response = await fetch(`/pages/${pageName}.html`);
            if (!response.ok) throw new Error('Page not found');
            
            const content = await response.text();
            this.updateContent(content);

            // Load and execute page-specific script
            if (route.script) {
                await this.loadScript(route.script);
            }

            // Update active menu items
            this.updateActiveMenu(path);
        } catch (error) {
            console.error('Error loading page:', error);
            // Handle 404 or other errors
            this.handleError(error);
        }
    }

    updateContent(content) {
        // Update main content
        this.mainContent.innerHTML = content;

        // Reinitialize common components
        this.initializeCommonComponents();
    }

    async loadScript(scriptPath) {
        // Remove previous page script if exists
        if (this.currentScript) {
            this.currentScript.remove();
        }

        // Create and load new script
        const script = document.createElement('script');
        script.src = scriptPath;
        script.async = true;
        document.body.appendChild(script);
        this.currentScript = script;

        // Wait for script to load
        await new Promise((resolve, reject) => {
            script.onload = resolve;
            script.onerror = reject;
        });
    }

    initializeCommonComponents() {
        // Reinitialize any common components that need to be set up after content changes
        // For example, reinitialize tooltips, dropdowns, etc.
    }

    updateActiveMenu(path) {
        // Update active menu items based on current path
        const menuItems = document.querySelectorAll('.absoftz-main-menu a');
        menuItems.forEach(item => {
            item.parentElement.classList.remove('absoftz-active');
            if (item.getAttribute('href') === path) {
                item.parentElement.classList.add('absoftz-active');
            }
        });
    }

    handleError(error) {
        // Handle different types of errors
        if (error.message === 'Page not found') {
            this.loadPage('/404');
        } else {
            // Handle other types of errors
            console.error('Error:', error);
        }
    }
}

// Initialize router when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.router = new PageLoader();
    router.loadPage(window.location.pathname);
}); 