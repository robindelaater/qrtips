<?php

/**
 * Plugin Name: QR Tips Plugin
 * Description: Generate a QR for tipping through MultiSafepay
 * Version: 0.1
 * Author: Robin de Laater
 * Author URI: https://delaater.nl/
 */

use QRTips\WooCommerce\OrderRequest;
use QRTips\WooCommerce\Transaction;

require 'vendor/autoload.php';

add_action('after_setup_theme', function () {
    require plugin_dir_path(__FILE__) . 'src/Transaction.php';
    require plugin_dir_path(__FILE__) . 'src/OrderRequest.php';
    require plugin_dir_path(__FILE__) . 'src/OrderRequest/PluginDetails.php';
    require plugin_dir_path(__FILE__) . 'src/OrderRequest/CustomerDetails.php';
    require plugin_dir_path(__FILE__) . 'src/OrderRequest/Address.php';
}, 5);

add_action('admin_init', function () {
    register_setting('qr_tips_options', 'qrtips_apikey');
    register_setting('qr_tips_options', 'qrtips_production');
    register_setting('qr_tips_options', 'qrtips_title');
    register_setting('qr_tips_options', 'qrtips_amount');
});

function qrTipsRegisterOptionsPage()
{
    add_options_page('QR Tips', 'QR Tips Settings', 'manage_options', 'qr-tips', 'qrTipsOptionsPage');
}

function qrTipsOptionsPage()
{
    require 'views/options.view.php';
}

add_action('admin_menu', 'qrTipsRegisterOptionsPage');

function generateQrCode(): string
{
    $apiKey = get_option('qrtips_apikey');
    $isProduction = get_option('qrtips_production');
    $qrTipsTitle = get_option('qrtips_title');

    if ($apiKey) {
        $customerData = [];

        if ($_POST) {
            $customerData = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'tel' => $_POST['tel'],
                'streetname' => $_POST['streetname'],
                'housenumber' => $_POST['housenumber'],
                'zipcode' => $_POST['zipcode'],
                'city' => $_POST['city'],
                'country' => $_POST['country']
            ];
        }

        if (!empty($customerData)) {
            $orderRequest = (new OrderRequest($_POST['amount']))->create($customerData);
            $transaction = new Transaction($apiKey, $isProduction, $orderRequest);
        }

        require 'views/qrtip.view.php';
    }

    return "<p style='color: blueviolet; text-decoration: underline; font-weight: 500;'>The QR Tips plugin won't work because
        you forgot to enter an API key!</p>";
}

add_shortcode('qr_tips', 'generateQrCode');