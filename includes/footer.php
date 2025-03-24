    </main>
    
    <!-- Footer -->
    <footer class="absoftz-footer">
        <div class="absoftz-footer-inner">
            <!-- Newsletter -->
            <div class="absoftz-newsletter">
                <h3>Subscribe to our newsletter</h3>
                <form id="newsletter-form" action="<?php echo SITE_URL; ?>/subscribe.php" method="post">
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
            
            <!-- Footer Menu -->
            <div class="absoftz-footer-menu">
                <div class="absoftz-footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="<?php echo SITE_URL; ?>">Home</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/portfolio">Portfolio</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services">Services</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/publication">Publication</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="absoftz-footer-legal">
                    <h3>Legal</h3>
                    <ul>
                        <li><a href="<?php echo SITE_URL; ?>/privacy-policy">Privacy Policy</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/terms">Terms & Conditions</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/cookie-policy">Cookie Policy</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/careers">Careers</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="absoftz-footer-contact">
                <h3>Contact Us</h3>
                <p><i class="fa fa-map-marker"></i> <?php echo $contact_address; ?></p>
                <p><i class="fa fa-phone"></i> <?php echo $contact_phone; ?></p>
                <p><i class="fa fa-envelope"></i> <?php echo $contact_email; ?></p>
            </div>
            
            <!-- Social Links -->
            <div class="absoftz-social-links">
                <a href="<?php echo getSetting('social_facebook'); ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                <a href="<?php echo getSetting('social_twitter'); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                <a href="<?php echo getSetting('social_instagram'); ?>" target="_blank"><i class="fa fa-instagram"></i></a>
                <a href="<?php echo getSetting('social_linkedin'); ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
            </div>
            
            <!-- Copyright -->
            <div class="absoftz-copyright">
                <p>&copy; <?php echo date('Y'); ?> <?php echo $site_title; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Hidden Elements -->
    <div class="absoftz-hidden-elements">
        <div class="absoftz-dodecahedron"></div>
        <div class="absoftz-dodecahedron"></div>
        <div class="absoftz-dodecahedron"></div>
    </div>
    
    <!-- JavaScript -->
    <script src="<?php echo SITE_URL; ?>/js/jquery.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/swiper.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/fancybox.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/gsap.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/ScrollTrigger.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/main.js"></script>
    
    <?php if (isset($page_script)): ?>
    <script src="<?php echo SITE_URL; ?>/js/pages/<?php echo $page_script; ?>"></script>
    <?php endif; ?>
    
    <script>
        // Initialize GSAP ScrollTrigger
        gsap.registerPlugin(ScrollTrigger);
        
        // Load header and footer content
        document.addEventListener('DOMContentLoaded', function() {
            // Create dodecahedron elements
            const dodecahedrons = document.querySelectorAll('.absoftz-dodecahedron');
            dodecahedrons.forEach((dodecahedron, index) => {
                // Add your dodecahedron creation code here
            });
        });
    </script>
</body>
</html> 