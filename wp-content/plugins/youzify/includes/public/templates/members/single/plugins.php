<?php
/**
 * BuddyPress - Users Plugins Template
 *
 * 3rd-party plugins should use this template to easily add template
 * support to their plugins for the members component.
 *
 */

/**
 * Fires at the start of the member plugin template.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_plugin_template' ); ?>

<?php if ( ! bp_is_current_component_core() && youzify_is_current_tab_has_children() ) : ?>
<div class="item-list-tabs youzify-default-subnav no-ajax" id="subnav" aria-label="<?php esc_attr_e( 'Member secondary navigation', 'youzify' ); ?>" role="navigation">
	<ul>
		<?php bp_get_options_nav(); ?>

		<?php

		/**
		 * Fires inside the member plugin template nav <ul> tag.
		 *
		 * @since 1.2.2
		 */
		do_action( 'bp_member_plugin_options_nav' ); ?>
	</ul>
</div><!-- .item-list-tabs -->

<?php endif; ?>
<?php if ( has_action( 'bp_template_title' ) ) : ?>
	<h3><?php

	/**
	 * Fires inside the member plugin template <h3> tag.
	 *
	 * @since 1.0.0
	 */
	do_action( 'bp_template_title' ); ?></h3>

<?php endif; ?>

<?php

/**
 * Fires and displays the member plugin template content.
 *
 * @since 1.0.0
 */
do_action( 'bp_template_content' ); ?>

<?php

/**
 * Fires at the end of the member plugin template.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_member_plugin_template' );
