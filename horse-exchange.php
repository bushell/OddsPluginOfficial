<?php



/**

 * The plugin bootstrap file

 *

 * This file is read by WordPress to generate the plugin information in the plugin

 * admin area. This file also includes all of the dependencies used by the plugin,

 * registers the activation and deactivation functions, and defines a function

 * that starts the plugin.

 *

 * @link              Gambling Ninja

 * @since             1.0.0

 * @package           Horse_Exchange

 *

 * @wordpress-plugin

 * Plugin Name:       Horse Exchange Odds

 * Plugin URI:        https://gamblingninja.com

 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.

 * Version:           1.0.0

 * Author:            Gambling Ninja

 * Author URI:        Gambling Ninja

 * License:           GPL-2.0+

 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt

 * Text Domain:       horse-exchange

 * Domain Path:       /languages

 */



// If this file is called directly, abort.

if ( ! defined( 'WPINC' ) ) {

    die;

}



/**

 * Currently plugin version.

 * Start at version 1.0.0 and use SemVer - https://semver.org

 * Rename this for your plugin and update it as you release new versions.

 */

define( 'PLUGIN_NAME_VERSION', '1.0.0' );



/**

 * The code that runs during plugin activation.

 * This action is documented in includes/class-horse-exchange-activator.php

 */

function activate_horse_exchange() {

    require_once plugin_dir_path( __FILE__ ) . 'includes/class-horse-exchange-activator.php';

    Horse_Exchange_Activator::activate();

}



/**

 * The code that runs during plugin deactivation.

 * This action is documented in includes/class-horse-exchange-deactivator.php

 */

function deactivate_horse_exchange() {

    require_once plugin_dir_path( __FILE__ ) . 'includes/class-horse-exchange-deactivator.php';

    Horse_Exchange_Deactivator::deactivate();

}



register_activation_hook( __FILE__, 'activate_horse_exchange' );

register_deactivation_hook( __FILE__, 'deactivate_horse_exchange' );



/**

 * The core plugin class that is used to define internationalization,

 * admin-specific hooks, and public-facing site hooks.

 */

require plugin_dir_path( __FILE__ ) . 'includes/class-horse-exchange.php';



/**

 * Begins execution of the plugin.

 *

 * Since everything within the plugin is registered via hooks,

 * then kicking off the plugin from this point in the file does

 * not affect the page life cycle.

 *

 * @since    1.0.0

 */

function run_horse_exchange() {



    $plugin = new Horse_Exchange();

    $plugin->run();

    //football api
    include 'app/football/lib/FootballData.php';

                



}
function display_match($atts) {

if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  //Handle the case where there is no parameter
}

$api = new FootballData();
$match = $api->findMatchById($id);

