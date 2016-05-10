			<footer class="footer site-footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">

				<div id="inner-footer" class="wrap cf">

					<nav role="navigation">
						<?php wp_nav_menu(array(
    					'container' => 'div',                           // enter '' to remove nav container (just make sure .footer-links in _base.scss isn't wrapping)
    					'container_class' => 'footer-links cf',         // class of container (should you choose to use it)
    					'menu' => __( 'Footer Links', 'bonestheme' ),   // nav name
    					'menu_class' => 'nav footer-nav cf',            // adding custom nav class
    					'theme_location' => 'footer-links',             // where it's located in the theme
    					'before' => '',                                 // before the menu
    					'after' => '',                                  // after the menu
    					'link_before' => '',                            // before each link
    					'link_after' => '',                             // after each link
    					'depth' => 0,                                   // limit the depth of the nav
    					'fallback_cb' => 'bones_footer_links_fallback'  // fallback function
						)); ?>
					</nav>

					<div class="footer-widget-container">
						<div class="footer-logo">
							<p><img class="alignnone wp-image-93 size-full" src="<?php print get_stylesheet_directory_uri(); ?>/library/images/lwm_logo_white_text.png" alt="Lexington Wealth Management"></p>
						</div>
						<div class="location">
							<h4>Office</h4>
							<p>12 Waltham St<br>
								Lexington, MA 02421<br>
								Phone: (781) 860-7745<br>
								Fax: (781) 862-4392</p>
						</div>
						<div class="contact">
							<h4>Call toll free</h4>
							<p>(800) 626-1566</p>
							<h4>Email us</h4>
							<p>info@lexingtonwealth.com</p>
							<p><a href="#">Sign up for our Newsletter</a></p>
						</div>
						<div class="social-links">
							<!--<div class="signup-form"> <?php //print do_shortcode('[contact-form-7 id="45" title="Newsletter Signup"]'); ?></div>-->
							<img class="alignnone size-full wp-image-43 ria-logo" src="<?php print get_stylesheet_directory_uri(); ?>/library/images/ria_logo@2x.png" alt="ria_logo"  />
							<a href="http://www.linkedin.com/company/lexington-wealth-management"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
							<a href="https://twitter.com/#!/lexingtonwealth"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>

						</div>
						<div class="copyright">&copy; 2016 Lexington Wealth Management</div>
					</div>

				</div>



			</footer>

		</div>

		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>

	</body>

</html> <!-- end of site. what a ride! -->
