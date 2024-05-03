<div id="footer-links">

	<?php if ( has_nav_menu( 'footer_menu' ) ) : ?>
		<ul class="footer-menu">
			<?php wp_nav_menu( array( 'container' => false, 'menu_id' => 'nav', 'theme_location' => 'footer_menu', 'items_wrap' => '%3$s', 'depth' => -1 ) ); ?>
			<a href="https://play.google.com/store/apps/details?id=uz.esonuz.boqiyuz">
				<img style="margin-bottom: -10px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTnr0L-oYL5nkxRylz8hxNYD28RdsotoETx3aJ8FXThN9CvydZupiIOmVZpM7EjoAvcog&usqp=CAU" width="100px" />
			</a>
		</ul>
		
	<?php endif; ?>

	<?php get_template_part( 'template-parts/footer-social-links' ); ?>

	<a href="#scroll-to" class="to-top scroll"><i class="fa fa-angle-up"></i></a>

</div>