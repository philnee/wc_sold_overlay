<?php
// mt_settings_page() displays the page content for the Test Settings submenu
function sold_overlay_admin_page() {

    //must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    // variables for the field and option names 
    $opt_name = 'sold_overlay_text';
    $hidden_field_name = 'som_submit_hidden';
    $data_field_name = 'sold_overlay_text';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );
    $shade = get_option('sold-overlay-shade');

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ 'sold_overlay_text'];
        $shade = $_POST['sold-overlay-shade'];

        // Save the posted value in the database
        update_option( 'sold_overlay_text', $opt_val );
        update_option('sold-overlay-shade',$shade);

        // Put a "settings saved" message on the screen

?>
<div class="updated"><p><strong><?php _e('settings saved.', 'sold-overlay-menu' ); ?></strong></p></div>
<?php

    }

    // Now display the settings editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Sold Overlay Plugin Settings', 'sold-overlay-menu' ) . "</h2>";

    // settings form
    
    ?>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Sold Text:", 'sold-overlay-menu' ); ?> 
<input type="text" name='sold_overlay_text' value="<?php echo $opt_val; ?>" size="20">
</p><hr />

<p><?php _e("Overlay shade:", 'sold-overlay-menu' ); ?> 
  <input type="radio" name="sold-overlay-shade" value="light" 
    <?php if (isset($shade) && $shade=="light") echo "checked";?>
  > Light 
  <input type="radio" name="sold-overlay-shade" value="dark"
    <?php if (isset($shade) && $shade=="dark") echo "checked";?>
  > Dark
</p>

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
</div>

<?php
 
}
?>