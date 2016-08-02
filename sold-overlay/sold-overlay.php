<?php 
    /*
    Plugin Name: Sold overlay
    Plugin URI: http://plugins.philneedham.com
    Description: Plugin for displaying overlay for out of stock items on woocommerce
    Author: Phil Needham
    Version: 1.0
    Author URI: http://plugins.philneedham.com
    */
    function add_sold_overlay() {
        global $product;

        if (! $product->is_in_stock()) {
            echo '<div class="sold-overlay">Out of stock</div>';
        }
    }

    add_action( 'woocommerce_after_shop_loop_item','add_sold_overlay',4);function myplugin_scripts() {
    wp_register_style( 'sold-overlay',  plugin_dir_url( __FILE__ ) . 'assets/sold-overlay.css' );
    wp_enqueue_style( 'sold-overlay' );
}
add_action( 'wp_enqueue_scripts', 'myplugin_scripts' );
?>
