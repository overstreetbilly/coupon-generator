<?php
/**
 * Plugin Name: coupongenerator
 * Plugin URI: https://mywebsite.com
 * Description: A Plugin to randomly generate coupon code for woocommerce
 * Version: 1.0
 * Author: Billy Ho Taco
 * Author URI: https://mywebsite.com
 * Text Domain: mywebsite
 * 
 */
if ( ! defined( 'ABSPATH' )){
    exit;
}

 
 require_once( ABSPATH . "wp-includes/pluggable.php" );
 require_once(plugin_dir_path(__FILE__).'includes/MailChimp.php');
 require_once(plugin_dir_path(__FILE__).'includes/sendCouponEmail.php');
 require_once(plugin_dir_path(__FILE__).'includes/generateRandomString.php');
 require_once(plugin_dir_path(__FILE__).'includes/doMailChimpCheck.php');
 require_once(plugin_dir_path(__FILE__).'includes/addCouponToWordpress.php');
 require_once(plugin_dir_path(__FILE__).'includes/coupon-options.php');
 require_once(plugin_dir_path(__FILE__).'includes/email-options.php');


function da_coupon_gen_shortcode(){
    $url = esc_url( $_SERVER['REQUEST_URI']);
    global $responseMessage;
    $form = '<div class="coup-request-form">
            <form action="' .$url. '" method="post">
                <input type="email" name="email-address">
                <input type="submit" name="submit">
            </form>
                <div class="error-message">
                <p>'.$responseMessage.'</p>
                </div>
                </div>';
    return $form;

}

add_shortcode('coupon-generator','da_coupon_gen_shortcode');


if ( $_SERVER['REQUEST_METHOD'] == 'POST'){
    global $email;
    global $responseMessage;
    $email = $_POST['email-address'];
    if(empty($email)){
        
        $responseMessage .= 'Please Enter Your Email Address';
       //da_error_message("Please enter your Email Address");
      
        }else{   
        //check mailchimp for email subscription
        da_do_mailchimp_check();

        }
}//if request method is post