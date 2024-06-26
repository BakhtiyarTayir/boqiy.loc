<?php

/**
 * Replace Member Type Field Value
 */
add_filter( 'bp_get_the_profile_field_value', 'youzify_replace_member_type_field_value', 0, 3 );

function youzify_replace_member_type_field_value( $values, $field_type, $user_id ) {

    if ( $field_type == 'member_types' ) {
        return youzify_get_user_member_type_singular( $values );
    }

    return $values;
}

/**
 * Get User Member Type By ID.
 */
function youzify_get_user_member_type_singular( $default_types = null ) {

    // Collect Member Types.
    $member_types = explode( ', ', $default_types );

    foreach ( $member_types as $member_type ) {

        // Get Member Type.
        $type = bp_get_member_type_object( $member_type );

        // Change Member Type Name.
        if ( isset( $type->labels['singular_name'] ) ) {
            $default_types = str_replace( $member_type, $type->labels['singular_name'], $default_types );
        }

    }

    return apply_filters( 'youzify_member_types_get_user_member_type_singular', $default_types  );
}

/**
 * Get Xprofile fields by field type.
 */
function youzify_get_xprofile_member_types_field_id() {

    $id = wp_cache_get( 'member_types_field_id', 'bp_xprofile' );

    if ( false === $id ) {

        global $wpdb;

        // Get Fields Table Name.
        $bp = buddypress();

        // Get Fields ID'S.
        $id = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$bp->profile->table_name_fields} WHERE type = %s", 'member_types' ) );

        wp_cache_set( 'member_types_field_id', $id, 'bp_xprofile' );
    }

    return absint( $id );
}

/**
 * Convert Member Type Values from ID to Singular Name.
 */
add_filter( 'youzify_get_user_field_data', 'youzify_replace_member_types_with_singular_name', 10, 2 );

function youzify_replace_member_types_with_singular_name( $value, $field_id ) {

	if ( $field_id == youzify_get_xprofile_member_types_field_id() ) {

		return youzify_get_user_member_type_singular( $value );

	}

	return $value;
}