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
            echo '<div class="sold-overlay"
             style="top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: rgba(0,0,0,0.6);
    position: absolute;">Out of stock</div>';
        }
    }

    add_action( 'woocommerce_after_shop_loop_item','add_sold_overlay');
?>
