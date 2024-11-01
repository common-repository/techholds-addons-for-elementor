<?php

/**
 * Star rating widget template.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $post;
$post_id = $post->ID;
$settings = $this->get_settings_for_display();

// Get current rating and rating count.
$rating       = get_post_meta( $post_id, '_techholds_rating', true ) ?: 0;
$rating_count = get_post_meta( $post_id, '_techholds_rating_count', true ) ?: 0;

// Calculate average rating.
$average_rating           = $rating_count > 0 ? $rating / $rating_count : 0;
$average_rating_formatted = number_format( $average_rating, 2 );

// Calculate the number of full stars and the percentage for the last star.
$full_stars = floor($average_rating);
$fractional_part = $average_rating - $full_stars;
$percentage_fill = $fractional_part * 100;

// Use the user-defined average rating text.
$average_rating_text = !empty( $settings['average_rating_text'] ) ? $settings['average_rating_text'] : __( 'Average Rating is:', 'techholds-addons-for-elementor' );
$submit_rating_text = !empty( $settings['submit_rating_text'] ) ? $settings['submit_rating_text'] : __( 'Thank you for your rating', 'techholds-addons-for-elementor' );

$icon = $settings['star_icon']['value'] ? $settings['star_icon']['value'] : 'fas fa-star';

echo '<div class="techholds-ea-rating" data-post-id="' . esc_attr( $post_id ) . '">';
echo '<div class="techholds-ea-rating-text">' . esc_html( $average_rating_text ) . ' ' . esc_html( $average_rating_formatted ) . '</div>';
echo '<div class="techholds-ea-thanks-rating-text">' . esc_html( $submit_rating_text ) . '</div>';
echo '<div class="techholds-ea-rating-stars">';
for ( $i = 1; $i <= 5; $i++ ) {
    if ( $i <= $full_stars ) {
        echo '<span class="star active" data-rating="' . esc_attr( $i ) . '"><i class="' . esc_attr( $icon ) . '"></i></span>';
    } elseif ( $i == $full_stars + 1 ) {
        echo '<span class="star fractional" data-rating="' . esc_attr( $i ) . '">';
        echo '<i class="fraction-star ' . esc_attr( $icon ) . '" style="width: ' . esc_attr( $percentage_fill ) . '%;"></i>';
        echo '<i class="' . esc_attr( $icon ) . '" ></i>';
        echo '</span>';
    } else {
        echo '<span class="star" data-rating="' . esc_attr( $i ) . '"><i class="' . esc_attr( $icon ) . '"></i></span>';
    }
}
echo '</div>';
echo '</div>';
