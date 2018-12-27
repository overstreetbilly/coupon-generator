<?php
if ( ! defined( 'ABSPATH' )){
    exit;
}
add_action( 'admin_menu', 'coupon_generator_menu' );

function coupon_generator_menu() {
	add_menu_page( 'Coupon Generator Settings', 'Coupon Generator', 'manage_options', 'da-coupon-generator', 'coupon_generator_options' );
    add_submenu_page('da-coupon-generator', 'Email Settings', 'Email Settings', 'manage_options', 'da-coupon-generator-email-settings', 'da_coupon_generator_email_settings');
    //add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function); 
}


function coupon_generator_options() {
	
    ?>
	<div class="wrap">
	<form action="options.php" method="post">
       <?php settings_fields('da_coupgen_plugin_options'); ?>
       <?php do_settings_sections('da-coupon-generator'); ?>
	    <input name="Submit" type="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
	</div>
   <?php
}


add_action('admin_init', 'da_coupgen_admin_init');


function da_coupgen_admin_init(){//Registers settings function
    if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    
    register_setting( 
        'da_coupgen_plugin_options', 
        'da_coupgen_plugin_options',
        'plugin_options_validate' 
    );
      
    add_settings_section(
        'plugin_secondary', //ID of Section
        'Coupon Settings', // Title of the section
        'da_coupgen_coupon_section_text', // Call to callback function
        'da-coupon-generator' //the menu page to display the section
    );

    
    add_settings_field(
        'da_coupgen_amount_input',
        'Set Amount for Coupon', 
        'da_coupgen_amount', 
        'da-coupon-generator',
        'plugin_secondary'
    );
    add_settings_field(
        'da_coupgen_discount_type_select',
        'Select Type of Coupon', 
        'da_coupgen_discount_type',
        'da-coupon-generator',
        'plugin_secondary'
    );
    add_settings_field(
        'da_coupgen_individual_use',//Setting ID used to retrieve from database
        'Select individual use Yes/No', //Title of setting displayed next to setting on plugin page
        'da_coupgen_individual_use', //Call back function used to display markup
        'da-coupon-generator',//Specifies the page setting should be displayed on
        'plugin_secondary'//Specifies the section that displays the setting should match the section ID
    );
    
    add_settings_field(
        'da_coupgen_product_id', 
        'Add in the product ID the coupon will be used with', 
        'da_coupgen_product_id', 
        'da-coupon-generator', 
        'plugin_secondary'
    );
    
    add_settings_field(
        'da_coupgen_exclude_product_id', 
        'Add product ID that coupon will not be allowed to apply to', 
        'da_coupgen_exclude_product_id', 
        'da-coupon-generator', 
        'plugin_secondary'
    );
    
    add_settings_field(
        'da_coupgen_usage_limit', 
        'Set the limit for the number of times a coupon can be used', 
        'da_coupgen_usage_limit', 
        'da-coupon-generator', 
        'plugin_secondary'
    );
    
    add_settings_field(
        'da_coupgen_usage_limit_per_user', 
        'Set the limit for the number of times a person can use the coupon', 
        'da_coupgen_usage_limit_per_user', 
        'da-coupon-generator', 
        'plugin_secondary'
    );    
    
    add_settings_field(
        'da_coupgen_limit_usage_to_x_items', 
        'Set the limit of items allowed in the cart', 
        'da_coupgen_limit_usage_to_x_items', 
        'da-coupon-generator', 
        'plugin_secondary'
    );
    
    add_settings_field(
        'da_coupgen_apply_before_tax', 
        'Apply the coupon before or after tax  Yes/No', 
        'da_coupgen_apply_before_tax', 
        'da-coupon-generator', 
        'plugin_secondary'
    );
    
    add_settings_field(
        'da_coupgen_free_shipping', 
        'Allow free shipping?', 
        'da_coupgen_free_shipping', 
        'da-coupon-generator', 
        'plugin_secondary'
    );
}



