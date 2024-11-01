<?php

/**
 * Class to register star rating widget.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class THAFE_TechHolds_5_Star_Rating_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return '5_star_rating';
    }

    public function get_title() {
        return __( '5 Star Rating', 'techholds-addons-for-elementor' );
    }

    public function get_icon() {
        return 'techholds-logo-icon eicon-star';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Star Rating', 'techholds-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Add control for average rating text.
        $this->add_control(
            'average_rating_text',
            [
                'label' => __( 'Average Rating Text', 'techholds-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Average Rating is:', 'techholds-addons-for-elementor' ),
            ]
        );

        // Add control for submit rating text.
        $this->add_control(
            'submit_rating_text',
            [
                'label' => __( 'Thank You Rating Text', 'techholds-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Thank you for your rating', 'techholds-addons-for-elementor' ),
            ]
        );

        // Add control for selecting the star icon.
        $this->add_control(
            'star_icon',
            [
                'label' => __( 'Star Icon', 'techholds-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section for Text.
        $this->start_controls_section(
            'rating_text_style_section',
            [
                'label' => __( 'Rating Text', 'techholds-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Rating Text Color', 'techholds-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .techholds-ea-rating > div.techholds-ea-rating-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'rating_text_typography',
                'selector' => '{{WRAPPER}} .techholds-ea-rating > div.techholds-ea-rating-text',
            ]
        );

        $this->end_controls_section();

        // Style Section for Thank You Text.
        $this->start_controls_section(
            'thanks_style_section',
            [
                'label' => __( 'Thank You Rating Text', 'techholds-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'thanks_text_color',
            [
                'label' => __( 'Thank You Rating Text Color', 'techholds-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .techholds-ea-rating > div.techholds-ea-thanks-rating-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'thanks_rating_text_typography',
                'selector' => '{{WRAPPER}} .techholds-ea-rating > div.techholds-ea-thanks-rating-text',
            ]
        );

        $this->end_controls_section();

        // Style Section for Stars.
        $this->start_controls_section(
            'stars_section',
            [
                'label' => __( 'Rating Stars', 'techholds-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'star_color',
            [
                'label' => __( 'Star Color', 'techholds-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#dddddd', // Default color for non-active stars.
                'selectors' => [
                    '{{WRAPPER}} .techholds-ea-rating .star' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_star_color',
            [
                'label' => __( 'Active Star Color', 'techholds-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffcc00', // Default color for active stars.
                'selectors' => [
                    '{{WRAPPER}} .techholds-ea-rating .star.active i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .techholds-ea-rating .star.fractional i:first-child' => 'color: {{VALUE}};', // Apply color to the filled portion of the fractional star
                ],
            ]
        );

        $this->add_control(
            'star_size',
            [
                'label' => __( 'Star Size', 'techholds-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .techholds-ea-rating .star' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'star_gap',
            [
                'label' => __( 'Star Gap', 'techholds-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .techholds-ea-rating .star' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    
    protected function render() {
        $template_path = THAFE_TECHHOLDS_PLUGIN_PATH . 'templates/star-rating-template.php';
        if ( file_exists( $template_path ) ) {
            include $template_path;
        }
    }
}
