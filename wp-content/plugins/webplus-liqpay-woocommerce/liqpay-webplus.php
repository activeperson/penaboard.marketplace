<?php
/*
 * Plugin Name: WebPlus LiqPay WooCommerce
 * Description: Плагин LiqPay для использования оплаты в woocommerce
 * Version: 1.1.6
 * Author: Павел Борисенко
 */

function add_liqpay_gateway_class($methods)
{
    require_once(__DIR__ . '/includes/class-wc-gateway-liqpay.php');
    $methods[] = 'WC_Gateway_Liqpay';
    return $methods;
}

add_filter('woocommerce_payment_gateways', 'add_liqpay_gateway_class');
