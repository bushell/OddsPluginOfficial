<?php







/**



 * The admin-specific functionality of the plugin.



 *



 * @link       Gambling Ninja



 * @since      1.0.0



 *



 * @package    Horse_Exchange



 * @subpackage Horse_Exchange/admin



 */







/**



 * The admin-specific functionality of the plugin.



 *



 * Defines the plugin name, version, and two examples hooks for how to



 * enqueue the admin-specific stylesheet and JavaScript.



 *



 * @package    Horse_Exchange



 * @subpackage Horse_Exchange/admin



 * @author     Gambling Ninja <support@gamblingninja.com>



 */



class Horse_Exchange_Admin {







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



    public function __construct( $plugin_name, $version ) {







        $this->plugin_name = $plugin_name;



        $this->version = $version;







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



           * defined in Wp_Cbf_Loader as all of the hooks are defined



           * in that particular class.



           *



           * The Wp_Cbf_Loader will then create the relationship



           * between the defined hooks and the functions defined in this



           * class.



         */             



         if ( 'settings_page_horse-exchange' == get_current_screen() -> id ) {



             // CSS stylesheet for Color Picker



             wp_enqueue_style( 'wp-color-picker' );            



             wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/horse-exchange-admin.css', array( 'wp-color-picker' ), $this->version, 'all' );



             

         }







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



         * defined in Wp_Cbf_Loader as all of the hooks are defined



         * in that particular class.



         *



         * The Wp_Cbf_Loader will then create the relationship



         * between the defined hooks and the functions defined in this



         * class.



         */



        if ( 'settings_page_horse-exchange' == get_current_screen() -> id ) {



            wp_enqueue_media();   



            wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/horse-exchange-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );         



        }







    }







    /**



*



* admin/class-wp-cbf-admin.php - Don't add this



*



**/







/**



 * Register the administration menu for this plugin into the WordPress Dashboard menu.



 *



 * @since    1.0.0



 */







public function add_plugin_admin_menu() {







    /*



     * Add a settings page for this plugin to the Settings menu.



     *



     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.



     *



     *        Administration Menus: http://codex.wordpress.org/Administration_Menus



     *



     */



    add_options_page( 'Horse Betting Odds', 'Horse Betting Odds', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')



    );



}







 /**



 * Add settings action link to the plugins page.



 *



 * @since    1.0.0



 */







public function add_action_links( $links ) {



    /*



    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)



    */



   $settings_link = array(



    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',



   );



   return array_merge(  $settings_link, $links );







}







/**



 * Render the settings page for this plugin.



 *



 * @since    1.0.0



 */







public function display_plugin_setup_page() {



    include_once( 'partials/horse-exchange-admin-display.php' );



}















/**



*



* admin/class-wp-cbf-admin.php



*



**/



 public function options_update() {



    register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));



 }















/**



*



* admin/class-wp-cbf-admin.php



*



**/



