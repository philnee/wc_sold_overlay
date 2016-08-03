<?php 
    /*
    Plugin Name: Sold overlay
    Plugin URI: http://plugins.philneedham.com
    Description: Plugin for displaying overlay for out of stock items on woocommerce
    Author: Phil Needham
    Version: 1.0.5
    Author URI: http://plugins.philneedham.com
    */


    
    include( plugin_dir_path( __FILE__ ) . 'sold-overlay-admin.php');
    defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

    function github_updater(){
        include_once('updater.php');
        define( 'WP_GITHUB_FORCE_UPDATE', true );

        if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
            $config = array(
                'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
                'proper_folder_name' => 'sold-overlay', // this is the name of the folder your plugin lives in
                'api_url' => 'https://api.github.com/repos/philnee/wc_sold_overlay', // the GitHub API url of your GitHub repo
                'raw_url' => 'https://raw.github.com/philnee/wc_sold_overlay/master', // the GitHub raw url of your GitHub repo
                'github_url' => 'https://github.com/philnee/wc_sold_overlay', // the GitHub url of your GitHub repo
                'zip_url' => 'https://github.com/philnee/wc_sold_overlay/zipball/master', // the zip url of the GitHub repo
                'sslverify' => true, // whether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
                'requires' => '4.5', // which version of WordPress does your plugin require?
                'tested' => '4.5.3', // which version of WordPress is your plugin tested up to?
                'readme' => 'README.md', // which file to use as the readme for the version number
                'access_token' => '', // Access private repositories by authorizing under Appearance > GitHub Updates when this example plugin is installed
            );
            new WP_GitHub_Updater($config);
        }
    }

    add_action('init','github_updater');


    function add_sold_overlay_before() {
        global $product;
        $shade = get_option('sold-overlay-shade');

        if (! $product->is_in_stock()) {
            echo '<div class="sold-overlay';
                if($shade == 'light') {echo ' light';}
            echo '">';
        }
    }

    function add_sold_overlay_after() {
        global $product;
        $text = get_option('sold_overlay_text');
        $show_overlay = get_option('sold_overlay_show');

        if (! $product->is_in_stock() && $show_overlay) {
            echo '<div class="sold-overlay after"><p class="sold-text">';
                if($text != '')
                    {echo esc_html($text);} 
                else
                    { echo 'Out Of Stock';};
            echo '</p></div></div>';
        }
    }

    function add_sold_marker(){
        global $product;
        $show_marker = get_option('sold_overlay_marker');
        $marker_text = get_option('sold_overlay_text');
        if($marker_text == ''){ $marker_text = 'Sold Out';}

        if($show_marker && !$product->is_in_stock()){
            echo '<div class="sold-marker">';
            echo esc_html($marker_text);
            echo '</div>';
        };
    }

    add_action( 'woocommerce_before_shop_loop_item_title','add_sold_overlay_before',5);
    add_action( 'woocommerce_before_shop_loop_item_title','add_sold_overlay_after',12);
    add_action( 'woocommerce_after_shop_loop_item_title','add_sold_marker',10);
    
    function myplugin_scripts() {
    wp_register_style( 'sold-overlay',  plugin_dir_url( __FILE__ ) . 'assets/sold-overlay.css' );
    wp_enqueue_style( 'sold-overlay' );
    }
    add_action( 'wp_enqueue_scripts', 'myplugin_scripts' );

    function sold_overlay_admin_actions(){
        add_submenu_page('woocommerce','Sold Overlay Display','Sold Overlay Display', 'manage_options', 'Sold Overlay Display', 'sold_overlay_admin_page');
    }

    function sold_overlay_admin(){
        echo '<h1>This is the admin page!</h1>';
    }

    add_action('admin_menu','sold_overlay_admin_actions');
?>
