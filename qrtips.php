<?php

/**
 * Plugin Name: QR Tips
 * Description: Generates iDEAL QR code for donations
 * Version: 0.0.1
 * Author: Robin de Laater
 * Author URI: https://delaater.nl/
 */

use QRTip\WooCommerce\QRTip;

add_action('admin_init', 'child_plugin_has_parent_plugin');
add_action('after_setup_theme', 'setup', 5);

add_shortcode('qr_tips', 'qrTipsOutput');

function setup()
{
  require plugin_dir_path(__FILE__) . 'src/QRTip.php';
}

/**
 * Require MultiSafepay plugin to be installed.
 * @return void
 */
function child_plugin_has_parent_plugin()
{
  if (is_admin() && current_user_can('activate_plugins') && !is_plugin_active('multisafepay/multisafepay.php')) {
    add_action('admin_notices', 'child_plugin_notice');

    deactivate_plugins(plugin_basename(__FILE__));

    if (isset($_GET['activate'])) {
      unset($_GET['activate']);
    }
  }
}

function child_plugin_notice()
{
  ?>
  <div class="error"><p>Sorry, but the QR Tips plugin requires the MultiSafepay Payments plugin to be installed and
      active.</p></div><?php
}

function qrTipsOutput(): string
{
  $qrtip = new QRTip();
  return $qrtip->show();
}
