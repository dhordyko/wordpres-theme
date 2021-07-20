<?php

/*
Plugin Name: My Plugin
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: Darya
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

/* Cart Page Edditing */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
add_action( 'woocommerce_product_options_general_product_data', 'bbloomer_add_badge_checkbox_to_products' );

function bbloomer_add_badge_checkbox_to_products() {
    woocommerce_wp_checkbox( array(
            'id' => 'bestseller',
            'class' => '',
            'label' => 'Bestseller'
        )
    );
    woocommerce_wp_checkbox( array(
            'id' => 'new',
            'class' => '',
            'label' => 'Nowosc'
        )
    );
    woocommerce_wp_checkbox( array(
            'id' => 'promotion',
            'class' => '',
            'label' => 'Promocja'
        )
    );
}

add_action( 'save_post', 'bbloomer_save_badge_checkbox_to_post_meta' );

function bbloomer_save_badge_checkbox_to_post_meta( $product_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
    if ( isset( $_POST['bestseller'] ) ) {
        update_post_meta( $product_id, 'bestseller', $_POST['bestseller'] );
    } else delete_post_meta( $product_id, 'bestseller' );
    if ( isset( $_POST['new'] ) ) {
        update_post_meta( $product_id, 'new', $_POST['new'] );
    } else delete_post_meta( $product_id, 'new' );
    if ( isset( $_POST['promotion'] ) ) {
        update_post_meta( $product_id, 'promotion', $_POST['promotion'] );
    } else delete_post_meta( $product_id, 'promotion' );
}





add_action( 'woocommerce_before_single_product_summary', 'bbloomer_display_badge_if_checkbox', 6 );

function bbloomer_display_badge_if_checkbox() {
    global $product;
    if ( get_post_meta( $product->get_id(), 'bestseller', true ) ) {
        echo '
    <div class="woocommerce-message bestseller">Bestseller</div>
     
    ';
        if ( get_post_meta( $product->get_id(), 'new', true ) ) {
            echo '
    <div class="woocommerce-message new">Nowosc</div>
     
    ';

        }
        if ( get_post_meta( $product->get_id(), 'promotion', true ) ) {
            echo '
    <div class="woocommerce-message promotion">Promocja</div>
     
    ';

        }
    }
}


add_action( 'woocommerce_before_shop_loop_item_title', 'new_badge', 3 );

function new_badge() {
    global $product;
    if ( get_post_meta( $product->get_id(), 'bestseller', true ) ) {
        echo '<span class="new-badge bestseller">' . esc_html__( 'Bestseller', 'woocommerce' ) . '</span>';

    }
    if ( get_post_meta( $product->get_id(), 'new', true ) ) {
        echo '<span class="new-badge new">' . esc_html__( 'Nowosc', 'woocommerce' ) . '</span>';

    }
    if ( get_post_meta( $product->get_id(), 'promotion', true ) ) {
        echo '<span class="new-badge promotion">' . esc_html__( 'Promocja', 'woocommerce' ) . '</span>';

    }

}