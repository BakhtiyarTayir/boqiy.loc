<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
?>
</div><!-- #main .wrapper -->

</div><!-- #page -->

</div> <!-- #inner-wrap -->

</div><!-- #main-wrap (Wrap For Mobile) -->

<footer id="colophon" role="contentinfo">

	<?php get_template_part( 'template-parts/footer-widgets' ); ?>

	<div class="footer-inner-bottom">

		<div class="footer-inner">
			<?php get_template_part( 'template-parts/footer-copyright' ); ?>
			<?php get_template_part( 'template-parts/footer-links' ); ?>
			
		</div><!-- .footer-inner -->

	</div><!-- .footer-inner-bottom -->

	<?php do_action( 'bp_footer' ) ?>

</footer><!-- #colophon -->
</div><!-- #right-panel-inner -->
</div><!-- #right-panel -->

</div><!-- #panels -->

<?php wp_footer(); ?>
<script>
window.replainSettings = { id: 'e3fc9812-2dc4-4631-aa66-9c4703937e45' };
(function(u){var s=document.createElement('script');s.async=true;s.src=u;
var x=document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);
})('https://widget.replain.cc/dist/client.js');
</script>
</body>
</html>