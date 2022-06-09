<?php
/*
Plugin Name:	WooCommerce TC Checkbox
Plugin URI:		https://progr.interplanety.org/en/wordpress-plugin-woocommerce-tc-checkbox/
Version:		1.0.0
Author:			Nikita Akimov
Author URI:		https://progr.interplanety.org/en/
License:		GPL-3.0-or-later
Description:	Adds Terms of Conditions checkbox to the user registration page
*/

//	not run directly
if(!defined('ABSPATH')) {
	exit;
}

// --------------------------- ADD TC Checkbox --------------------------

function tc_checkbox_to_user_reg_form_add() {

    if(wc_get_page_id('terms') > 0 && is_account_page()) {
        echo '<p class="form-row terms wc-terms-and-conditions">';
        echo 	'<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">';
        echo		'<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" '
						. (isset($_POST['terms']) ? 'checked' : '')
						. 'id="terms" /> 
						<span>'
						. __('I have read and consent to the <a href="'
								. esc_url(wc_get_page_permalink('terms'))
								. '" target="_blank" class="woocommerce-terms-and-conditions-link">Terms of Use</a> and <a href="'
								. home_url() . DIRECTORY_SEPARATOR . get_post_field('post_name', (int) get_option('wp_page_for_privacy_policy'))
								. '" target="_blank" class="woocommerce-privacy-policy-link">Privacy policy</a>',
							'woocommerce'
						)
						. '</span> <span class="required">*</span>';
        echo 	'</label>';
        echo 	'<input type="hidden" name="terms-field" value="1" />';
        echo '</p>';
    }
}

add_action('woocommerce_register_form', 'tc_checkbox_to_user_reg_form_add', 20);

// --------------------------- Validate TC Checkbox --------------------------

function tc_checkbox_to_user_reg_form_validate($username, $email, $validation_errors) {
    if (!isset($_POST['terms'])) {
        $validation_errors->add('terms_error', __('You mast accept Terms of Use and Privacy Policy!', 'woocommerce'));
	}
    return $validation_errors;
}

add_action('woocommerce_register_post', 'tc_checkbox_to_user_reg_form_validate', 20, 3);

// --------------------------- Remove on Checkout page --------------------------

// add_filter('woocommerce_checkout_show_terms', '__return_false');

?>