$dateFormatted = date("D d M y g:i A", strtotime($match->match->utcDate));

                echo '<h1>'.$match->match->homeTeam->name . ' ('. $match->match->score->fullTime->homeTeam . ') '. ' v  (' .  $match->match->score->fullTime->awayTeam . ') '. $match->match->awayTeam->name .'</h1>';

                echo '<h5>Half-Time</h5>';
                echo '<span>'.$match->match->homeTeam->name . ' ('. $match->match->score->halfTime->homeTeam . ') '. ' v  (' .  $match->match->score->halfTime->awayTeam . ') '. $match->match->awayTeam->name .'</span>';
                
                echo '<hr>';
                echo $match->match->competition->name;
                echo '<br>';
                echo 'Venue: '.$match->match->venue;
                echo '<br>';
                echo 'Matchday: '.$match->match->matchday;
                echo '<br>';
                echo 'Date: '.$dateFormatted;

                            echo "<h3>Head to Head</h3>";
            echo "Played: ". $match->head2head->numberOfMatches;
            echo "<br>";
             
            echo $match->match->homeTeam->name . ' ' . $match->head2head->homeTeam->wins; 
            echo "<br>";
            echo 'Draws: '. $match->head2head->homeTeam->draws;  
            echo "<br>";
            echo $match->match->awayTeam->name . ' ' . $match->head2head->homeTeam->losses; 

            echo "<hr>";
         

           

            echo "Status: ". $match->match->status ; 



            //odds




}
add_shortcode( 'match', 'display_match' );
function display_team_profile($atts) {

if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  //Handle the case where there is no parameter
}
	; // prem league comp id
	$api = new FootballData();
	$competition_id = '2021';
	$now = new DateTime();
	$end = new DateTime(); $end->add(new DateInterval('P7D'));
	$response = $api->findMatchesForDateRange($now->format('Y-m-d'), $end->format('Y-m-d'), $competition_id);
	$team = $api->findTeamById($id);

	// team profile:

	 echo "<h1>".$team->name."</h1>";
	 echo '<img src="'.$team->crestUrl.'" height="150px" width="150px"/><br>';
 	 echo '<span>Venue: '.$team->venue .' </span><br>';
	 echo '<span>Founded: '. $team->founded .'</span><br>';
	 echo '<span>Website:'.$team->website .'</span><br>';
	 echo '<span>Club Colours: '.$team->clubColors .' </span>';

	 //next 5 games:

	                 echo "<p><hr><p>";
                $matches = $api->findUpcomingMatchesByTeam($id, 5);
    
                echo "<h3>Next 5 games for ". $team->name.":</h3>";
                echo '<table class="table table-striped">';
                    echo "<tr>";
                    	echo "<th>View</th>";
                        echo "<th>HomeTeam</th>";
                        echo "<th></th>";
                        echo "<th>AwayTeam</th>";
                        echo "<th>Date</th>";
                    echo "</tr>";
                    foreach ($matches as $match) { 
                    	$match_url = 'match/?id='.$match->id;
                    	$dateFormatted = date("D d M y g:i A", strtotime($match->utcDate));
                    echo '<tr>';  
                        
                        echo "<td><a class='btn btn-primary' href='".$match_url."'>></a></td>";                
                        echo "<td>". $match->homeTeam->name."</a></td>";
                        echo "<td>-</td>";
                        echo "<td>".$match->awayTeam->name."</td>";
                        echo "<td>".$dateFormatted."</td>";
            
                    echo "</tr>";
                    }
                 echo "</table>";


                       echo "<p><hr><p>";
                $matches = $api->findLiveMatchesByTeam($id, 1);

                // if any live games then show score
                if ($matches->id == '') {

                }
                else {
    
                echo "<h3>Live Now ". $team->name.":</h3>";
                echo '<table class="table table-striped">';
                    echo "<tr>";
                    	echo "<th>View</th>";
                        echo "<th>HomeTeam</th>";
                        echo "<th></th>";
                        echo "<th>AwayTeam</th>";
                        echo "<th>Kick Off</th>";
                    echo "</tr>";
                    foreach ($matches as $match) { 
                    	$match_url = 'match/?id='.$match->id;
                    	$dateFormatted = date("g:i A", strtotime($match->utcDate));
                    echo '<tr>';  
                        
                        echo "<td><a class='btn btn-primary' href='".$match_url."'>></a></td>";                
                        echo "<td>". $match->homeTeam->name."</a></td>";
                        echo "<td>-</td>";
                        echo "<td>".$match->awayTeam->name."</td>";
                        echo "<td>".$dateFormatted."</td>";
            
                    echo "</tr>";
                    }
                 echo "</table>";
             }

                 //away games
                 $matches = $api->findHomeMatchesByTeam($id);
                   echo'<div class="panel panel-default">';
    echo'<div class="panel-heading">';
      echo'<h4 class="panel-title">';
        echo'<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">';
        echo'All home matches of '. $team->name .'</a>';
      echo'</h4>';
    echo'</div>';
    echo'<div id="collapse1" class="panel-collapse collapse">';
      echo'<div class="panel-body">';
            
                
            
                 echo'<table class="table table-striped">';
                     echo'<tr>';
                     	echo '<th>View</th>';
                         echo'<th>HomeTeam</th>';
                         echo'<th></th>';
                         echo'<th>AwayTeam</th>';
                         echo'<th colspan="3">Result</th>';
                         echo '<th>Date</th>';
                     echo'</tr>';
                    foreach ($matches as $match) { 
$dateFormatted = date("D d M y g:i A", strtotime($match->utcDate));
                    echo'<tr>';
                    	$match_url = 'match/?id='.$match->id; 
                    	echo "<td><a href='".$match_url."' class='btn btn-primary' >></a></td>";                       
                        echo'<td>'.$match->homeTeam->name.'</td>';
                        echo'<td>-</td>';
                        echo'<td>'.$match->awayTeam->name.'</td>';
                        echo'<td>'. $match->score->fullTime->homeTeam.'</td>';
                        echo'<td>:</td>';
                        echo'<td>'.$match->score->fullTime->awayTeam.'</td>';
                        echo'<td>'.$dateFormatted.'</td>';
                    echo'</tr>';
                     } 
                echo'</table>';
      echo'</div>';
    echo'</div>';
 echo'</div>';

