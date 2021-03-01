<?php

/**
* Plugin Name: ACF: WooCommerce Location Rules
* Description: Adds custom ACF location rules for WooCommerce pages
* Version: 1.0
* Author: Oskari Oksanen
* Author URI: http://oskarioksanen.fi/
*/

function acf_rule_type_woocommerce_page( $choices ) {
	$choices['WooCommerce']['woocommerce_page'] = 'WooCommerce Page';
	return $choices;
}
add_filter( 'acf/location/rule_types', 'acf_rule_type_woocommerce_page' );

function acf_rule_values_woocommerce_page( $choices ) {

	$choices[get_option( 'woocommerce_shop_page_id' )] = 'Shop';
	$choices[get_option( 'woocommerce_cart_page_id' )] = 'Cart';
	$choices[get_option( 'woocommerce_checkout_page_id' )] = 'Checkout';
	$choices[get_option( 'woocommerce_myaccount_page_id' )] = 'Account';

	return $choices;
}
add_filter( 'acf/location/rule_values/woocommerce_page', 'acf_rule_values_woocommerce_page' );

function acf_rule_match_woocommerce_page( $match, $rule, $options ) {
	
	if ( ! $options['post_id'] || 'page' !== get_post_type( $options['post_id'] ) )
		return false;
		
	$is_match = $rule['value'] == $options['post_id'];
	
	if ( '==' == $rule['operator'] ) { 
		$match = $is_match;
	
	} elseif ( '!=' == $rule['operator'] ) {
		$match = ! $is_match;
	}
	
	return $match;

}
add_filter( 'acf/location/rule_match/woocommerce_page', 'acf_rule_match_woocommerce_page', 10, 3 );