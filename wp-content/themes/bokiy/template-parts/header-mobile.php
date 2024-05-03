<?php global $woocommerce; ?>
<div id="mobile-header" class="table <?php echo ( boss_get_option( 'boss_adminbar' ) ) ? 'with-adminbar' : ''; ?>">

	<!-- Toolbar for Mobile -->
	<div class="mobile-header-outer table-cell">

		<div class="mobile-header-inner table">

			<!-- Custom menu trigger button -->
			<div id="custom-nav-wrap" class="btn-wrap">
				<a href="#" id="custom-nav" class="sidebar-btn"><i class="fa fa-bars"></i></a>
			</div>

			<?php
			if ( boss_get_option( 'boss_search_instead' ) && is_user_logged_in() ) {
				echo get_search_form();
			} else {
				
			?>

					<div id="mobile-logo" class="table-cell">
					<?php if ( is_user_logged_in() || (!is_user_logged_in() && buddyboss_is_bp_active() ) ) {?>
						<a href="<?php echo bp_core_get_user_domain( get_current_user_id() ); ?>/activity/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php } else {?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php }?>
						
							<img class="large" src="<?php echo get_template_directory_uri().'/images/white-logo.png'; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"> Boqiy
						</a>
					</div>
			<?php			
			}
			?>
			<!-- search form -->
			<div id="mobile-search" class="search-form ">
				<div id="titlebar-search">
					<?php get_template_part( 'searchform', 'mobile' );  ?>
					<a href="#" id="mobile-search-open" class="sidebar-btn table-cell" title="<?php _e( 'Search', 'boss' ); ?>"><i class="fa fa-search"></i></a>
				</div><!-- #titlebar-search-->   
			</div><!--.search-form-->
           
	

            <!-- Woocommerce Notification for the users-->
            <?php echo boss_mobile_cart_icon_html(); ?>

			<!-- Profile menu trigger button -->
			<?php if ( is_user_logged_in() || (!is_user_logged_in() && buddyboss_is_bp_active() ) ) { ?>

				<div id="profile-nav-wrap" class="btn-wrap">
					<a href="#" id="profile-nav" class="sidebar-btn table-cell">
						<i class="fa fa-user"></i>
						<span id="ab-pending-notifications-mobile" class="pending-count no-alert"></span>
					</a>
				</div>

			<?php } ?>
			<div class="header-mobile">
				<nav class="navigation">
					<ul class="menu-main">
					<?php
					echo  $titlebar_menu = wp_nav_menu( array(
						'theme_location' => 'header_menu',
						'items_wrap'	 => '%3$s',
						'fallback_cb'	 => '',
						'echo'			 => false,
						'container'		 => false,
						'walker'		 => new BuddybossWalker
					) );
					?>
					</ul>
				</nav>
			</div>



		</div>

	</div>

</div><!-- #mobile-header -->