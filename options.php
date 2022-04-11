<?php

if ($_POST) {
    $api_key = $_POST['qrtips_apikey'];
    $production = $_POST['qrtips_production'];
    $qrTipsTitle = $_POST['qrtips_title'];
    update_option('qrtips_apikey', $api_key);
    update_option('qrtips_production', $production);
    update_option('qrtips_title', $qrTipsTitle);
}