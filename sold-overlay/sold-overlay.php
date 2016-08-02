<?php 
    /*
    Plugin Name: Sold overlay
    Plugin URI: http://plugins.philneedham.com
    Description: Plugin for displaying overlay for out of stock items on woocommerce
    Author: Phil Needham
    Version: 1.0
    Author URI: http://plugins.philneedham.com
    */
    function add_sold_overlay_before() {
        global $product;

        if (! $product->is_in_stock()) {
            echo '<div class="sold-overlay">';
        }
    }
    function add_sold_overlay_after() {
        global $product;

        if (! $product->is_in_stock()) {
            echo '<div class="sold-overlay after">Out of stock</div></div>';
        }
    }

    add_action( 'woocommerce_before_shop_loop_item_title','add_sold_overlay_before',5);
    add_action( 'woocommerce_before_shop_loop_item_title','add_sold_overlay_after',12);
    
    function myplugin_scripts() {
    wp_register_style( 'sold-overlay',  plugin_dir_url( __FILE__ ) . 'assets/sold-overlay.css' );
    wp_enqueue_style( 'sold-overlay' );
}
add_action( 'wp_enqueue_scripts', 'myplugin_scripts' );
?>
