<?php
/*
 * Plugin Name: Woomelly Extension 034 Add ons 
 * Version: 1.0.0
 * Plugin URI: https://woomelly.com
 * Description: Extension to show Mercado Libre price in the WooCommerce products list
 * Author: Team MakePlugins
 * Author URI: https://woomelly.com
 * Requires at least: 4.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'woomelly_woocommerce_get_price_html_ext_034' ) ) {
	add_filter( 'woocommerce_get_price_html', 'woomelly_woocommerce_get_price_html_ext_034', 10, 2 );
	function woomelly_woocommerce_get_price_html_ext_034 ( $price, $wc_product ) {
		if ( is_admin() ) {
			$args_temp = array();
			$args = apply_filters(
				'wc_price_args',
				wp_parse_args(
					$args_temp,
					array(
						'ex_tax_label'       => false,
						'currency'           => '',
						'decimal_separator'  => wc_get_price_decimal_separator(),
						'thousand_separator' => wc_get_price_thousand_separator(),
						'decimals'           => wc_get_price_decimals(),
						'price_format'       => get_woocommerce_price_format(),
					)
				)
			);
			$is_connect = get_post_meta( $wc_product->get_id(), '_wm_status_meli', true );
			if ( $is_connect == "true" && is_object($wc_product) ) {
				$woomelly_price = floatval( get_post_meta( $wc_product->get_id(), 'price_ext_034', true ) );
				if ( $woomelly_price > 0 ) {
					$woomelly_price = apply_filters( 'formatted_woocommerce_price', number_format( $woomelly_price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] ), $woomelly_price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] );
					$price = $price . '<br>-<br><span class="woocommerce-Price-amount amount"><bdi>' . $woomelly_price . '</bdi></span>';
				}
			}
		}
		return $price;
	}
}

if ( ! function_exists( 'action_woomelly_product_success_sync_ext_034' ) ) {
	add_filter( 'action_woomelly_product_success_sync', 'action_woomelly_product_success_sync_ext_034', 10, 5 );
	function action_woomelly_product_success_sync_ext_034 ( $wm_product, $result_meli, $parent_product, $available_variations, $wm_template_sync ) {
		if ( is_object($result_meli) && isset($result_meli->price) ) {
			$price = floatval( $result_meli->price );
			update_post_meta( $wm_product->get_id(), 'price_ext_034', $price );
		}
	}
}

if ( ! function_exists( 'woomelly_sync_meli_woo_new_product_success_ext_034' ) ) {
	add_filter( 'woomelly_sync_meli_woo_new_product_success', 'woomelly_sync_meli_woo_new_product_success_ext_034', 10, 4 );
	function woomelly_sync_meli_woo_new_product_success_ext_034 ( $wm_product, $data_item, $wcproduct, $woomelly_get_settings ) {
		if ( is_object($data_item) && isset($data_item->price) ) {
			$price = floatval( $data_item->price );
			update_post_meta( $wm_product->get_id(), 'price_ext_034', $price );
		}
	}
}

if ( ! function_exists( 'woomelly_sync_meli_woo_old_product_success_ext_034' ) ) {
	add_filter( 'woomelly_sync_meli_woo_old_product_success', 'woomelly_sync_meli_woo_old_product_success_ext_034', 10, 4 );
	function woomelly_sync_meli_woo_old_product_success_ext_034 ( $wm_product, $data_item, $wc_product_exist, $woomelly_get_settings ) {
		if ( is_object($data_item) && isset($data_item->price) ) {
			$price = floatval( $data_item->price );
			update_post_meta( $wm_product->get_id(), 'price_ext_034', $price );
		}
	}
}

?>