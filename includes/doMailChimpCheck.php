<?php
if ( ! defined( 'ABSPATH' )){
    exit;
}
use \DrewM\MailChimp\MailChimp;

function da_do_mailchimp_check(){
    global $email;
    global $coupon_code;
    global $responseMessage;

    $mailChimpSettings = get_option('da_coupgen_plugin_options');
    $mailchimpApiKey = $mailChimpSettings['mc_api_key'];
    $list_id = $mailChimpSettings['mc_list_id'];
    $MailChimp = new MailChimp($mailchimpApiKey);
    $subscriber_hash = $MailChimp->subscriberHash($email);
    $result = $MailChimp->get("lists/$list_id/members/$subscriber_hash");
                
        if($result['status'] == 'subscribed'){
                  
            $responseMessage .= 'Sorry only 1 coupon Per customer';
            
        }else{
            $MailChimp->post("lists/$list_id/members", [
				'email_address' => $email,
				'status'        => 'subscribed',
			]);
            
            
            $coupon_code = generateRandomString(); 
            
            da_add_coupon_to_wordpress();
            
            da_send_coupon_email();
            
            $responseMessage .= $coupon_code;
        }
}
