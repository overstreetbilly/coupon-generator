<?php
if ( ! defined( 'ABSPATH' )){
    exit;
}

// Generate new coupon code
//Generate a random string to make a coupon
function da_add_coupon_to_wordpress(){
    global $coupon_code;
    
    $coupon_options = get_option('da_coupgen_plugin_options');
    $amount = $coupon_options['coupgen_amount'];
    $discount_type = $coupon_options['discount_type'];
    $individual_use = $coupon_options['individual_use'];
    $product_ids = $coupon_options['coupgen_product_id'];
    $exclude_product_ids = $coupon_options['coupgen_exclude_product_id'];
    $usage_limit = $coupon_options['coupgen_usage_limit'];
    $usage_limit_per_user = $coupon_options['coupgen_usage_limit_per_user'];
    $limit_usage_to_x_items = $coupon_options['coupgen_limit_usage_to_x_items'];
    $apply_before_tax = $coupon_options[''];
    $free_shipping = $coupon_options[''];

    $coupon = array(
        'post_title' => $coupon_code,
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type'		=> 'shop_coupon'
        );

    $new_coupon_id = wp_insert_post( $coupon );

                // Add meta
        update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
        update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
        update_post_meta( $new_coupon_id, 'individual_use', $individual_use );
        update_post_meta( $new_coupon_id, 'product_ids', $product_ids );
        update_post_meta( $new_coupon_id, 'exclude_product_ids', $exclude_product_ids );
        update_post_meta( $new_coupon_id, 'usage_limit', $usage_limit );
        update_post_meta( $new_coupon_id, 'usage_limit_per_user', $usage_limit_per_user );
        update_post_meta( $new_coupon_id, 'limit_usage_to_x_items', $limit_usage_to_x_items );
        //update_post_meta( $new_coupon_id, 'expiry_date', '' );
        update_post_meta( $new_coupon_id, 'apply_before_tax', $apply_before_tax );
        update_post_meta( $new_coupon_id, 'free_shipping', $free_shipping );
}