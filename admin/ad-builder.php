<?php $missingSettings = empty($this->options['trackingId']) || empty($this->options['accessKey']) || empty($this->options['country']) ?>

<?php include "partials/header.php" ?>

<div class="kelkoo-group-shopping ad-builder-page">
	<h2><?php echo esc_html(get_admin_page_title()); ?></h2>

	<div class="breadcrumb">
        <a href="admin.php?page=kelkoo_group_shopping_settings"><?php echo __( 'Settings', 'kelkoo-group-shopping' ); ?></a> 
        | <?php echo __( 'Ad Builder', 'kelkoo-group-shopping' ); ?>
        | <a href="admin.php?page=kelkoo_group_shopping_settings_performance"><?php echo __( 'Performance', 'kelkoo-group-shopping' ); ?></a>

    </div>

<?php if ($missingSettings) { ?>
	<alert class="alert" >
        <?php printf(__('Before configuring your ads, please <a href="%s">update your settings</a>', 'kelkoo-group-shopping'), "admin.php?page=kelkoo_group_shopping_settings");
        ?>
    </alert>
<?php } else { ?>
	<div class="pannel ad-builder">
		<h3><?php echo __( 'Create new ad', 'kelkoo-group-shopping' ); ?></h3>

		<form name="kelkoo-group-shopping-ad-builder" id="kelkoo-group-shopping-ad-builder" method="post" class="form">
			<div class="parameters">
				<input type="hidden" name="displayButton" value="<?php echo $this->adPreviewDefaultConf['displayButton']; ?>">
				<input type="hidden" name="displayKelkooLogo" value="<?php echo $this->adPreviewDefaultConf['displayKelkooLogo']; ?>">
				<label>
					<span><?php echo __( 'Ad Name', 'kelkoo-group-shopping' ); ?></span>
					<input type="text" name="name" required />
				</label>
				<label>
					<span><?php echo __( 'Ad Type', 'kelkoo-group-shopping' ); ?></span>
					<select name="templateId">
						<option value="<?php echo $this->adPreviewDefaultConf['templateId']; ?>"><?php echo __( 'Grid', 'kelkoo-group-shopping' ); ?></option>
						<option value="dynamic"><?php echo __( 'Dynamic', 'kelkoo-group-shopping' ); ?></option>
					</select>
				</label>
				<label>
					<span><?php echo __( 'Dimensions', 'kelkoo-group-shopping' ); ?></span>
					<select name="templateSize">
						<option value="<?php echo $this->adPreviewDefaultConf['templateSize']; ?>"><?php echo __( 'Medium rectangle (300x250)', 'kelkoo-group-shopping' ); ?></option>
						<option value="responsive"><?php echo __( 'Responsive', 'kelkoo-group-shopping' ); ?></option>
					</select>
				</label>
				<label>
					<span><?php echo __( 'Number of offers', 'kelkoo-group-shopping' ); ?></span>
					<select name="nbOffers">
                                            <?php for($i=1; $i<5; $i++) : ?>
						<option value="<?php echo $i ?>" <?php echo $i > 3 ? ' disabled=""' : ''; ?>><?php echo $i ?></option>
                                            <?php endfor; ?>
						<option value="10" disabled=""><?php echo __( 'Maximum', 'kelkoo-group-shopping' ); ?></option>

					</select>
				</label>
				<label>
					<span><?php echo __( 'Font', 'kelkoo-group-shopping' ); ?></span>
					<select data-ad-style="font">
						<option value="montserrat" <?php echo $this->adPreviewDefaultConf['font'] == "montserrat" ? "selected" : ""; ?>><?php echo __( 'Montserrat', 'kelkoo-group-shopping' ); ?></option>
						<option value="arial" <?php echo $this->adPreviewDefaultConf['font'] == "arial" ? "selected" : ""; ?>><?php echo __( 'Arial', 'kelkoo-group-shopping' ); ?></option>
						<option value="verdana" <?php echo $this->adPreviewDefaultConf['font'] == "verdana" ? "selected" : ""; ?>><?php echo __( 'Verdana', 'kelkoo-group-shopping' ); ?></option>
						<option value="times" <?php echo $this->adPreviewDefaultConf['font'] == "times" ? "selected" : ""; ?>><?php echo __( 'Times', 'kelkoo-group-shopping' ); ?></option>
					</select>
					<input type="text" class="color-picker" data-ad-style="urlColor" value="<?php echo $this->adPreviewDefaultConf['urlColor']; ?>" title="<?php echo __( 'Title color', 'kelkoo-group-shopping' ); ?>" style="background-color: <?php echo $this->adPreviewDefaultConf['urlColor']; ?>; color: <?php echo $this->adPreviewDefaultConf['urlColor']; ?>;">
					<input type="text" class="color-picker" data-ad-style="priceColor" value="<?php echo $this->adPreviewDefaultConf['priceColor']; ?>" title="<?php echo __( 'Price color', 'kelkoo-group-shopping' ); ?>" style="background-color: <?php echo $this->adPreviewDefaultConf['priceColor']; ?>; color: <?php echo $this->adPreviewDefaultConf['priceColor']; ?>;">
                    <input type="text" class="color-picker" data-ad-style="merchantColor" value="<?php echo $this->adPreviewDefaultConf['merchantColor']; ?>" title="<?php echo __( 'Merchant color', 'kelkoo-group-shopping' ); ?>" style="background-color: <?php echo $this->adPreviewDefaultConf['merchantColor']; ?>; color: <?php echo $this->adPreviewDefaultConf['merchantColor']; ?>;">
				</label>
                <label>
                    <span><?php echo __( 'Ad Colors', 'kelkoo-group-shopping' ); ?></span>
                    <input type="text" class="color-picker" data-ad-style="backgroundColor" value="<?php echo $this->adPreviewDefaultConf['backgroundColor']; ?>" title="<?php echo __( 'Background color', 'kelkoo-group-shopping' ); ?>" style="background-color: <?php echo $this->adPreviewDefaultConf['backgroundColor']; ?>; color: <?php echo $this->adPreviewDefaultConf['backgroundColor']; ?>;">
                    <input type="text" class="color-picker" data-ad-style="borderColor" value="<?php echo $this->adPreviewDefaultConf['borderColor']; ?>" title="<?php echo __( 'Border color', 'kelkoo-group-shopping' ); ?>" style="background-color: <?php echo $this->adPreviewDefaultConf['borderColor']; ?>; color: <?php echo $this->adPreviewDefaultConf['borderColor']; ?>;">
                </label>
			</div>
			<div class="submit">
				<input type="submit" value="<?php echo __( 'Create new ad', 'kelkoo-group-shopping' ); ?>" class="button button-primary">
			</div>
		</form>

		<h3><?php echo __( 'Preview ad', 'kelkoo-group-shopping' ); ?></h3>

		<div class="preview-content">
			<div id="preview-ad" class="js-kelkoo-widget"
				data-kw-from-pbo="true"
				data-kw-country="<?php echo $this->options['country']; ?>"
				data-kw-tracking-id="<?php echo $this->options['trackingId']; ?>"
				data-kw-ad-id="-1"
				data-kw-template-id="<?php echo $this->adPreviewDefaultConf['templateId']; ?>"
				data-kw-template-size="<?php echo $this->adPreviewDefaultConf['templateSize']; ?>"
				data-kw-nb-offers="<?php echo $this->adPreviewDefaultConf['nbOffers']; ?>"
				data-kw-font="<?php echo $this->adPreviewDefaultConf['font']; ?>"
				data-kw-url-color="<?php echo $this->adPreviewDefaultConf['urlColor']; ?>"
				data-kw-price-color="<?php echo $this->adPreviewDefaultConf['priceColor']; ?>"
				data-kw-background-color="<?php echo $this->adPreviewDefaultConf['backgroundColor']; ?>"
				data-kw-border-color="<?php echo $this->adPreviewDefaultConf['borderColor']; ?>"
				data-kw-merchant-color="<?php echo $this->adPreviewDefaultConf['merchantColor']; ?>"
				data-kw-keyword="iphone"
				data-kw-display-button="<?php echo $this->adPreviewDefaultConf['displayButton']; ?>"
				data-kw-has-impression-log="false"
				data-kw-display-kelkoo-logo="<?php echo $this->adPreviewDefaultConf['displayKelkooLogo']; ?>">
                            <div class="kga-spinner">
                                <div class="rect1"></div>
                                <div class="rect2"></div>
                                <div class="rect3"></div>
                                <div class="rect4"></div>
                                <div class="rect5"></div>
                            </div>
			</div>
		</div>
	</div>

	<div class="pannel existing-ads">
		<h3><?php echo __( 'Preview existing ads', 'kelkoo-group-shopping' ); ?></h3>
		<?php include(plugin_dir_path(__FILE__) . '/partials/existing-ads.php'); ?>

	</div>
<?php } ?>
</div>