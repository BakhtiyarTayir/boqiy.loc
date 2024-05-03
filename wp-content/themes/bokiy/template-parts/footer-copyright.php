<?php
$boss_copyright	 = boss_get_option( 'boss_copyright' );
$show_copyright	 = boss_get_option( 'footer_copyright_content' );

if ( $show_copyright && $boss_copyright ) {
	?>

	<div class="footer-credits footer-credits-single">
		<?php dynamic_sidebar('copyright'); ?>
	</div>

	<?php
}