function da_coupgen_coupon_section_text() {
    echo '<p>Change Coupon Settings</p>';
    if(!class_exists('Woocommerce')){
        echo '<div class="notice notice-warning is-dismissible ppec-dismiss-bootstrap-warning-message">
                <p>This Plugin requires Woocommerce to be installed before it will work.</p>
                </div>';
    }
}

function da_coupgen_amount(){
    //This should be an input, numbers only
    $options = get_option('da_coupgen_plugin_options');
    echo "<input id='da-coupgen-amount' name='da_coupgen_plugin_options[coupgen_amount]' type='number' value='{$options['coupgen_amount']}'>";
}

function da_coupgen_discount_type(){
    $options = get_option('da_coupgen_plugin_options');
    $id = 'discount_type';
    $selected_option = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';
    $selected_options = array(
        'fixed_cart'        => 'Fixed Cart',
        'percent'           => 'Percent',
        'fixed_product'     => 'Fixed Product',
        'percent_product'   => 'Percent Product'
    );
    echo "<select id='discount_type' name='da_coupgen_plugin_options[discount_type]'>";
    
    foreach ($selected_options as $value/*key*/ => $option/*Value*/){
        $selected = selected($selected_option === $value, true, false);
        echo '<option value="'.$value.'"'.$selected.'>'.$option .'</option>';
    }
    
    // Type: fixed_cart, percent, fixed_product, percent_product
}
function da_coupgen_individual_use(){
    $options = get_option('da_coupgen_plugin_options');
    echo '<input type="checkbox" name="da_coupgen_plugin_options[individual_use]" value=""><p>Check to only allow individual use</p>';//Checkbox for yes uncheched is no.
}

function da_coupgen_product_id(){
    $options = get_option('da_coupgen_plugin_options');
    //This should be an input numbers only
    
    echo "<input id='da-coupgen-product-id' name='da_coupgen_plugin_options[coupgen_product_id]' type='number' value='{$options['coupgen_product_id']}'>";
}

function da_coupgen_exclude_product_id(){
    $options = get_option('da_coupgen_plugin_options');
    //This should be an input numbers only
    
    echo "<input id='da-coupgen-exclude-id' name='da_coupgen_plugin_options[coupgen_exclude_product_id]' type='number' value='{$options['coupgen_exclude_product_id']}'>";
}

function da_coupgen_usage_limit(){
    $options = get_option('da_coupgen_plugin_options');
    //This should be an input numbers only
    
    echo "<input id='da-coupgen-usage-limit' name='da_coupgen_plugin_options[coupgen_usage_limit]' type='number' value='{$options['coupgen_usage_limit']}'>";
}

function da_coupgen_usage_limit_per_user(){
    $options = get_option('da_coupgen_plugin_options');
    //This should be an input numbers only
    
    echo "<input id='da-coupgen-limit-per-user' name='da_coupgen_plugin_options[coupgen_usage_limit_per_user]' type='number' value='{$options['coupgen_usage_limit_per_user']}'>";
}
function da_coupgen_limit_usage_to_x_items(){
    $options = get_option('da_coupgen_plugin_options');
    //This should be an input numbers only
    
    echo "<input id='da-coupgen' name='da_coupgen_plugin_options[coupgen_limit_usage_to_x_items]' type='number' value='{$options['coupgen_limit_usage_to_x_items']}'>";
}

function da_coupgen_apply_before_tax(){
    $options = get_option('da_coupgen_plugin_options');
    echo '<input type="checkbox" name="" value=""><p>Check to apply before tax</p>';//Checkbox for yes uncheched is no.
}

function da_coupgen_free_shipping(){
    $options = get_option('da_coupgen_plugin_options');
    echo '<input type="checkbox" name="" value=""><p>Check to allow free shipping</p>';//Checkbox for yes uncheched is no.
}

/*function plugin_options_validate($input) {
    $options = get_option('da_coupgen_plugin_options');
    $options['text_string'] = trim($input['text_string']);
    if(!preg_match('/^[a-z0-9]{32}$/i', $options['text_string'])) {
    $options['text_string'] = '';
    }
    return $options;
}*/