$matchesAway = $api->findAwayMatchesByTeam($id);
                   echo'<div class="panel panel-default">';
    echo'<div class="panel-heading">';
      echo'<h4 class="panel-title">';
        echo'<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">';
        echo'All away matches of '. $team->name .'</a>';
      echo'</h4>';
    echo'</div>';
    echo'<div id="collapse2" class="panel-collapse collapse">';
      echo'<div class="panel-body">';
            
                
            
                 echo'<table class="table table-striped">';
                     echo'<tr>';
                     	echo '<th>View</th>';
                         echo'<th>HomeTeam</th>';
                         echo'<th></th>';
                         echo'<th>AwayTeam</th>';
                         echo'<th colspan="3">Result</th>';
                     echo'</tr>';
                    foreach ($matchesAway as $awayMatch) { 

                    echo'<tr>';
                    	$match_url = 'match/?id='.$awayMatch->id; 
                    	echo "<td><a href='".$match_url."' class='btn btn-primary' >></a></td>";                       
                        echo'<td>'.$awayMatch->homeTeam->name.'</td>';
                        echo'<td>-</td>';
                        echo'<td>'.$awayMatch->awayTeam->name.'</td>';
                        echo'<td>'. $awayMatch->score->fullTime->homeTeam.'</td>';
                        echo'<td>:</td>';
                        echo'<td>'.$awayMatch->score->fullTime->awayTeam.'</td>';
                    echo'</tr>';
                     } 
                echo'</table>';
      echo'</div>';
    echo'</div>';
    echo'</div>';

  


        //team players:

             echo "<h3>Players of ".$team->name."</h3>";
             echo "<table class='table table-striped'>";
                 echo "<tr>";
                     echo "<th>Name</th>";
                     echo "<th>Position</th>";                    
                 echo "<th>Shirtnumber</th>";
                     echo "<th>Date of birth</th>";
                 echo "</tr>";
                foreach ($team->squad as $player) { 
                	$dateFormatted = date("d F Y", strtotime($player->dateOfBirth));
                echo "<tr>";
                    echo "<td>".$player->name."</td>";
                    echo "<td>".$player->position."</td> ";                   
                    echo "<td>".$player->shirtNumber."</td>";
                    echo "<td>".$dateFormatted."</td>";
                echo "</tr>";
                 } 
            echo "</table>";
}
add_shortcode( 'team_profile', 'display_team_profile' );

function display_full_league_standings( $atts ) {
$api = new FootballData();
$competition_id = '2021';
                echo '<h3>Current standing of the Premiere League</h3>';
                echo '<table class="table table-striped">';
                    echo '<tr>';
                    echo '<th>Position</th>';
                    echo '<th></th>';
                    echo '<th>TeamName</th>';
                    echo '<th>Played</th>';
                    echo '<th>W</th>';
                    echo '<th>D</th>';
                    echo '<th>L</th>';
                    echo '<th>GF</th>';
                    echo '<th>GA</th>';
                    echo '<th>GD</th>';
                    echo '<th>Pts</th>';
                    echo '</tr>';
                    foreach ($api->findStandingsByCompetition($competition_id)->standings as $standing) { 
                          if ($standing->type == 'TOTAL') { 
                              foreach ($standing->table as $standingRow) {
                    
                    echo '<tr>';
                      echo '<td>'.$standingRow->position.'</td>';
                      echo '<td><img src="'.$standingRow->team->crestUrl.'" class="crest" style="height:24px; width:24px"/></td>';
                      echo '<td><a href="team-profile/?id='.$standingRow->team->id.'">'.$standingRow->team->name.'</a></td>';
                      echo '<td>'.$standingRow->playedGames.'</td>';
                      echo '<td>'.$standingRow->won.'</td>';
                      echo '<td>'.$standingRow->draw.'</td>';
                      echo '<td>'.$standingRow->lost.'</td>';
                      echo '<td>'.$standingRow->goalsFor.'</td>';
                      echo '<td>'.$standingRow->goalsAgainst.'</td>';
                      echo '<td>'.$standingRow->goalDifference.'</td>';
                      echo '<td>'.$standingRow->points.'</td>';
                    echo '</tr>';
                     }}} 
                    echo '<tr>';
                    echo '</tr>';
                echo '</table>';
}
add_shortcode( 'full_league_standings', 'display_full_league_standings' );

