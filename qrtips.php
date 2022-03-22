<?php

use QRTips\WooCommerce\QRTip;

require 'vendor/autoload.php';

if ($_POST) {
  $api_key = $_POST['qrtips_apikey'];
  $production = $_POST['qrtips_production'];
  $qrTipsTitle = $_POST['qrtips_title'];
  $qrTipsAmount = $_POST['qrtips_amount'];
  update_option('qrtips_apikey', $api_key);
  update_option('qrtips_production', $production);
  update_option('qrtips_title', $qrTipsTitle);
  update_option('qrtips_amount', $qrTipsAmount);
}


add_action('after_setup_theme', function () {
  require plugin_dir_path(__FILE__) . 'src/QRTip.php';
}, 5);

function qrTipsOptionsPage()
{
  if (!get_option('qrtips_apikey')) {
    add_option('qrtips_apikey');
  }

  if (!get_option('qrtips_production')) {
    add_option('qrtips_production');
  }

  if (!get_option('qrtips_title')) {
    add_option('qrtips_title', "QR Tips!");
  }

  if (!get_option('qrtips_amount')) {
    add_option('qrtips_amount', 500);
  }

  ?>
  <div>
    <h1>QR Tips Settings</h1>
    <form method="post" style="row-gap: 1rem; display: flex; flex-direction: column; max-width: 400px; width: 100%; padding-right:1em;">
      <?php settings_fields('qrTipsOptionsField'); ?>
      <div style="display: flex; flex-direction: column; row-gap: 0.2rem;">
        <label style="font-weight: 600;" for="qrtips_apikey">MultiSafepay API key</label>
        <input type="text" style="width: 100%;" id="qrtips_apikey" name="qrtips_apikey"
               value="<?php echo get_option('qrtips_apikey'); ?>"/>
      </div>
      <div style="display: flex; flex-direction: column; row-gap: 0.2rem;">
        <label style="font-weight: 600;" for="qrtips_production">API Mode</label>
        <select name="qrtips_production">
          <option value=0 <?php if(!get_option('qrtips_production')) {  echo "selected";  } ?>>Test</option>
          <option value=1 <?php if(get_option('qrtips_production')) { echo "selected"; } ?>>Live</option>
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
    $transaction = new QRTip($apiKey, $isProduction, $qrTipsAmount);
    $content = '<div style="display: flex; flex-direction: column; text-align: center; max-width: 300px; background-color: rgba(0, 0, 0, 0.1); padding: 1em;">';
    $content .= '<h2 style="color: black; font-weight: 500;">'.$qrTipsTitle.'</h2>';
    $content .= '<img style="margin-bottom: 1em;" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $transaction->createTransaction() . '" title="Link to payment page" />';
    $content .= '<p>Pay via MultiSafepay</p>';
    $content .= '</div>';

    return $content;
  }

  return "<p style='color: blueviolet; text-decoration: underline; font-weight: 500;'>The QR Tips plugin won't work because you forgot to enter an API key!</p>";
}

add_shortcode('qr_tips', 'generateQrCode');