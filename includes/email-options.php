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
        'da_coupgen_mc_settings', //ID of Section
        'MailChimp Settings', // Title of the section
        'da_coupgen_mailchimp_section_text', // Call to callback function
        'da-coupon-generator-email-settings'//the menu page to display the section
    ); 
    add_settings_section(
        'email_main', //ID of Section
        'Email Settings', // Title of the section
        'da_coupgen_email_section_text', // Call to callback function
        'da-coupon-generator-email-settings'//the menu page to display the section
    );
   
    add_settings_field(
        'da_coupgen_mc_api_key_input', //Setting ID used to retrieve from database
        'MailChimp API Key', //Title of setting displayed next to setting on plugin page
        'da_coupgen_mc_api_key', //Call back function used to display markup
        'da-coupon-generator-email-settings', //Specifies the page setting should be displayed on
        'da_coupgen_mc_settings'//Specifies the section that displays the setting should match the section ID
    );
    add_settings_field(
        'da_coupgen_mc_list_id_input', 
        'MailChimp List ID', 
        'da_coupgen_mc_list_id', 
        'da-coupon-generator-email-settings', 
        'da_coupgen_mc_settings'
    );
    add_settings_field(
        'da_coupgen_email_subject', //Setting ID used to retrieve from database
        'Email Subject', //Title of setting displayed next to setting on plugin page
        'da_coupgen_email_subject', //Call back function used to display markup
        'da-coupon-generator-email-settings', //Specifies the page setting should be displayed on
        'email_main'//Specifies the section that displays the setting should match the section ID
    );

    add_settings_field(
        'da_coupgen_email_header_color', //Setting ID used to retrieve from database
        'Email Header Color', //Title of setting displayed next to setting on plugin page
        'da_coupgen_email_header_color', //Call back function used to display markup
        'da-coupon-generator-email-settings', //Specifies the page setting should be displayed on
        'email_main'//Specifies the section that displays the setting should match the section ID
    );

    add_settings_field(
        'da_coupgen_email_header_logo', //Setting ID used to retrieve from database
        'Header Logo', //Title of setting displayed next to setting on plugin page
        'da_coupgen_email_header_logo', //Call back function used to display markup
        'da-coupon-generator-email-settings', //Specifies the page setting should be displayed on
        'email_main'//Specifies the section that displays the setting should match the section ID
    );
}


function da_coupgen_email_section_text() {
    echo '<p>Change Email Settings</p>';
}

function da_coupgen_mailchimp_section_text() {
    echo '<p>Add MailChimp API Key and List ID Here.
            <br>To display the form, use Shortcode: [coupon-generator]</p>';
}

function da_coupgen_mc_api_key() {
    $options = get_option('da_coupgen_email_options');
    echo "<input id='da-coupgen-input-mc-api-key' name='da_coupgen_email_options[mc_api_key]' size='40' type='text' value='{$options['mc_api_key']}' />";
} 
function da_coupgen_mc_list_id() {
    $options = get_option('da_coupgen_email_options');
    echo "<input class='da-coupgen-mc-list-id' name='da_coupgen_email_options[mc_list_id]' size='40' type='text' value='{$options['mc_list_id']}' />";
}

function da_coupgen_email_subject(){
    $options = get_option('da_coupgen_email_options');
    echo "<input id='da-coupgen-input-mc-api-key' name='da_coupgen_email_options[email_subject]' size='40' type='text' value='{$options['email_subject']}' />";
}

function da_coupgen_email_header_color(){
    $options = get_option('da_coupgen_email_options');
    echo "<p>Change the header color of the email</p>";
}

function da_coupgen_email_header_logo(){
    $options = get_option('da_coupgen_email_options');
    echo "<p>Add logo to the header of your email</p>";
}