<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wordpress.org/plugins/kelkoo-group-shopping
 * @since      1.0.0
 *
 * @package    Kelkoo_Group_Shopping
 * @subpackage Kelkoo_Group_Shopping/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kelkoo_Group_Shopping
 * @subpackage Kelkoo_Group_Shopping/admin
 * @author     Kelkoo group
 */
class Kelkoo_Group_Shopping_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->options = get_option($this->plugin_name);
        add_action('wp_ajax_kga_validatesettings', array($this, 'validateSettings'));
        add_action('wp_ajax_kga_getads', array($this, 'ajaxGetAds'));
        add_action('wp_ajax_kga_create_ad', array($this, 'ajaxCreateAd'));
    }

    public function get_kelkoo_countries() {
        return array(
           'nb' => array('english' => 'Belgium (nl)', 'locale' => 'België'),
           'be' => array('english' => 'Belgium (fr)', 'locale' => 'Belgique'),
           'br' => array('english' => 'Brazil', 'locale' => 'Brazil'),
           'cz' => array('english' => 'Czech Republic', 'locale' => 'Česká Rep.'),
           'dk' => array('english' => 'Denmark', 'locale' => 'Danmark'),
           'de' => array('english' => 'Germany', 'locale' => 'Deutschland'),
           'ie' => array('english' => 'Ireland', 'locale' => 'Éireann'),
           'es' => array('english' => 'Spain', 'locale' => 'España'),
           'fr' => array('english' => 'France', 'locale' => 'France'),
           'it' => array('english' => 'Italy', 'locale' => 'Italia'),
           'mx' => array('english' => 'Mexico', 'locale' => 'Mexico'),
           'nl' => array('english' => 'Netherlands', 'locale' => 'Nederland'),
           'no' => array('english' => 'Norway', 'locale' => 'Norge'),
           'at' => array('english' => 'Austria', 'locale' => 'Österreich'),
           'pl' => array('english' => 'Poland', 'locale' => 'Polska'),
           'ru' => array('english' => 'Russia', 'locale' => 'Россия'),
           'pt' => array('english' => 'Portugal', 'locale' => 'Portugal'),
           'ch' => array('english' => 'Switzerland', 'locale' => 'Schweiz'),
           'fi' => array('english' => 'Finland', 'locale' => 'Suomi'),
           'se' => array('english' => 'Sweden', 'locale' => 'Sverige'),
           'uk' => array('english' => 'United Kingdom', 'locale' => 'United Kingdom'),
           'us' => array('english' => 'United States', 'locale' => 'United States')
        );
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Kelkoo_Group_Shopping_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Kelkoo_Group_Shopping_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/kelkoo-group-shopping-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Kelkoo_Group_Shopping_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Kelkoo_Group_Shopping_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
    }

    public function kelkoo_group_shopping_add_menu_items() {
        add_menu_page(
           'Kelkoo Group Shopping', 
           'Kelkoo Group Shopping', 
           'manage_categories', 
           'kelkoo_group_shopping_settings', 
           array(&$this, 'kelkoo_group_shopping_options_settings'),
           plugin_dir_url(__FILE__) . '/images/icon.png'
        );

        add_submenu_page(
           'kelkoo_group_shopping_settings',
           __('Kelkoo Group Shopping',
           'kelkoo-group-shopping') . ' - ' . __('Settings', 'kelkoo-group-shopping'),
           __('Settings', 'kelkoo-group-shopping'), 
           'manage_options', 
           'kelkoo_group_shopping_settings', 
           array(&$this, 'kelkoo_group_shopping_options_settings')
        );

        add_submenu_page('kelkoo_group_shopping_settings',
           __('Kelkoo Group Shopping',
           'kelkoo-group-shopping') . ' - ' . __('Ad Builder', 'kelkoo-group-shopping'),
           __('Ad Builder', 'kelkoo-group-shopping'),
           'manage_categories',
           'kelkoo_group_shopping_settings_ad_builder', array(
           &$this, 'kelkoo_group_shopping_options_ad_builder')
        );
        
        add_submenu_page('kelkoo_group_shopping_settings',
           __('Kelkoo Group Shopping',
           'kelkoo-group-shopping') . ' - ' . __('Performance', 'kelkoo-group-shopping'),
           __('Performance', 'kelkoo-group-shopping'),
           'manage_categories',
           'kelkoo_group_shopping_settings_performance',
           array(&$this, 'kelkoo_group_shopping_options_performance')
        );
    }

    public function kelkoo_group_shopping_options_settings() {
        wp_enqueue_script("settings", plugin_dir_url(__FILE__) . 'js/kelkoo-group-shopping-settings.js', array('jquery'), $this->version);

        $this->i18n = json_encode(array(
           "invalidSettings" => __('Your settings are invalid, please check all fields', 'kelkoo-group-shopping')
        ));

        include(plugin_dir_path(__FILE__) . '/settings.php');
    }

    public function kelkoo_group_shopping_options_ad_builder() {
        wp_enqueue_style("color-picker", plugin_dir_url(__FILE__) . 'lib/colorpicker/colorpicker.min.css', array(), $this->version, 'all');


        wp_enqueue_script("kelkoo-ads", '//ads.kelkoo.com/javascripts/scout.js', array(), $this->version);
        wp_enqueue_script("color-picker", plugin_dir_url(__FILE__) . 'lib/colorpicker/colorpicker.min.js', array('jquery'), $this->version);
        wp_enqueue_script("font-awesome", 'https://use.fontawesome.com/fe15dcfe9c.js', array(), $this->version, 'all');

//		wp_enqueue_script("helper", plugin_dir_url( __FILE__ ) . 'js/kelkoo-group-shopping-helper.js', array('jquery'), $this->version);
        wp_enqueue_script("ad-builder", plugin_dir_url(__FILE__) . 'js/kelkoo-group-shopping-ad-builder.js', array('jquery'), $this->version);
        wp_enqueue_script("existing-ads", plugin_dir_url(__FILE__) . 'js/kelkoo-group-shopping-existing-ads.js', array('jquery', 'jquery-ui-dialog'), $this->version);
        wp_enqueue_script("admin", plugin_dir_url(__FILE__) . 'js/kelkoo-group-shopping-admin.js', array('jquery'), $this->version);

        $this->adPreviewDefaultConf = array(
           "templateId" => "grid",
           "templateSize" => "lrec",
           "nbOffers" => 1,
           "displayButton" => "false",
           "font" => "arial",
           "urlColor" => "#333333",
           "priceColor" => "#F56026",
           "backgroundColor" => "#FFFFFF",
           "borderColor" => "#DADADA",
           "merchantColor" => "#30405D",
           "displayKelkooLogo" => "false"
        );

        include(plugin_dir_path(__FILE__) . '/ad-builder.php');
    }

    public function kelkoo_group_shopping_options_performance() {
        include(plugin_dir_path(__FILE__) . 'performance.php');
    }

    function kelkoo_group_shopping_add_editor_button($plugin_array) {
        $plugin_array['kelkoo_group_shopping'] = plugins_url() . '/kelkoo-group-shopping/admin/js/kelkoo-group-shopping-editor-plugin.js';
        return $plugin_array;
    }

    function kelkoo_group_shopping_register_buttons($buttons) {

        array_push($buttons, 'kelkoogroup_ad_shortcode');
        return $buttons;
    }

    function validateSettings() {
        include_once plugin_dir_path(__FILE__) . '/../includes/class-kelkoo-group-shopping-urlsigner.php';
        $signedUrl = KelkooGroupShoppingUrlSigner::signUrl('http://adservice.kelkoogroup.net', '/ads', $_POST['trackingId'], $_POST['accessKey'], $_POST['country']);

        $curl = curl_init();
        curl_setopt_array($curl, array(
           CURLOPT_URL => $signedUrl,
           CURLOPT_RETURNTRANSFER => 1,
           CURLOPT_USERAGENT => 'Kelkoo Group Shopping (wordpress plugin)',
           CURLOPT_HTTPHEADER, array('Content-Type: application/json')
        ));

        $resp = curl_exec($curl);

        header("Content-Type: application/json; charset=UTF-8");
        ?>{ "ads" : <?php echo $resp; ?> }<?php
        curl_close($curl);

        wp_die();
    }

    function ajaxGetAds() {
        include_once plugin_dir_path(__FILE__) . '/../includes/class-kelkoo-group-shopping-urlsigner.php';
        $signedUrl = KelkooGroupShoppingUrlSigner::signUrl('http://adservice.kelkoogroup.net', '/ads');

        $curl = curl_init();
        curl_setopt_array($curl, array(
           CURLOPT_URL => $signedUrl,
           CURLOPT_RETURNTRANSFER => 1,
           CURLOPT_USERAGENT => 'Kelkoo Group Shopping (wordpress plugin)',
           CURLOPT_HTTPHEADER, array('Content-Type: application/json')
        ));

        $resp = curl_exec($curl);
        if (!$resp) {
            $resp = '{}';
        }


        $options = get_option('kelkoo-group-shopping');

        header("Content-Type: application/json; charset=UTF-8");
        ?>{ "ads" : <?php echo $resp; ?>,
        "country": "<?php echo $options['country']; ?>",
        "trackingId": "<?php echo $options['trackingId']; ?>"

        }<?php
        curl_close($curl);

        wp_die();
    }

    public function ajaxCreateAd() {
        include_once plugin_dir_path(__FILE__) . '/../includes/class-kelkoo-group-shopping-urlsigner.php';
        $signedUrl = KelkooGroupShoppingUrlSigner::signUrl('http://adservice.kelkoogroup.net', '/ads' . $_POST['queryString']);

        $data = json_encode($_POST['adStyle']);

        $curl = curl_init();
        curl_setopt_array($curl, array(
           CURLOPT_URL => $signedUrl,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_CUSTOMREQUEST => "POST",
           CURLOPT_POSTFIELDS => $data,
           CURLOPT_USERAGENT => 'Kelkoo Group Shopping (wordpress plugin)',
           CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json'
           )
        ));

        $result = curl_exec($curl);

        header("Content-Type: application/json; charset=UTF-8");
        echo $result;

        curl_close($curl);

        wp_die();
    }

}