function display_games_over_7days( $atts ) {
$api = new FootballData();
$competition_id = '2021';

            echo "<p><hr><p>";
            // fetch all available upcoming matches for the next 3 days
            $now = new DateTime();
            $end = new DateTime(); $end->add(new DateInterval('P7D'));
            $response = $api->findMatchesForDateRange($now->format('Y-m-d'), $end->format('Y-m-d'), $competition_id);
            
            echo '<h3>Upcoming matches within the next 7 days</h3>';
                echo '<table class="table table-striped">';
                    echo '<tr>';
                    	echo '<th></th>';
                        echo '<th>HomeTeam</th>';
                        echo '<th></th>';
                        echo '<th>AwayTeam</th>';
                        echo '<th colspan="3">Date</th>';
                    echo '</tr>';
                    foreach ($response->matches as $match) 
                    { 
                    $match_url = 'match/?id='.$match->id;
                    echo '<tr>';  
                        
                        echo "<td><a class='btn btn-primary' href='".$match_url."'>></a></td>";         
                        echo '<td>'.$match->homeTeam->name .'</td>';
                        echo '<td>v</td>';
                        echo '<td>'.$match->awayTeam->name.'</td>';
                        echo '<td>'.$dateFormatted = date("D d M y g:i A", strtotime($match->utcDate)).'</td>';

                    echo '</tr>';
                    }
                echo '</table>';
}
add_shortcode( 'next_7_days_football_games', 'display_games_over_7days' );


function display_none_runners( $atts ) {

    global $wpdb;

    $table_name = $wpdb->prefix . "horses";

    $user = $wpdb->get_results( "SELECT * FROM $table_name WHERE STATUS = 'REMOVED' ORDER BY id DESC LIMIT 10" );





    echo "<h4>None Runners</h4>";

    echo "<div class='divTable'>";
        echo "<div class='divTableBody' style='overflow-y: scroll; height:400px;'>";

    foreach ($user as $row) 
    { 

        $time_corrected = date("Y-m-d H:i:s", strtotime($row->event_time));
                   
                   
        // onl display none runners for today and ahead (preventing from showing none runners from previous dates)
        echo "<div class='divTableRow'>";
                               echo "<div class='nr_button' style='float: right; background: #f4f4f4; padding: 10px; color:; margin-right: 20px; margin-top: 15px;'><a href='race/?market_id=".$row->market_id."'>VIEW</a></div>";

            echo "<div class='divTableCell'><img src = 'https://content-cache.cdnbf.net/feeds_images/Horses/SilkColours/$row->cloth'/>$row->cloth_number. $row->horse <br>$time_corrected<br>"; 
            
            if ($row->country == 'GB'){
                echo "<img src='".plugin_dir_url( __FILE__ )."/app/images/GB.png' />";
            }
            else if ($row->country == 'IE'){
                echo "<img src='".plugin_dir_url( __FILE__ )."/app/images/IE.png' />";
            }
            echo $row->event_name ." - ". $row->venue ."<hr>"; 


            echo "</div>";
            
        echo "</div>";





    }
            echo "</div>";
        echo "</div>";
}

add_shortcode( 'horse-nr', 'display_none_runners' );


function display_horse_winners( $atts ) {

    global $wpdb;

    $table_name = $wpdb->prefix . "horses";

    $user = $wpdb->get_results( "SELECT * FROM $table_name WHERE STATUS = 'WINNER' ORDER BY id DESC LIMIT 10 " );





    echo "<h4>Latest Winners</h4>";

    echo "<div class='divTable'>";
    echo "<div class='divTableBody' style='overflow-y: scroll; height:400px;'>";

    foreach ($user as $row){ 

        $time_corrected = date("Y-m-d H:i:s", strtotime($row->event_time));
               
               
                   // onl display none runners for today and ahead (preventing from showing none runners from previous dates)
                    echo "<div class='divTableRow'>";
                        echo "<div class='divTableCell'><img src = 'https://content-cache.cdnbf.net/feeds_images/Horses/SilkColours/$row->cloth'/>$row->cloth_number. $row->horse <br>$time_corrected<br>";

                         if ($row->country == 'GB'){
                            echo "<img src='".plugin_dir_url( __FILE__ )."/app/images/GB.png' />";
                        }
                        else if ($row->country == 'IE'){
                            echo "<img src='".plugin_dir_url( __FILE__ )."/app/images/IE.png' />";
                        }
                    echo $row->event_name ." - ". $row->venue ."<hr></div>";

                    echo "</div>";
                }

                echo "</div>";
            echo "</div>";


    }

add_shortcode( 'horse-winners', 'display_horse_winners' );


function display_next_race(  ) {

  
	include ('app/win_nr/get_next_race.php');

  
}

add_shortcode( 'next_race', 'display_next_race' );


function display_next_race_detailed(  ) {

  
	include ('app/win_nr/get_next_race_detailed.php');

  
}

//////////////////