public function validate($input) {



    // All checkboxes inputs        



    $valid = array();





// options
    $valid['license_status'] = ($input['license_status']) ;
    $valid['license_key'] = ($input['license_key']) ;
    $valid['api_key'] = ($input['api_key']) ;
    $valid['live_odds'] = (isset($input['live_odds']) && !empty($input['live_odds'])) ? 1 : 0;

    $valid['matchbook_affiliate_id'] = ($input['matchbook_affiliate_id']) ;
    $valid['show_matchbook'] = (isset($input['show_matchbook']) && !empty($input['show_matchbook'])) ? 1 : 0;
    $valid['matchbook_feed_url'] = ($input['matchbook_feed_url']) ;
    $valid['matchbook_special_offers'] = (isset($input['matchbook_special_offers']) && !empty($input['matchbook_special_offers'])) ? 1 : 0;
    $valid['matchbook_welcome_bonus'] = ($input['matchbook_welcome_bonus']) ;
    $valid['matchbook_bog'] = (isset($input['matchbook_bog']) && !empty($input['matchbook_bog'])) ? 1 : 0;

    $valid['unibet_affiliate_id'] = ($input['unibet_affiliate_id']) ;
    $valid['show_unibet'] = (isset($input['show_unibet']) && !empty($input['show_unibet'])) ? 1 : 0;
    $valid['unibet_app_key'] = ($input['unibet_app_key']) ;
    $valid['unibet_app_id'] = ($input['unibet_app_id']) ;
    $valid['unibet_special_offers'] = (isset($input['unibet_special_offers']) && !empty($input['unibet_special_offers'])) ? 1 : 0;
    $valid['unibet_welcome_bonus'] = ($input['unibet_welcome_bonus']) ;
    $valid['unibet_bog'] = (isset($input['unibet_bog']) && !empty($input['unibet_bog'])) ? 1 : 0;

    $valid['williamhill_affiliate_id'] = ($input['williamhill_affiliate_id']) ;
    $valid['williamhill_feed_url'] = ($input['williamhill_feed_url']) ;
    $valid['show_williamhill'] = (isset($input['show_williamhill']) && !empty($input['show_williamhill'])) ? 1 : 0;
    $valid['williamhill_special_offers'] = (isset($input['williamhill_special_offers']) && !empty($input['williamhill_special_offers'])) ? 1 : 0;
    $valid['williamhill_welcome_bonus'] = ($input['williamhill_welcome_bonus']) ;
    $valid['williamhill_bog'] = (isset($input['williamhill_bog']) && !empty($input['williamhill_bog'])) ? 1 : 0;

    $valid['betfred_affiliate_id'] = ($input['betfred_affiliate_id']) ;
    $valid['betfred_feed_url'] = ($input['betfred_feed_url']) ;
    $valid['show_betfred'] = (isset($input['show_betfred']) && !empty($input['show_betfred'])) ? 1 : 0;
    $valid['betfred_special_offers'] = (isset($input['betfred_special_offers']) && !empty($input['betfred_special_offers'])) ? 1 : 0;
    $valid['betfred_welcome_bonus'] = ($input['betfred_welcome_bonus']) ;
    $valid['betfred_bog'] = (isset($input['betfred_bog']) && !empty($input['betfred_bog'])) ? 1 : 0;

    $valid['betfair_show'] = (isset($input['betfair_show']) && !empty($input['betfair_show'])) ? 1 : 0;
    $valid['betfair_special_offers'] = (isset($input['betfair_special_offers']) && !empty($input['betfair_special_offers'])) ? 1 : 0;
    $valid['betfair_welcome_bonus'] = ($input['betfair_welcome_bonus']) ;
    $valid['betfair_bog'] = (isset($input['betfair_bog']) && !empty($input['betfair_bog'])) ? 1 : 0;
    $valid['betfair_username'] = ($input['betfair_username']) ;
    $valid['betfair_password'] = ($input['betfair_password']) ;
    $valid['betfair_affiliate_id'] = ($input['betfair_affiliate_id']) ;

    $valid['smarkets_show'] = (isset($input['smarkets_show']) && !empty($input['smarkets_show'])) ? 1 : 0;
    $valid['smarkets_affiliate_id'] = ($input['smarkets_affiliate_id']) ;
    $valid['smarkets_feed_url'] = ($input['smarkets_feed_url']) ;
    $valid['smarkets_special_offers'] = (isset($input['smarkets_special_offers']) && !empty($input['smarkets_special_offers'])) ? 1 : 0;
    $valid['smarkets_welcome_bonus'] = ($input['smarkets_welcome_bonus']) ;
    $valid['smarkets_bog'] = (isset($input['smarkets_bog']) && !empty($input['smarkets_bog'])) ? 1 : 0;

    $valid['show_leovegas'] = (isset($input['show_leovegas']) && !empty($input['show_leovegas'])) ? 1 : 0;
    $valid['leovegas_affiliate_id'] = ($input['leovegas_affiliate_id']) ;
    $valid['leovegas_special_offers'] = (isset($input['leovegas_special_offers']) && !empty($input['leovegas_special_offers'])) ? 1 : 0;
    $valid['leovegas_welcome_bonus'] = ($input['leovegas_welcome_bonus']) ;
    $valid['leovegas_bog'] = (isset($input['leovegas_bog']) && !empty($input['leovegas_bog'])) ? 1 : 0;













        return $valid;



















 }







}







