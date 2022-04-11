<?php
    use QRTips\WooCommerce\OrderRequest;
    use QRTips\WooCommerce\Transaction;

    if ($apiKey) {
        $orderRequest = (new OrderRequest($qrTipsAmount))->create();
        $transaction = new Transaction($apiKey, $isProduction, $orderRequest);
?>
    <div style="display: flex; flex-direction: column; text-align: center; max-width: 300px; background-color: rgba(0, 0, 0, 0.1); padding: 1em;">
        <h2 style="color: black; font-weight: 500;"> <?= $qrTipsTitle ?> </h2>
        <img style="margin-bottom: 1em;"
             src='https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?= $transaction->create() ?>&title="Link to payment page"'
             alt="Shitem"/>
        <p>Pay via MultiSafepay</p>
    </div>
<?php } else { ?>
    <p style='color: blueviolet; text-decoration: underline; font-weight: 500;'>The QR Tips plugin won't work because
        you forgot to enter an API key!</p>
<?php } ?>