add_shortcode( 'next_race_detailed', 'display_next_race_detailed' );


/////////////////////////////////////////////////////

function display_upcomming_races(  ) {

  
	include ('app/win_nr/upcomming_races.php');

  
}

add_shortcode( 'upcomming_races', 'display_upcomming_races' );


// Add Shortcode
function display_odds( $atts ) {



 add_action('wp_enqueue_scripts', 'qg_enqueue');

    wp_enqueue_script(
        'events',
        plugin_dir_url(__FILE__).'js/events.min.js'
    );

      wp_enqueue_script(
        'mutate',
        plugin_dir_url(__FILE__).'js/mutate.min.js'
    );

     wp_enqueue_script(
        'iframe',
        plugin_dir_url(__FILE__).'js/iframe.js'
    );


            



            $app_url = plugin_dir_url( __FILE__ ) . 'app/index.php';

            $app_iframe .= "<iframe id='iframe' src='$app_url' frameborder='0' scrolling='no' ></iframe>";
            return $app_iframe;
            




            //$( "#appframe" ).parent().width();
           
//echo 'test';
}

add_shortcode( 'odds', 'display_odds' );





function display_individual_odds($market_id) {

extract(shortcode_atts(array(
        'market_id' => 'market_id'
    ), $market_id));

       
            $app_url = plugin_dir_url( __FILE__ ) . '/app/#/market?marketID='. $market_id;


            $js = "<script> jQuery(document).ready(function($){ var iframe_width1 = $( '#appframe1' ).parent().width(); console.log('width: '+ iframe_width); $( '#appframe1' ).css('width', iframe_width1); }); </script>";
            echo $js;

            
            echo  "<script>";
                            echo  "function iframeLoaded1() {";
                                    echo  "var iFrameID1 = document.getElementById('appframe1');";
                                    echo  "if(iFrameID1) {";
                                //echo  " // here you can make the height, I delete it first, then I make it again";
                                         echo  "iFrameID1.height = '';";
                                         echo  "iFrameID1.height = iFrameID1.contentWindow.document.body.scrollHeight + 'px';";
                                    echo  "}";   
                                    echo "setTimeout(iframeLoaded1, 100);";
                            echo  "}";

             echo  "</script>";


            $app_iframe .= "<iframe src='$app_url' frameborder='0' scrolling='no' id='appframe1' onload='iframeLoaded1()'></iframe>";
            return $app_iframe;






            //$( "#appframe" ).parent().width();
           
//echo 'test';
}

add_shortcode( 'individual_odds', 'display_individual_odds' );







function display_individual_odds_var() {

if (isset($_GET['market_id'])) {
  $market_id = $_GET['market_id'];
} else {
  //Handle the case where there is no parameter
}

       
            $app_url = plugin_dir_url( __FILE__ ) . '/app/#/market?marketID='. $market_id;


            $js = "<script> jQuery(document).ready(function($){ var iframe_width1 = $( '#appframe1' ).parent().width(); console.log('width: '+ iframe_width); $( '#appframe1' ).css('width', iframe_width1); }); </script>";
            echo $js;

            
            echo  "<script>";
                            echo  "function iframeLoaded1() {";
                                    echo  "var iFrameID1 = document.getElementById('appframe1');";
                                    echo  "if(iFrameID1) {";
                                //echo  " // here you can make the height, I delete it first, then I make it again";
                                         echo  "iFrameID1.height = '';";
                                         echo  "iFrameID1.height = iFrameID1.contentWindow.document.body.scrollHeight + 'px';";
                                    echo  "}";   
                                    echo "setTimeout(iframeLoaded1, 100);";
                            echo  "}";

             echo  "</script>";


            $app_iframe .= "<iframe src='$app_url' frameborder='0' scrolling='no' id='appframe1' onload='iframeLoaded1()'></iframe>";
            return $app_iframe;






            //$( "#appframe" ).parent().width();
           
//echo 'test';
}

add_shortcode( 'horse_url_var', 'display_individual_odds_var' );

/*

 function horse_odds_shortcode() {

    $options = get_option($this->plugin_name);



    // Cleanup

    $betfair_show = $options['betfair_show'];

    $betfair_username = $options['betfair_username'];

    $betfair_password = $options['betfair_password'];

    $betfair_affiliate_id = $options['betfair_affiliate_id'];

    $smarkets_show = $options['smarkets_show'];

    $smarkets_affiliate_id = $options['smarkets_affiliate_id'];



    return $smarkets_affiliate_id;

}



add_shortcode('horse_odds', 'horse_odds_shortcode');



*/

run_horse_exchange();

?>