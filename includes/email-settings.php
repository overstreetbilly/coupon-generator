<?php
if ( ! defined( 'ABSPATH' )){
    exit;
}


function da_coupon_generator_email_settings(){
	
    ?>
	<div class="wrap">
	<form action="options.php" method="post">
       <?php settings_fields('da_coupgen_email_options'); ?>
       <?php do_settings_sections('da-coupon-generator-email-settings'); ?>
	    <input name="Submit" type="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
	</div>
   <?php
}


add_action('admin_init', 'da_coupgen_add_email_settings_sections');

function da_coupgen_add_email_settings_sections(){
    register_setting( 
        'da_coupgen_email_options', 
        'da_coupgen_email_options',
        'plugin_options_validate' 
    );
    add_settings_section(
        'email_main', //ID of Section
        'Email Settings', // Title of the section
        'da_coupgen_email_section_text', // Call to callback function
        'da-coupon-generator-email-settings'//the menu page to display the section
    );
    
}


function da_coupgen_email_section_text() {
    echo '<p>Change Email Settings</p>';
}