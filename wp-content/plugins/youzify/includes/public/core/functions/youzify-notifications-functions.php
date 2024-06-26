<?php

/**
 * Register Notification CallBack
 */
add_action( 'init', 'youzify_register_notifications' );

function youzify_register_notifications() {

    $buddypress = buddypress();

    $buddypress->youzify = new stdClass;

	// Add notification callback function
    $buddypress->youzify->notification_callback = 'youzify_format_notifications';

    $buddypress->active_components['youzify'] = 1;

    unset( $buddypress );

}

/**
 * Add User Like Notification.
 */
function youzify_add_user_like_notification( $activity_id, $user_id = 0 ) {

    // Get Activity.
    $activity = new BP_Activity_Activity( $activity_id );

	if ( $activity->user_id == $user_id ) {
		return;
	}

    bp_notifications_add_notification(
    	array(
	        'user_id'           => $activity->user_id,
	        'item_id'           => $activity_id,
	        'secondary_item_id' => $user_id,
	        'component_name'    => 'youzify',
	        'component_action'  => 'youzify_new_like',
	        'date_notified'     => bp_core_current_time(),
	        'is_new'            => 1,
    	)
    );

}

add_action( 'bp_activity_add_user_favorite', 'youzify_add_user_like_notification', 10, 2 );

/**
 * Set Youzify Notification.
 */
function youzify_format_notifications( $action, $item_id, $secondary_item_id, $total_items, $format = 'string' ) {

    // New custom notifications
    switch ( $action ) {

        case 'youzify_new_like':

            if ( ! bp_is_active( 'activity' ) ) {
                return '';
            }

            if ( 1 == $total_items ) {

                $custom_text = sprintf( __( '%s liked your post', 'youzify' ), bp_core_get_user_displayname( $secondary_item_id ) );
                $custom_title = sprintf( __( '%s liked your post', 'youzify' ), bp_core_get_user_displayname( $secondary_item_id ) );
                $activity_link      = bp_activity_get_permalink( $item_id ) ;

                $custom_link = wp_nonce_url( add_query_arg( array( 'action' => 'youzify_new_like_mark_read', 'activity_id' => $item_id ), $activity_link ), 'youzify_new_like_mark_read_' . $item_id );

            } else {

                $custom_text = sprintf( __( '%d more users liked your post', 'youzify' ), $total_items );
                $custom_title = sprintf( __( '%d more users liked your post', 'youzify' ), $total_items );

                if ( bp_is_active( 'notifications' ) ) {
                    $custom_link = bp_get_notifications_permalink();
                } else {
                    $link = bp_loggedin_user_domain() . $bp->follow->followers->slug . '/?new';
                }
            }

            $custom_text = apply_filters( 'youzify_new_like_notification_custom_text', $custom_text, $item_id );

            // WordPress Toolbar
            if ( 'string' === $format ) {
                return apply_filters( 'youzify_format_new_like_notifications', '<a href="' . esc_url( $custom_link ) . '">' . $custom_text . '</a>', $custom_text, $custom_link );
            } else {
                return apply_filters( 'youzify_format_new_like_notifications', array(
                    'text' => $custom_text,
                    'link' => $custom_link
                ), $custom_link, (int) $total_items, $custom_text, $custom_title );
            }
            break;

        case 'youzify_new_share':

            // Init Vars.
            $link = wp_nonce_url( add_query_arg( array( 'action' => 'youzify_new_share_mark_read', 'activity_id' => $item_id ), bp_activity_get_permalink( $item_id ) ), 'youzify_new_share_mark_read_' . $item_id );

            $title  = sprintf( __( '@%s Shares', 'youzify' ), bp_get_loggedin_user_username() );

            $amount = 'single';

            if ( (int) $total_items > 1 ) {
                $text   = sprintf( __( 'You have %1$d new post shares', 'youzify' ), (int) $total_items );
                $amount = 'multiple';
            } else {
                $text = sprintf( __( '%1$s shared your post', 'youzify' ), bp_core_get_user_displayname( $secondary_item_id ) );
            }

            if ( $format == 'string' ) {
                return apply_filters( 'youzify_format_single_new_share_notifications', '<a href="' . esc_url( $link ) . '">' . esc_html( $text ) . '</a>', $text, $link );
            } else {
                return apply_filters( 'youzify_format_multiple_new_share_notifications', array( 'text' => $text, 'link' => $link ), $text, $link );
            }

            break;

        case 'youzify_new_tag':

            // Init Vars.
            $link = wp_nonce_url( add_query_arg( array( 'action' => 'youzify_new_tag_mark_read', 'activity_id' => $item_id ), bp_activity_get_permalink( $item_id ) ), 'youzify_new_tag_mark_read_' . $item_id );

            $title  = sprintf( __( '@%s Tags', 'youzify' ), bp_get_loggedin_user_username() );

            $amount = 'single';

            if ( (int) $total_items > 1 ) {
                $text   = sprintf( __( 'You have %1$d new tags', 'youzify' ), (int) $total_items );
                $amount = 'multiple';
            } else {
                $text = sprintf( __( '%1$s tagged you', 'youzify' ), bp_core_get_user_displayname( $secondary_item_id ) );
            }

            if ( $format == 'string' ) {
                return apply_filters( 'youzify_format_single_new_tag_notifications', '<a href="' . esc_url( $link ) . '">' . esc_html( $text ) . '</a>', $text, $link );
            } else {
                return apply_filters( 'youzify_format_multiple_new_tag_notifications', array( 'text' => $text, 'link' => $link ), $text, $link );
            }
            break;
    }


    return apply_filters( 'youzify_format_notifications', $action, $item_id, $secondary_item_id, $total_items, $format );

}

/**
 * Mark Likes notifications as read when reading a topic.
 */
function youzify_buddypress_mark_like_notifications_as_read( $action = '' ) {

	if ( ! bp_is_active( 'activity' ) || ! bp_is_single_activity()  ) {
		return;
	}

	// Bail if no activity ID is passed
	if ( empty( $_GET['activity_id'] ) || ! isset( $_GET['action'] ) || $_GET['action'] != 'youzify_new_like_mark_read' ) {
		return;
	}

	// Get required data
	$user_id  = bp_loggedin_user_id();
	$activity_id = intval( $_GET['activity_id'] );

	// Check nonce
	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'youzify_new_like_mark_read_' . $activity_id ) || ! current_user_can( 'edit_user', $user_id ) ) {
	    bp_core_add_message( __( "Sorry you don't have permission to do that!", 'youzify' ), 'error' );
		return;
	}

	// Attempt to clear notifications for the current user from this topic
	$success = bp_notifications_mark_notifications_by_item_id( $user_id, $activity_id, 'youzify_like_notification', 'youzify_new_like' );

	// Do additional subscriptions actions
	do_action( 'youzify_notifications_handler', $success, $user_id, $activity_id, $action );

	// Redirect to the topic
	$redirect = bp_activity_get_permalink( $activity_id );

	// Redirect
	wp_safe_redirect( $redirect );

	// For good measure
	exit();
}

add_action( 'bp_actions', 'youzify_buddypress_mark_like_notifications_as_read', 1 );