<?php
if (isset($_POST['submitted'])) {
    $saveSuccess = false;
    check_admin_referer( $this->plugin_name . 'post_settings' );

    $safe_trackingId = intval(sanitize_text_field($_POST['trackingId']));
    if (!$safe_trackingId) {
      $safe_trackingId = '';
    }

    $safe_accessKey = sanitize_text_field($_POST['accessKey']);

    $safe_country = sanitize_text_field($_POST['country']);
    if (!preg_match('/[a-z]{2}/', $safe_country)) {
        $safe_country = '';
    }

    if (!empty($safe_trackingId) && !empty($safe_accessKey) && !empty($safe_country)) {
        $this->options['trackingId'] = $safe_trackingId;
        $this->options['accessKey'] = $safe_accessKey;
        $this->options['country'] = $safe_country;

        update_option($this->plugin_name, $this->options);
        $saveSuccess = true;
    }
}
?>

<?php include "partials/header.php" ?>

<div class="kelkoo-group-shopping settings-page">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <div class="breadcrumb">
        <?php echo __( 'Settings', 'kelkoo-group-shopping' ); ?> 
        | <a href="admin.php?page=kelkoo_group_shopping_settings_ad_builder"><?php echo __( 'Ad Builder', 'kelkoo-group-shopping' ); ?></a>
        | <a href="admin.php?page=kelkoo_group_shopping_settings_performance"><?php echo __( 'Performance', 'kelkoo-group-shopping' ); ?></a>

    </div>

    <alert class="alert">
        <?php printf(__('The following fields are required in order to send requests to <b>Kelkoo</b> and retrieve data about products and listings. If you do not already have access keys set up, please visit the <a href="%s" target="_blank">KK Publisher Signup page</a> to create and retrieve them.', 'kelkoo-group-shopping'), "https://partner.kelkoo.com/signup?origin=wordpress");
        ?>
    </alert>
    <?php if(!($this->options && is_array($this->options) && array_key_exists('country', $this->options))) : ?>
    <alert class="alert">
        <?php printf(__('Once your account created, log and copy paste settings from our <a href="%s">partner extranet</a>', 'kelkoo-group-shopping'), "https://partner.kelkoo.com/protected/ecommerceServices");
        ?>
    </alert>
    <?php endif; ?>

    <p><?php echo __('Are required in order to send request to Kelkoo API', 'kelkoo-group-shopping'); ?></p>

    <form name="kelkoo-group-shopping-settings" id="kelkoo-group-shopping-settings" method="post" class="form" data-i18n='<?php echo $this->i18n; ?>'>
        <div class="parameters">
            <?php echo wp_nonce_field( $this->plugin_name . 'post_settings' ); ?>
            <input type="hidden" name="submitted" value="1">
            <label>
                <span><?php echo __('TrackingID', 'kelkoo-group-shopping'); ?></span>
                <input type="number" name="trackingId" value="<?php echo $this->options['trackingId']; ?>" required >
            </label>
            <label>
                <span><?php echo __('AccessKey', 'kelkoo-group-shopping'); ?></span>
                <input type="text" name="accessKey"  value="<?php echo $this->options['accessKey']; ?>" required >
            </label>
            <label>
                <span><?php echo __('Country', 'kelkoo-group-shopping'); ?></span>
                <select name="country" required >
                    <option value=""></option>
                    <?php
                    foreach ($this->get_kelkoo_countries() as $key => $country) {
                        $selected = ($key == $this->options['country']) ? " selected" : "";
                        echo '<option value="' . $key . '"' . $selected . ' >' . $country['locale'] . ' - ' . strtoupper($key) . '</option>';
                    }
                    ?>
                </select>
            </label>
        </div>
        <div class="submit">
            <input type="submit" class="button button-primary" value="<?php echo __('Update', 'kelkoo-group-shopping'); ?>">
        </div>
    </form>
    <?php
    if (isset($saveSuccess)) {
        if ($saveSuccess) {
            echo '<alert class="alert ok">' . __('Your settings are saved', 'kelkoo-group-shopping') . '</alert>';
        } else {
            echo '<alert class="alert warning">' . __('Unable to save, please check all fields are correctly filled', 'kelkoo-group-shopping') . '</alert>';
        }
    }
    ?>
</div>