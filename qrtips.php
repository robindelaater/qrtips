<?php

/**
 * Plugin Name: QR Tips
 * Description: Generates iDEAL QR code for donations
 * Version: 0.0.1
 * Author: Robin de Laater
 * Author URI: https://delaater.nl/
 */

add_shortcode('qr_tips', 'qr_tips_output');

function qr_tips_output(): string
{
  return "<h1>Hello, world!</h1>";
}