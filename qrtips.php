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
}, 5);

add_action('admin_init', function () {
    register_setting('qr_tips_options', 'qrtips_apikey');
    register_setting('qr_tips_options', 'qrtips_production');
    register_setting('qr_tips_options', 'qrtips_title');
    register_setting('qr_tips_options', 'qrtips_amount');
});

function qrTipsOptionsPage()
{
    ?>
    <div>
        <h1>QR Tips Settings</h1>
        <form method="post" action="options.php"
              style="row-gap: 1rem; display: flex; flex-direction: column; max-width: 400px; width: 100%; padding-right:1em;">
            <?php settings_fields('qr_tips_options'); ?>
            <div style="display: flex; flex-direction: column; row-gap: 0.2rem;">
                <label style="font-weight: 600;" for="qrtips_apikey">MultiSafepay API key</label>
                <input type="text" style="width: 100%;" id="qrtips_apikey" name="qrtips_apikey"
                       value="<?php echo get_option('qrtips_apikey'); ?>"/>
            </div>
            <div style="display: flex; flex-direction: column; row-gap: 0.2rem;">
                <label style="font-weight: 600;" for="qrtips_production">API Mode</label>
                <select name="qrtips_production">
                    <option value=0 <?php if (!get_option('qrtips_production')) {
                        echo "selected";
                    } ?>>Test
                    </option>
                    <option value=1 <?php if (get_option('qrtips_production')) {
                        echo "selected";
                    } ?>>Live
                    </option>
                </select>
            </div>
            <div style="display: flex; flex-direction: column; row-gap: 0.2rem;">
                <label style="font-weight: 600;" for="qrtips_title">QR Tips Title</label>
                <input type="text" style="width: 100%;" id="qrtips_title" name="qrtips_title"
                       value="<?php echo get_option('qrtips_title'); ?>"/>
            </div>
            <div style="display: flex; flex-direction: column; row-gap: 0.2rem;">
                <label style="font-weight: 600;" for="qrtips_amount">QR Tips Amount (cents)</label>
                <input type="number" style="width: 100%;" id="qrtips_amount" name="qrtips_amount"
                       value="<?php echo get_option('qrtips_amount'); ?>"/>
            </div>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function qrTipsRegisterOptionsPage()
{
    add_options_page('QR Tips', 'QR Tips Settings', 'manage_options', 'qr-tips', 'qrTipsOptionsPage');
}

add_action('admin_menu', 'qrTipsRegisterOptionsPage');

function generateQrCode(): string
{
    $apiKey = get_option('qrtips_apikey');
    $isProduction = get_option('qrtips_production');
    $qrTipsTitle = get_option('qrtips_title');
    $qrTipsAmount = get_option('qrtips_amount');

    if ($apiKey) {
        $orderRequest = (new OrderRequest($qrTipsAmount))->create();
        $transaction = new Transaction($apiKey, $isProduction, $orderRequest);
        $content = '<div style="display: flex; flex-direction: column; text-align: center; max-width: 300px; background-color: rgba(0, 0, 0, 0.1); padding: 1em;">';
        $content .= '<h2 style="color: black; font-weight: 500;">' . $qrTipsTitle . '</h2>';
        $content .= '<img style="margin-bottom: 1em;" src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . $transaction->createTransaction() . '" title="Link to payment page" />';
        $content .= '<p>Pay via MultiSafepay</p>';
        $content .= '</div>';

        return $content;
    }

    return "<p style='color: blueviolet; text-decoration: underline; font-weight: 500;'>The QR Tips plugin won't work because you forgot to enter an API key!</p>";
}

add_shortcode('qr_tips', 'generateQrCode');