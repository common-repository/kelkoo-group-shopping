<?php
$translations = array(
   
   "no-ads" => __('There is no ads to show. Please use the ad builder to create your first one.', 'kelkoo-group-shopping'),
   "ws-error" => __('Unable to connect to get existing ads. Verify your internet connection and please reload.', 'kelkoo-group-shopping'),
   
   "templateId" => array(
      "grid" => __('Grid', 'kelkoo-group-shopping'),
      "carousel" => __('Carousel', 'kelkoo-group-shopping'),
      "text" => __('Text', 'kelkoo-group-shopping'),
      "modern" => __('Modern', 'kelkoo-group-shopping'),
      "modern2" => __('Modern V2', 'kelkoo-group-shopping'),
      "gridcarousel" => __('Grid paginated', 'kelkoo-group-shopping'),
      "merchant" => __('Merchant branded', 'kelkoo-group-shopping'),
      "reveal" => __('Reveal', 'kelkoo-group-shopping'),
      "beats" => __('Beats', 'kelkoo-group-shopping'),
      "mcarousel" => __('Carousel mobile', 'kelkoo-group-shopping'),
      "mobile" => __('Mobile', 'kelkoo-group-shopping'),
      "dynamic" => __('Dynamic', 'kelkoo-group-shopping')
   ),
   "templateSize" => array(
      "banner" => __('Leaderboard (728x90)', 'kelkoo-group-shopping'),
      "superldb" => __('Super Leaderboard (970x90)', 'kelkoo-group-shopping'),
      "lrec" => __('Medium rectangle (300x250)', 'kelkoo-group-shopping'),
      "smallskyscraper" => __('Skyscraper (120x600)', 'kelkoo-group-shopping'),
      "skyscraper" => __('Wide skyscraper (160x600)', 'kelkoo-group-shopping'),
      "halfskyscraper" => __('Half skyscraper (160x350)', 'kelkoo-group-shopping'),
      "monster" => __('Half page (300x600)', 'kelkoo-group-shopping'),
      "billboard" => __('Billboard (970x250)', 'kelkoo-group-shopping'),
      "responsive" => __('Responsive', 'kelkoo-group-shopping'),
      "fixed_width" => __('Fixed width', 'kelkoo-group-shopping'),
      "mobile" => __('Mobile (320x50)', 'kelkoo-group-shopping'),
      "mobile2" => __('Mobile V2 (320x50)', 'kelkoo-group-shopping'),
      "supermobile" => __('Supermobile (640x106)', 'kelkoo-group-shopping'),
      "tablet" => __('Tablet (1249x159)', 'kelkoo-group-shopping'),
      "lbc" => __('LBC', 'kelkoo-group-shopping'),
      "custom600x100" => __('600 x 100 px', 'kelkoo-group-shopping'),
      "custom301x100" => __('301 x 100 px', 'kelkoo-group-shopping'),
      "custom1408x500" => __('1408 x 500 px', 'kelkoo-group-shopping'),
      "custom728x180" => __('728 x 180 px', 'kelkoo-group-shopping'),
      "custom930x180" => __('930 x 180 px', 'kelkoo-group-shopping'),
      "skin" => __('1920 x 880 px', 'kelkoo-group-shopping'),
      "custom1000x90" => __('1000 x 90px', 'kelkoo-group-shopping'),
      "subito" => __('Native Subito', 'kelkoo-group-shopping'))
);
?>
<table class="kga-table js-kelkoo-group-shopping-existing-ads" data-translations='<?php echo json_encode($translations); ?>'>
    <thead class="kga-table-head">
        <tr>
            <th class="sortable" data-id="name">
                <span><?php echo __('Name', 'kelkoo-group-shopping') ?></span>
                <i class="fa fa-sort" aria-hidden="true"></i>
            </th>
            <th class="sortable" data-id="id" style="min-width: 26px;">
                <span><?php echo __('Id', 'kelkoo-group-shopping') ?></span>
                <i class="fa fa-sort-asc" aria-hidden="true"></i>
            </th>
            <th class="sortable" data-id="templateId">
                <span><?php echo __('Type', 'kelkoo-group-shopping') ?></span>
                <i class="fa fa-sort" aria-hidden="true"></i>
            </th>
            <th class="sortable" data-id="templateSize">
                <span><?php echo __('Size', 'kelkoo-group-shopping') ?></span>
                <i class="fa fa-sort" aria-hidden="true"></i>
            </th>
            <th>Shortcode</th>
            <th class="preview-ad"></th>
        </tr>
    </thead>
    <tbody class="kga-table-body">
        <tr style="background: none;">
            <td colspan="5" style="background: none; height: 200px;">
                <div class="kga-spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
