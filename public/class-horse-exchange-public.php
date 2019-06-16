<?php







/**



 * The public-facing functionality of the plugin.



 *



 * @link       Gambling Ninja



 * @since      1.0.0



 *



 * @package    Horse_Exchange



 * @subpackage Horse_Exchange/public



 */







/**



 * The public-facing functionality of the plugin.



 *



 * Defines the plugin name, version, and two examples hooks for how to



 * enqueue the public-facing stylesheet and JavaScript.



 *



 * @package    Horse_Exchange



 * @subpackage Horse_Exchange/public



 * @author     Gambling Ninja <support@gamblingninja.com>



 */



class Horse_Exchange_Public {





    public function __construct( $plugin_name, $version ) {



        $this->plugin_name = $plugin_name;

        $this->version = $version;

        $this->horse_exchange_options = get_option($this->plugin_name);

        $options = get_option($this->plugin_name);

    }




    /**

     * Cleanup functions depending on each checkbox returned value in admin

     *

     * @since    1.0.0

     */

    // Cleanup head

    public function wp_cbf_cleanup() {



       





    }   

 





}

