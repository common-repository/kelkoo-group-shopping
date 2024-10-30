<?php $missingSettings = empty($this->options['trackingId']) || empty($this->options['accessKey']) || empty($this->options['country']) ?>

<?php include "partials/header.php" ?>

<div class="kelkoo-group-shopping performance-page">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <div class="breadcrumb">
        <a href="admin.php?page=kelkoo_group_shopping_settings"><?php echo __('Settings', 'kelkoo-group-shopping'); ?></a> 
        | <a href="admin.php?page=kelkoo_group_shopping_settings_ad_builder"><?php echo __('Ad Builder', 'kelkoo-group-shopping'); ?></a>
        | <?php echo __('Performance', 'kelkoo-group-shopping'); ?>
    </div>

<?php if ($missingSettings) { ?>
    <alert class="alert" >
        <?php printf(__('Please <a href="%s">update your settings</a> first', 'kelkoo-group-shopping'), "admin.php?page=kelkoo_group_shopping_settings");
        ?>
    </alert>
<?php } else { ?>
    <alert class="alert" >
        <?php printf(__('<p>In a future version of the plugin, ads performances would be displayed on this page.</p><p>For now, please referer to the "<a href="%s" target="_blank">Dashboard</a>" on Kelkoo publisher network.</p>', 'kelkoo-group-shopping'), "https://partner.kelkoo.com/protected/statsSelection");
        ?>
    </alert>
    
    <p><img src="<?php echo esc_url(plugin_dir_url(__FILE__) . '/images/performance.jpg'); ?>" style="opacity: 0.4"/></p>
<?php } ?>
</div>