<?php global $woocommerce; ?>
<div id="mobile-header" class="table <?php echo ( boss_get_option( 'boss_adminbar' ) ) ? 'with-adminbar' : ''; ?>">

	<!-- Toolbar for Mobile -->
	<div class="mobile-header-outer"> 

		<div class="mobile-header-inner header-activity">

			<!-- Shop page -->
			<ul class="header-mobile-menu menu-main">
				<?php
				echo  $titlebar_menu = wp_nav_menu( array(
					'theme_location' => 'header_mobile_menu',
					'items_wrap'	 => '%3$s',
					'fallback_cb'	 => '',
					'echo'			 => false,
					'container'		 => false,
					'walker'		 => new BuddybossWalker
				) );
				?>
				</ul>
            <!-- Woocommerce Notification for the users-->
            <?php // echo boss_mobile_cart_icon_html(); ?>

			
		</div>

	</div>

</div><!-- #mobile-header -->