<?php

/**
 * Handle ajax functions for all widgets.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function thafe_techholds_update_rating() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'techholds_nonce' ) ) {
        wp_send_json_error( 'Invalid nonce' );
    }
    if ( isset( $_POST['post_id'] ) && isset( $_POST['rating'] ) ) {
        $post_id = intval( $_POST['post_id'] );
        $rating = intval( $_POST['rating'] );

        // Update the rating in the post meta.
        $current_rating = get_post_meta( $post_id, '_techholds_rating', true ) ?: 0;
        $current_rating_count = get_post_meta( $post_id, '_techholds_rating_count', true ) ?: 0;

        $new_rating = $current_rating + $rating;
        $new_rating_count = $current_rating_count + 1;

        update_post_meta( $post_id, '_techholds_rating', $new_rating );
        update_post_meta( $post_id, '_techholds_rating_count', $new_rating_count );

        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
