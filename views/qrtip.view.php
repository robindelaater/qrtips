<section>
    <div style="display: flex; flex-direction: column; text-align: center; max-width: 300px; background-color: rgba(0, 0, 0, 0.1); padding: 1em;">
        <h2 style="color: black; font-weight: 500;">
            <?= $qrTipsTitle ?>
        </h2>
        <?php
        if (!$orderRequest) {
            ?>
            <form method="POST" id="qrtipForm">
                <input type="text" name="firstname" placeholder="firstname" required>
                <input type="text" name="lastname" placeholder="lastname" required>
                <input type="email" name="email" placeholder="email" required>
                <input type="tel" name="tel" placeholder="phonenumber" required>
                <input type="text" name="streetname" placeholder="streetname" required>
                <input type="text" name="housenumber" placeholder="housenumber" required>
                <input type="text" name="zipcode" placeholder="zipcode" required>
                <input type="text" name="city" placeholder="city" required>
                <select type="text" name="country">
                    <option value="NL">The Netherlands</option>
                </select>
                <div>
                    <p>Amount in cents:</p>
                    <input type="number" name="amount" required value="100">
                </div>
                <button id="qrtipButton" type="submit">Submit</button>
            </form>
            <?php
        } else {
            ?>
            <img id="qrtip-img"
                 src='https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?= $transaction->create() ?>&title="Link to payment page"'
                 alt="">
            <h2>€<?= $_POST['amount'] / 100 ?></h2>
            <?php
        }
        ?>

        <p>Pay via MultiSafepay</p>
    </div>
</section>

<script>
    const button = document.getElementById('qrtipButton');
    button.addEventListener('click', (event) => {
        event.preventDefault();

        const firstname = event.target.firstname.value()
        document.cookie = `firstname=${firstname}`

        <?php
        $firstname = $_COOKIE['firstname'];
        echo $firstname;

        $customerData = [];

        $orderRequest = (new OrderRequest($qrTipsAmount))->create($customerData);
        $transaction = new Transaction($apiKey, $isProduction, $orderRequest);
        ?>

        const img = document.getElementById('qrtip-img');
        img.src =

        const form = document.getElementById('qrtip-form');
        form.hidden = true;
    })
</script>