<?php

use QRTips\WooCommerce\Transaction;

require 'vendor/autoload.php';

add_action('after_setup_theme', function () {
  require plugin_dir_path(__FILE__) . 'src/Transaction.php';
}, 5);

function shortCodeOutput(): string
{
  $transaction = new Transaction(2000);
  $content = '<div style="display: flex; flex-direction: column; text-align: center; max-width: 300px; background-color: rgba(0, 0, 0, 0.1);">';
  $content .= '<h1 style="color: white; font-weight: 500;">Give a tip!</h1>';
  $content .= '<img style="margin-bottom: 1em;" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $transaction->createTransaction() . '" title="Link to payment page" />';
  $content .= '<p>Powered by MultiSafepay</p>';
  $content .= '</div>';

  return $content;
}

add_shortcode('qr_tips', 'shortCodeOutput');