<?php

/**
 * The shortcode functionality of the plugin.
 *
 * @link       https://wordpress.org/plugins/kelkoo-group-shopping
 * @since      1.0.0
 * @package    Kelkoo_Group_Shopping
 * @subpackage Kelkoo_Group_Shopping/public
 * @author     Kelkoo group
 */
class Kelkoo_Group_Shopping_Shortcode {

    static $scoutLoaded = false;

    public function __construct() {

        add_shortcode('kelkoogroup_ad', array($this, 'ad_html'));
    }

    public function ad_html($atts) {

        $atts = shortcode_atts(array(
           'kw' => -1,
           'id' => -1
           ), $atts, 'kelkoogroup_ad');

        $options = get_option('kelkoo-group-shopping');
        $trackingId = $options['trackingId'];
        $country = $options['country'];

        if (!self::$scoutLoaded) {
            wp_enqueue_script('class-kelkoo-group-shopping', '//ads.kelkoo.com/javascripts/scout.js', null, false);
        }
        self::$scoutLoaded = true;
        
        return '<div class="js-kelkoo-widget" data-kw-country="' . $country . '" data-kw-tracking-id="' . $trackingId . '" '
           . 'data-kw-ad-id="' . $atts['id'] . '" data-kw-keyword="' . $atts['kw'] . '" '
           . '></div>';
    }

}
