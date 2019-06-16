<?php



/**

 * Fired during plugin activation

 *

 * @link       Gambling Ninja

 * @since      1.0.0

 *

 * @package    Horse_Exchange

 * @subpackage Horse_Exchange/includes

 */



/**

 * Fired during plugin activation.

 *

 * This class defines all code necessary to run during the plugin's activation.

 *

 * @since      1.0.0

 * @package    Horse_Exchange

 * @subpackage Horse_Exchange/includes

 * @author     Gambling Ninja <support@gamblingninja.com>

 */

 //register_activation_hook( __FILE__, 'create_plugin_database_table' );
  // register_activation_hook( __FILE__,array( 'Horse_Exchange_Activator', 'activate' )  );



register_activation_hook( __FILE__,array( 'Horse_Exchange_Activator', 'activate' )  );
class Horse_Exchange_Activator {
    public static function activate() {
global $wpdb;
        global $jal_db_version;
        $table_name1 = $wpdb->prefix . 'horses';

        $charset_collate = $wpdb->get_charset_collate();



        $sql = "CREATE TABLE $table_name1 (
                    id INT NOT NULL AUTO_INCREMENT,
                    horse varchar(255) NOT NULL,
                    event_name varchar(255) NOT NULL,
                    market_name varchar(255) NOT NULL,
                    market_id varchar(50) NOT NULL,
                    event_time varchar(255) NOT NULL,
                    selection_id varchar(255) NOT NULL,
                    cloth varchar(255) NOT NULL,
                    cloth_number varchar(2) NOT NULL,
                    venue varchar(255) NOT NULL,
                    country varchar(255) NOT NULL, 
                    status varchar(255) NOT NULL,
                    PRIMARY KEY (id) )";


  function add_my_custom_page() {
    // Create post object
    $my_post = array(
      'post_title'    => wp_strip_all_tags( 'Race' ),
      'post_content'  => '[horse_url_var]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
    );

    // Insert the post into the database
    wp_insert_post( $my_post );
}

register_activation_hook(__FILE__, 'add_my_custom_page');


        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    
    }

}


/*
class Horse_Exchange_Activator {



    /**

     * Short Description. (use period)

     *

     * Long Description.

     *

     * @since    1.0.0

     */


/*

    public static function activate() {


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


}

dbDelta($sql);
        


    }
}


}

*/