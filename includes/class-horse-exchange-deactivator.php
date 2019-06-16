<?php



/**

 * Fired during plugin deactivation

 *

 * @link       Gambling Ninja

 * @since      1.0.0

 *

 * @package    Horse_Exchange

 * @subpackage Horse_Exchange/includes

 */



/**

 * Fired during plugin deactivation.

 *

 * This class defines all code necessary to run during the plugin's deactivation.

 *

 * @since      1.0.0

 * @package    Horse_Exchange

 * @subpackage Horse_Exchange/includes

 * @author     Gambling Ninja <support@gamblingninja.com>

 */

class Horse_Exchange_Deactivator {



	/**

	 * Short Description. (use period)

	 *

	 * Long Description.

	 *

	 * @since    1.0.0

	 */



	function create_plugin_database_table()

{

    global $table_prefix, $wpdb;



    $tblname = 'winners_horses';

    $wp_track_table = $table_prefix . "$tblname ";



    #Check to see if the table exists already, if not, then create it



    if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) 

    {



        $sql = "CREATE TABLE `". $wp_track_table . "` ( ";

        $sql .= "  `id`  int(11)   NOT NULL auto_increment, ";

        $sql .= "  `horse`  varchar(255)   NOT NULL, ";

        $sql .= "  `event_name` varchar(255)   NOT NULL, "; 

        $sql .= "  `cloth` varchar(255)   NOT NULL, "; 

        $sql .= "  `posted` varchar(255)   NOT NULL, "; 

        $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 ; ";

        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

        dbDelta($sql);

    }

}



 register_activation_hook( __FILE__, 'create_plugin_database_table' );



	public static function deactivate() {



	}



}

