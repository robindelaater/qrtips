<div>
    <h1>QR Tips Options</h1>
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
        <?php submit_button(); ?>
    </form>
</div>