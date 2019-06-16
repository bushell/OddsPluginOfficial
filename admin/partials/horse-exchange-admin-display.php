<?php
$version = '1.0 Beta';


/**

 * Provide a admin area view for the plugin

 *

 * This file is used to markup the admin-facing aspects of the plugin.

 *

 * @link       Gambling Ninja

 * @since      1.0.0

 *

 * @package    Horse_Exchange

 * @subpackage Horse_Exchange/admin/partials

 */

?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">


<link href="https://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.cronjobs{
    background-color: #e0dfdf;
    padding: 7px;
    border-radius: 5px;
    color: #ff930d;
    font-weight: bold;
    font-size: 12px;
    display: inline-block;
    margin-bottom: 5px;
}
.tab-content>.active {
    display: block;
    background-color: #f1f1f1;
    padding: 10px;
    margin-top: -7px;
    border: 1px solid #cccccc;
}
.nav-tab {
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}


#matchbook {
    background-color: #e81e24;
    border: 1px solid #a3191d;
}

#matchbook span {
    color: #ffffff;
}


#williamhill {
    background-color: #00143c;
    border: 1px solid #010919;
}

#williamhill span {
    color: #ffffff;
}

#williamhill input[type=text] {
    background-color: #042669;
    border: 1px solid #073898;
    color: #fefe03;
    border-radius: 5px;
}

#betfred {
    background-color: #0b478c;
    border: 1px solid #052344;
}

#betfred span {
    color: #ffffff;
}


#smarkets {
    background-color: #000000;
    border: 1px solid #0cd196;
}

#smarkets span {
    color: #ffffff;
}


#betfair {
    background-color: #fe9b01;
    border: 1px solid #feb500;
}

#unibet {
    background-color: #38a933;
    border: 1px solid #266824;
}

#leovegas {
    background-color: #fb6740;
    border: 1px solid #8d3b25;
}


#betfair span {
    color: #000000;
}

#betfair .card{
    background-color: #a86d11;
    color: #121212;
}

#betfair_tab{
    background-color: #fe9b01;
    border: 1px solid #feb500;
}

#betfair_tab a{
    color: #000000;
}

#smarkets_tab{
    background-color: #000000;
    border: 1px solid #0cd196;
    
}

#smarkets_tab a{
    color: #ffffff;
}

#matchbook_tab a{
    color: #ffffff;
}

#williamhill_tab a{
    color: #ffffff;
}

#betfred_tab a{
    color: #ffffff;
}

#unibet_tab a{
    color: #ffffff;
}

#leovegas_tab a{
    color: #ffffff;
}

#matchbook_tab{

    background-color: #e81e24;
    border: 1px solid #a3191d;
}

#williamhill_tab{
    background-color: #00143c;
    border: 1px solid #010919;
    
}

#betfred_tab{
    background-color: #0b478c;
    border: 1px solid #052344;
    
}

#unibet_tab{
    background-color: #38a933;
    border: 1px solid #266824;
    
}

#leovegas_tab{
    background-color: #fb6740;
    border: 1px solid #8d3b25;

    
}
</style>

<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->



<div class="wrap">



    <h2>WP - Betting Odds Plugin</h2>



    <form method="post" name="horse_exchange_options" action="options.php">





     <?php

        //Grab all options

        $options = get_option($this->plugin_name);

        if ($options != NULL) {

            // Cleanup
            $license_key = $options['license_key'];

            $license_status = $options['license_status'];

            $api_key = $options['api_key'];

            $live_odds = $options['live_odds'];

            $betfair_show = $options['betfair_show'];

            $betfair_username = $options['betfair_username'];

            $betfair_password = $options['betfair_password'];

            $betfair_affiliate_id = $options['betfair_affiliate_id'];

            $betfair_welcome_bonus = $options['betfair_welcome_bonus'];

            $betfair_special_offers = $options['betfair_special_offers'];

            $betfair_bog = $options['betfair_bog'];

            $smarkets_show = $options['smarkets_show'];

            $smarkets_affiliate_id = $options['smarkets_affiliate_id'];

            $smarkets_feed_url = $options['smarkets_feed_url'];

            $smarkets_welcome_bonus = $options['smarkets_welcome_bonus'];

            $smarkets_special_offers = $options['smarkets_special_offers'];

            $smarkets_bog = $options['smarkets_bog'];

            $show_matchbook = $options['show_matchbook'];

            $matchbook_feed_url = $options['matchbook_feed_url'];

            $matchbook_affiliate_id = $options['matchbook_affiliate_id'];

            $matchbook_welcome_bonus = $options['matchbook_welcome_bonus'];

            $matchbook_special_offers = $options['matchbook_special_offers'];

            $matchbook_bog = $options['matchbook_bog'];

            $show_unibet = $options['show_unibet'];

            $unibet_affiliate_id = $options['unibet_affiliate_id'];

            $unibet_welcome_bonus = $options['unibet_welcome_bonus'];

            $unibet_special_offers = $options['unibet_special_offers'];

            $unibet_bog = $options['unibet_bog'];

            $show_leovegas = $options['show_leovegas'];

            $leovegas_affiliate_id = $options['leovegas_affiliate_id'];

            $leovegas_welcome_bonus = $options['leovegas_welcome_bonus'];

            $leovegas_special_offers = $options['leovegas_special_offers'];

            $leovegas_bog = $options['leovegas_bog'];

            $unibet_app_key = $options['unibet_app_key'];

            $unibet_app_id = $options['unibet_app_id'];

            $show_betfred = $options['show_betfred'];

            $betfred_affiliate_id = $options['betfred_affiliate_id'];

            $betfred_feed_url = $options['betfred_feed_url'];

            $betfred_welcome_bonus = $options['betfred_welcome_bonus'];

            $betfred_special_offers = $options['betfred_special_offers'];

            $betfred_bog = $options['betfred_bog'];

            $show_williamhill = $options['show_williamhill'];

            $williamhill_affiliate_id = $options['williamhill_affiliate_id'];

            $williamhill_feed_url = $options['williamhill_feed_url'];

            $williamhill_welcome_bonus = $options['williamhill_welcome_bonus'];

            $williamhill_special_offers = $options['williamhill_special_offers'];

            $williamhill_bog = $options['williamhill_bog'];





}

    ?>



    <?php

        settings_fields($this->plugin_name);

        do_settings_sections($this->plugin_name);

    ?>

    <!-- This file should primarily consist of HTML with a little bit of PHP. -->






<!-- Login page customizations -->





<ul class="nav nav-tabs">

   

               

              <li class='nav-tab socialsettings-tab'><a data-toggle='tab' href='#options'>Options</a></li>

              <li class='nav-tab globalsettings-tab'><a data-toggle='tab' href='#news'>News</a></li>

              <li class='nav-tab socialsettings-tab' id='betfair_tab'><a data-toggle='tab' href='#betfair'><img src='../wp-content/plugins/". $this->plugin_name. "/app/images/betfair_icon32.png' />Betfair</a></li>

              <li class='nav-tab globalsettings-tab' id='smarkets_tab'><a data-toggle='tab' href='#smarkets'><img src='../wp-content/plugins/". $this->plugin_name. "/app/images/smarkets_icon32.png' />Smarkets</a></li>

              <li class='nav-tab globalsettings-tab' id='matchbook_tab'><a data-toggle='tab' href='#matchbook'><img src='../wp-content/plugins/". $this->plugin_name. "/app/images/matchbook_icon32.png' />Matchbook</a></li>

              <li class='nav-tab globalsettings-tab' id='williamhill_tab'><a data-toggle='tab' href='#williamhill'><img src='../wp-content/plugins/". $this->plugin_name. "/app/images/williamhill_icon32.png' />William Hill</a></li>

              <li class='nav-tab globalsettings-tab' id='betfred_tab'><a data-toggle='tab' href='#betfred'><img src='../wp-content/plugins/". $this->plugin_name. "/app/images/betfred_icon32.png' />Bredfred</a></li>

              <li class='nav-tab globalsettings-tab' id='unibet_tab'><a data-toggle='tab' href='#unibet'><img src='../wp-content/plugins/". $this->plugin_name. "/app/images/unibet_icon32.png' />Unibet</a></li>

              <li class='nav-tab globalsettings-tab' id='leovegas_tab'><a data-toggle='tab' href='#leovegas'><img src='../wp-content/plugins/". $this->plugin_name. "/app/images/leovegas_icon32.png' />LeoVegas</a></li>


  

</ul>








<div class="tab-content">


<!-- news -->

  <div id="news" class="tab-pane">


    <iframe src="https://bushell.net/odds-plugin-files/news.php" width="100%" height="500px" frameBorder="0">Browser not compatible.</iframe>


  </div>


<!-- options tab -->


 <div id="options" class="tab-pane fade in active show">

    <h3>Options</h3>

    <span>Please read through these options carefully, and make sure any cron jobs are setup before running this plugin on a live website.</span><br>

    <?php
    function generateRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

 <!-- Display live odds, refreshes every 30 seconds -->
<br>
<h5>Live Odds</h5>
<span>This will refresh the odds every 30 seconds if enabled. Enabling this could be resource heavy on some shared hosting accounts, please monitor this so it does not affect your servers performance. If this is disabled, the odds will be retrieved once on page load.</span><br><br>
        <fieldset>


            <legend class="screen-reader-text"><span><?php _e('Show Live Odds', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-live_odds">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-live_odds" name="<?php echo $this->plugin_name; ?>[live_odds]" value="1" <?php checked($live_odds, 1); ?> />

                <span><?php esc_attr_e('Show Live Odds', $this->plugin_name); ?></span>

            </label>

        </fieldset>
<hr>
<h5>API</h5>
        <fieldset>

            <legend class="screen-reader-text"><span>API Key:</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-api_key">

                


                <?php 
                    if ($api_key == NULL){

                ?>
                                    API Key: <input type="text" id="<?php echo $this->plugin_name; ?>-api_key" name="<?php echo $this->plugin_name; ?>[api_key]" value="<?php echo generateRandomString(); ?>" />


                <?php
                    }
                    else {
                       ?>
                       API Key: <input type="text" id="<?php echo $this->plugin_name; ?>-api_key" name="<?php echo $this->plugin_name; ?>[api_key]" value="<?php echo $api_key; ?>" />
                   <?php    
                    }
                 ?>

            </label>
            <br>
            <span>The API key is to make your cron jobs more secure, so no one can access your pages without your API key.</span>

        </fieldset>

<hr>

<h5>Cron Jobs</h5>

<span>The following cron jobs need to be setup in order for the plugin to work correctly. These are the recommended cronjob settings, feel free to adjust these to your needs</span>

<span class="cronjobs">0  0,12  *   *   *   wget -q <?php echo plugin_dir_url( __PATH__ ).$this->plugin_name. '/app/win_nr/get_daily_runners.php > /dev/null 2>&1'; ?></span>
<span class="cronjobs">*/20 *   *   *   *   wget -q <?php echo plugin_dir_url( __PATH__ ).$this->plugin_name. '/app/win_nr/get_horse_status.php > /dev/null 2>&1';?></span>
<span class="cronjobs">*/10 *   *   *   *   wget -q <?php echo plugin_dir_url( __PATH__ ).$this->plugin_name. '/app/feeds/smarkets_downloader.php?key='.$api_key.' > /dev/null 2>&1';?></span>

<hr>

<h5>Shortcodes</h5>

<span>These are the following shortcodes that can be used within your site, including the widget or page/post areas.</span>
<br><br>
<span>The following are <strong>required</strong> shortcodes:</span>
<br><br>
<span>The main odds plugin shortcode, used to display the plugin.</span><br>
<span class="cronjobs">[odds]</span>
<br>
<span>The following shortcode must be placed on a page called <strong>race</strong>, and is used to display individual races.</span><br>
<span class="cronjobs">[horse_url_var]</span>
<br><br>

<span>The following are optional shortcodes:</span>
<br><br>

<span>Individual odds market, based on a betfair exchange market ID (replace <strong>1.149257838</strong> with your own market id.</span><br>
<span class="cronjobs">[individual_odds market_id='<u>1.149257838</u>']).</span>
<br>
<span>Display none runners.</span><br>
<span class="cronjobs">[horse-nr]</span>
<br>
<span>Display the next five races.</span><br>
<span class="cronjobs">[upcomming_races]</span>
<br>
<span>Display the next race, basic race runners.</span><br>
<span class="cronjobs">[next_race]</span>
<br>
<span>Displays the next race, with slightly more detailed information.</span><br>
<span class="cronjobs">[next_race_detailed]</span>
<br>
<span>Displays the latest winners.</span><br>
<span class="cronjobs">[horse-winners]</span>





  </div>


 

  <div id="betfair" class="tab-pane">

    <img src="../wp-content/plugins/<?php echo $this->plugin_name; ?>/app/images/betfair_logo_admin.png" />

    


<br>
<div class="alert alert-warning" role="alert">
  <i class="fas fa-exclamation-triangle"></i> You will need Betfair developer access for the whole plugin to work. You can sign up for a developer account here <strong><a href='https://developer.betfair.com/en/get-started/#exchange-api' target="_blank">https://developer.betfair.com/en/get-started/#exchange-api</a></strong>.
</div>



                <!-- Show Betfair Odds -->

        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Show Betfair Odds', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-betfair_show">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-betfair_show" name="<?php echo $this->plugin_name; ?>[betfair_show]" value="1" <?php checked($betfair_show, 1); ?> />

                <span><?php esc_attr_e('Show Betfair odds.', $this->plugin_name); ?></span>

            </label>

        </fieldset>





        <!-- Betfair Username -->

        <fieldset>

            <legend class="screen-reader-text"><span>Betfair Username*</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-betfair_username">

                <span><?php esc_attr_e('Betfair Username*', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-betfair_username" name="<?php echo $this->plugin_name; ?> [betfair_username]" value="<?php if(!empty($betfair_username)) echo $betfair_username; ?>" />

            </label>

        </fieldset>



        <!-- Betfair Password -->

        <fieldset>

            <legend class="screen-reader-text"><span>Betfair Password*</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-betfair_password">

                 <span><?php esc_attr_e('Betfair Password*', $this->plugin_name); ?></span>

                <input type="password" id="<?php echo $this->plugin_name; ?>-betfair_password" name="<?php echo $this->plugin_name; ?>[betfair_password]" value="<?php if(!empty($betfair_password)) echo $betfair_password; ?>" />

            </label>

        </fieldset>



        <!-- Betfair Affiliate ID -->

        <fieldset>

            <legend class="screen-reader-text"><span>Betfair Affiliate ID</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-betfair_affiliate_id">

                <span><?php esc_attr_e('Betfair Affiliate ID', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-betfair_affiliate_id" name="<?php echo $this->plugin_name; ?>[betfair_affiliate_id]" value="<?php if(!empty($betfair_affiliate_id)) echo $betfair_affiliate_id; ?>" />

            </label>

        </fieldset>

<hr>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Special Offers', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-betfair_special_offers">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-betfair_special_offers" name="<?php echo $this->plugin_name; ?>[betfair_special_offers]" value="1" <?php checked($betfair_special_offers, 1); ?> />

                <span><?php esc_attr_e('Special Offers', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Best Odds Guarenteed', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-betfair_bog">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-betfair_bog" name="<?php echo $this->plugin_name; ?>[betfair_bog]" value="1" <?php checked($betfair_bog, 1); ?> />

                <span><?php esc_attr_e('Best Odds Guarenteed', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span>Betfair Welcome Bonus &pound;</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-betfair_welcome_bonus">

                <span><?php esc_attr_e('Betfair Welcome Bonus &pound;', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-betfair_welcome_bonus" name="<?php echo $this->plugin_name; ?>[betfair_welcome_bonus]" value="<?php if(!empty($betfair_welcome_bonus)) echo $betfair_welcome_bonus; ?>" />

            </label>

        </fieldset>

<div class="alert alert-info" role="alert">
  <strong><i class="fas fa-exclamation-triangle"></i> Heads up!</strong> If you do <strong>not</strong> already have a Betfair affiliate account you can sign up <a href="https://bushell.net/recommends/betfair-affiliate/" target="_blank" class="alert-link">here</a>.
</div>




        


  </div>



  <div id="smarkets" class="tab-pane fade">

    <img src="../wp-content/plugins/<?php echo $this->plugin_name; ?>/app/images/smarkets_logo_admin.png" />

    

 <!-- Show Smarkets Odds -->

        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Show Smarkets Odds', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-smarkets_show">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-smarkets_show" name="<?php echo $this->plugin_name; ?>[smarkets_show]" value="1" <?php checked($smarkets_show, 1); ?> />

                <span><?php esc_attr_e('Show Smarkets', $this->plugin_name); ?></span>

            </label>

        </fieldset>



        <!-- Smarkets Affiliate ID -->

        <fieldset>

            <legend class="screen-reader-text"><span>Smarkets Affiliate ID</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-smarkets_affiliate_id">

                <span><?php esc_attr_e('Smarkets Affiliate ID', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-smarkets_affiliate_id" name="<?php echo $this->plugin_name; ?>[smarkets_affiliate_id]" value="<?php if(!empty($smarkets_affiliate_id)) echo $smarkets_affiliate_id; ?>"  />

              

            </label>


        </fieldset>



                        <fieldset>

            <legend class="screen-reader-text"><span>Smarkets Feed URL</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-smarkets_feed_url">

                <span><?php esc_attr_e('Smarkets Feed URL', $this->plugin_name); ?></span>

                <?php

                $smarkets_default_url = 'https://odds.smarkets.com/oddsfeed.xml.gz?event_type=horse_racing_race';

                if ($smarkets_feed_url == NULL) {

                    ?>

                     <input type="text" id="<?php echo $this->plugin_name; ?>-smarkets_feed_url" name="<?php echo $this->plugin_name; ?>[smarkets_feed_url]" value="<?php echo $smarkets_default_url; ?>"  />

                     <?
                     

                }
                else {

                    ?>
                          <input type="text" id="<?php echo $this->plugin_name; ?>-smarkets_feed_url" name="<?php echo $this->plugin_name; ?>[smarkets_feed_url]" value="<?php if(!empty($smarkets_feed_url)) echo $smarkets_feed_url; ?>"  />

                    <?
                }

                ?>




                <input type="submit" name="smarketsBtn" value="Default URL" onclick="smarketsOriginalURL(this); return false;"> 



            </label>

        </fieldset>


<hr>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Special Offers', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-smarkets_special_offers">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-smarkets_special_offers" name="<?php echo $this->plugin_name; ?>[smarkets_special_offers]" value="1" <?php checked($smarkets_special_offers, 1); ?> />

                <span><?php esc_attr_e('Special Offers', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Best Odds Guarenteed', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-smarkets_bog">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-smarkets_bog" name="<?php echo $this->plugin_name; ?>[smarkets_bog]" value="1" <?php checked($smarkets_bog, 1); ?> />

                <span><?php esc_attr_e('Best Odds Guarenteed', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span>smarkets Welcome Bonus &pound;</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-smarkets_welcome_bonus">

                <span><?php esc_attr_e('smarkets Welcome Bonus &pound;', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-smarkets_welcome_bonus" name="<?php echo $this->plugin_name; ?>[smarkets_welcome_bonus]" value="<?php if(!empty($smarkets_welcome_bonus)) echo $smarkets_welcome_bonus; ?>" />

            </label>

        </fieldset>

<div class="alert alert-info" role="alert">
  <strong><i class="fas fa-exclamation-triangle"></i> Heads up!</strong> If you do <strong>not</strong> already have a Smarkets affiliate account you can sign up <a href="https://bushell.net/recommends/smarkets-affiliate/" target="_blank" class="alert-link">here</a>.
</div>




  </div>





<div id="williamhill" class="tab-pane">

<img src="../wp-content/plugins/<?php echo $this->plugin_name; ?>/app/images/williamhill_logo_admin.png" />

    


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Show William Hill', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-show_williamhill">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_williamhill" name="<?php echo $this->plugin_name; ?>[show_williamhill]" value="1" <?php checked($show_williamhill, 1); ?> />

                <span><?php esc_attr_e('Show William Hill', $this->plugin_name); ?></span>

            </label>

        </fieldset>




        <fieldset>

            <legend class="screen-reader-text"><span>William Hill Affiliate ID</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-williamhill_affiliate_id">

                <span><?php esc_attr_e('William Hill Affiliate ID', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-williamhill_affiliate_id" name="<?php echo $this->plugin_name; ?>[williamhill_affiliate_id]" value="<?php if(!empty($williamhill_affiliate_id)) echo $williamhill_affiliate_id; ?>"  />

            </label>

        </fieldset>


                <fieldset>

            <legend class="screen-reader-text"><span>William Hill Feed URL</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-williamhill_feed_url">

                <span><?php esc_attr_e('William Hill Feed URL', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-williamhill_feed_url" name="<?php echo $this->plugin_name; ?>[williamhill_feed_url]" value="<?php if(!empty($williamhill_feed_url)) echo $williamhill_feed_url; ?>"  />

                <input type="submit" name="williamHillBtn" value="Default URL" onclick="williamHillOriginalURL(this); return false;"> 



            </label>

        </fieldset>


<hr>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Special Offers', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-williamhill_special_offers">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-williamhill_special_offers" name="<?php echo $this->plugin_name; ?>[williamhill_special_offers]" value="1" <?php checked($williamhill_special_offers, 1); ?> />

                <span><?php esc_attr_e('Special Offers', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Best Odds Guarenteed', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-williamhill_bog">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-williamhill_bog" name="<?php echo $this->plugin_name; ?>[williamhill_bog]" value="1" <?php checked($williamhill_bog, 1); ?> />

                <span><?php esc_attr_e('Best Odds Guarenteed', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span>William Hill Welcome Bonus &pound;</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-williamhill_welcome_bonus">

                <span><?php esc_attr_e('williamhill Welcome Bonus &pound;', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-williamhill_welcome_bonus" name="<?php echo $this->plugin_name; ?>[williamhill_welcome_bonus]" value="<?php if(!empty($williamhill_welcome_bonus)) echo $williamhill_welcome_bonus; ?>" />

            </label>

        </fieldset>


<div class="alert alert-info" role="alert">
  <strong><i class="fas fa-exclamation-triangle"></i> Heads up!</strong> If you do <strong>not</strong> already have a William Hill affiliate account you can sign up <a href="https://bushell.net/recommends/williamhill-affiliate/" target="_blank" class="alert-link">here</a>.
</div>


  </div>

<div id="betfred" class="tab-pane">
<img src="../wp-content/plugins/<?php echo $this->plugin_name; ?>/app/images/betfred_logo_admin.png" />


    


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Show Betfred', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-show_betfred">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_betfred" name="<?php echo $this->plugin_name; ?>[show_betfred]" value="1" <?php checked($show_betfred, 1); ?> />

                <span><?php esc_attr_e('Show Betfred', $this->plugin_name); ?></span>

            </label>

        </fieldset>





        <fieldset>

            <legend class="screen-reader-text"><span>Betfred Affiliate ID</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-betfred_affiliate_id">

                <span><?php esc_attr_e('Betfred Affiliate ID', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-betfred_affiliate_id" name="<?php echo $this->plugin_name; ?>[betfred_affiliate_id]" value="<?php if(!empty($betfred_affiliate_id)) echo $betfred_affiliate_id; ?>"  />

            </label>

        </fieldset>



        <fieldset>

            <legend class="screen-reader-text"><span>Betfred Feed URL</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-betfred_feed_url">

                <span><?php esc_attr_e('Betfred Feed URL', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-betfred_feed_url" name="<?php echo $this->plugin_name; ?>[betfred_feed_url]" value="<?php if(!empty($betfred_feed_url)) echo $betfred_feed_url; ?>"  />
                <input type="submit" name="betfredBtn" value="Default URL" onclick="betfredOriginalURL(this); return false;"> 

            </label>

        </fieldset>

<hr>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Special Offers', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-betfred_special_offers">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-betfred_special_offers" name="<?php echo $this->plugin_name; ?>[betfred_special_offers]" value="1" <?php checked($betfred_special_offers, 1); ?> />

                <span><?php esc_attr_e('Special Offers', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Best Odds Guarenteed', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-betfred_bog">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-betfred_bog" name="<?php echo $this->plugin_name; ?>[betfred_bog]" value="1" <?php checked($betfred_bog, 1); ?> />

                <span><?php esc_attr_e('Best Odds Guarenteed', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span>betfred Welcome Bonus &pound;</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-betfred_welcome_bonus">

                <span><?php esc_attr_e('betfred Welcome Bonus &pound;', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-betfred_welcome_bonus" name="<?php echo $this->plugin_name; ?>[betfred_welcome_bonus]" value="<?php if(!empty($betfred_welcome_bonus)) echo $betfred_welcome_bonus; ?>" />

            </label>

        </fieldset>


<div class="alert alert-info" role="alert">
  <strong><i class="fas fa-exclamation-triangle"></i> Heads up!</strong> If you do <strong>not</strong> already have a Betfred affiliate account you can sign up <a href="https://bushell.net/recommends/betfred-affiliate/" target="_blank" class="alert-link">here</a>.
</div>

  </div>



  <div id="matchbook" class="tab-pane">

    <img src="../wp-content/plugins/<?php echo $this->plugin_name; ?>/app/images/matchbook_logo_admin.png" />

    


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Show Matchbook', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-show_matchbook">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_matchbook" name="<?php echo $this->plugin_name; ?>[show_matchbook]" value="1" <?php checked($show_matchbook, 1); ?> />

                <span><?php esc_attr_e('Show Matchbook', $this->plugin_name); ?></span>

            </label>

        </fieldset>



        <fieldset>

            <legend class="screen-reader-text"><span>Matchbook Affiliate ID</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-matchbook_affiliate_id">

                <span><?php esc_attr_e('Matchbook Affiliate ID', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-matchbook_affiliate_id" name="<?php echo $this->plugin_name; ?>[matchbook_affiliate_id]" value="<?php if(!empty($matchbook_affiliate_id)) echo $matchbook_affiliate_id; ?>"  />

            </label>

        </fieldset>

        <fieldset>

            <legend class="screen-reader-text"><span>Matchbook Feed URL</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-matchbook_feed_url">

                <span><?php esc_attr_e('Matchbook Feed URL', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-matchbook_feed_url" name="<?php echo $this->plugin_name; ?>[matchbook_feed_url]" value="<?php if(!empty($matchbook_feed_url)) echo $matchbook_feed_url; ?>"  />
                <input type="submit" name="matchbookBtn" value="Default URL" onclick="matchbookOriginalURL(this); return false;"> 

            </label>

        </fieldset>


        <hr>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Special Offers', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-matchbook_special_offers">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-matchbook_special_offers" name="<?php echo $this->plugin_name; ?>[matchbook_special_offers]" value="1" <?php checked($matchbook_special_offers, 1); ?> />

                <span><?php esc_attr_e('Special Offers', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Best Odds Guarenteed', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-matchbook_bog">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-matchbook_bog" name="<?php echo $this->plugin_name; ?>[matchbook_bog]" value="1" <?php checked($matchbook_bog, 1); ?> />

                <span><?php esc_attr_e('Best Odds Guarenteed', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span>matchbook Welcome Bonus &pound;</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-matchbook_welcome_bonus">

                <span><?php esc_attr_e('matchbook Welcome Bonus &pound;', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-matchbook_welcome_bonus" name="<?php echo $this->plugin_name; ?>[matchbook_welcome_bonus]" value="<?php if(!empty($matchbook_welcome_bonus)) echo $matchbook_welcome_bonus; ?>" />

            </label>

        </fieldset>


<div class="alert alert-info" role="alert">
  <strong><i class="fas fa-exclamation-triangle"></i> Heads up!</strong> If you do <strong>not</strong> already have a Matchbook affiliate account you can sign up <a href="https://bushell.net/recommends/matchbook-affiliate/" target="_blank" class="alert-link">here</a>.
</div>


  </div>




  <div id="unibet" class="tab-pane">

    <img src="../wp-content/plugins/<?php echo $this->plugin_name; ?>/app/images/unibet_logo_admin.png" />

<br>
<div class="alert alert-warning" role="alert">
  <i class="fas fa-exclamation-triangle"></i> You will need developer access to display the odds from Unibet. You can sign up for a developer account here <strong><a href='https://developer.kindredgroup.com/signup.html' target="_blank">https://developer.kindredgroup.com/signup.html</a></strong>.
</div>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Show Unibet', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-show_unibet">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_unibet" name="<?php echo $this->plugin_name; ?>[show_unibet]" value="1" <?php checked($show_unibet, 1); ?> />

                <span><?php esc_attr_e('Show Unibet', $this->plugin_name); ?></span>

            </label>

        </fieldset>



        <fieldset>

            <legend class="screen-reader-text"><span>Unibet Affiliate ID</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-unibet_affiliate_id">

                <span><?php esc_attr_e('Unibet Affiliate ID', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-unibet_affiliate_id" name="<?php echo $this->plugin_name; ?>[unibet_affiliate_id]" value="<?php if(!empty($unibet_affiliate_id)) echo $unibet_affiliate_id; ?>"  />

            </label>

        </fieldset>



                <!-- unibet app key -->

        <fieldset>

            <legend class="screen-reader-text"><span>Unibet App Key</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-unibet_app_key">

                <span><?php esc_attr_e('Unibet App Key', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-unibet_app_key" name="<?php echo $this->plugin_name; ?>[unibet_app_key]" value="<?php if(!empty($unibet_app_key)) echo $unibet_app_key; ?>"  />

            </label>

        </fieldset>



        <!-- unibet app id -->

        <fieldset>

            <legend class="screen-reader-text"><span>Unibet App ID</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-unibet_app_id">

                 <span><?php esc_attr_e('Unibet App ID', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-unibet_app_id" name="<?php echo $this->plugin_name; ?>[unibet_app_id]" value="<?php if(!empty($unibet_app_id)) echo $unibet_app_id; ?>" />

            </label>

        </fieldset>

<hr>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Special Offers', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-unibet_special_offers">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-unibet_special_offers" name="<?php echo $this->plugin_name; ?>[unibet_special_offers]" value="1" <?php checked($unibet_special_offers, 1); ?> />

                <span><?php esc_attr_e('Special Offers', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Best Odds Guarenteed', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-unibet_bog">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-unibet_bog" name="<?php echo $this->plugin_name; ?>[unibet_bog]" value="1" <?php checked($unibet_bog, 1); ?> />

                <span><?php esc_attr_e('Best Odds Guarenteed', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span>unibet Welcome Bonus &pound;</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-unibet_welcome_bonus">

                <span><?php esc_attr_e('unibet Welcome Bonus &pound;', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-unibet_welcome_bonus" name="<?php echo $this->plugin_name; ?>[unibet_welcome_bonus]" value="<?php if(!empty($unibet_welcome_bonus)) echo $unibet_welcome_bonus; ?>" />

            </label>

        </fieldset>

<div class="alert alert-info" role="alert">
  <strong><i class="fas fa-exclamation-triangle"></i> Heads up!</strong> If you do <strong>not</strong> already have a UniBet affiliate account you can sign up <a href="https://bushell.net/recommends/unibet-affiliate/" target="_blank" class="alert-link">here</a>.
</div>


  </div>
        


<!-- leovegas -->

<div id="leovegas" class="tab-pane">

<img src="../wp-content/plugins/<?php echo $this->plugin_name; ?>/app/images/leovegas_logo_admin.png" />

    


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Show LeoVegas', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-show_leovegas">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_leovegas" name="<?php echo $this->plugin_name; ?>[show_leovegas]" value="1" <?php checked($show_leovegas, 1); ?> />

                <span><?php esc_attr_e('Show LeoVegas', $this->plugin_name); ?></span>

            </label>

        </fieldset>




        <fieldset>

            <legend class="screen-reader-text"><span>LeoVegas Affiliate ID</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-leovegas_affiliate_id">

                <span><?php esc_attr_e('Leo Vegas Affiliate ID', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-leovegas_affiliate_id" name="<?php echo $this->plugin_name; ?>[leovegas_affiliate_id]" value="<?php if(!empty($leovegas_affiliate_id)) echo $leovegas_affiliate_id; ?>"  />

            </label>

        </fieldset>


<hr>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Special Offers', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-leovegas_special_offers">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-leovegas_special_offers" name="<?php echo $this->plugin_name; ?>[leovegas_special_offers]" value="1" <?php checked($leovegas_special_offers, 1); ?> />

                <span><?php esc_attr_e('Special Offers', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span><?php _e('Best Odds Guarenteed', $this->plugin_name); ?></span></legend>

            <label for="<?php echo $this->plugin_name; ?>-leovegas_bog">

                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-leovegas_bog" name="<?php echo $this->plugin_name; ?>[leovegas_bog]" value="1" <?php checked($leovegas_bog, 1); ?> />

                <span><?php esc_attr_e('Best Odds Guarenteed', $this->plugin_name); ?></span>

            </label>

        </fieldset>


        <fieldset>

            <legend class="screen-reader-text"><span>leovegas Welcome Bonus &pound;</span></legend>

            <label for="<?php echo $this->plugin_name; ?>-leovegas_welcome_bonus">

                <span><?php esc_attr_e('leovegas Welcome Bonus &pound;', $this->plugin_name); ?></span>

                <input type="text" id="<?php echo $this->plugin_name; ?>-leovegas_welcome_bonus" name="<?php echo $this->plugin_name; ?>[leovegas_welcome_bonus]" value="<?php if(!empty($leovegas_welcome_bonus)) echo $leovegas_welcome_bonus; ?>" />

            </label>

        </fieldset>

<div class="alert alert-info" role="alert">
  <strong><i class="fas fa-exclamation-triangle"></i> Heads up!</strong> If you do <strong>not</strong> already have a LeoVegas affiliate account you can sign up <a href="https://bushell.net/recommends/leovegas-affiliate/" target="_blank" class="alert-link">here</a>.
</div>



  </div>

<span>Version <strong><?php echo $version;?></strong> - Copyright Bushell.net 2011 - 2019.</span>

        



        <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>



    </form>



</div>


                <script>

                    //william hill
                    var williamHillURL = 'http://cachepricefeeds.williamhill.com/openbet_cdn?action=template&template=getHierarchyByMarketType&classId=2&marketSort=--&filterBIR=N';

                    function williamHillOriginalURL(button) {
                       var buttonVal = button.name,
                       textbox = document.getElementById('<?php echo $this->plugin_name; ?>-williamhill_feed_url');
                       textbox.value = williamHillURL ;
                    }

                    // smarkets
                    var smarketsURL = 'https://odds.smarkets.com/oddsfeed.xml.gz?event_type=horse_racing_race';

                    function smarketsOriginalURL(button) {
                       var buttonVal = button.name,
                       textbox = document.getElementById('<?php echo $this->plugin_name; ?>-smarkets_feed_url');
                       textbox.value = smarketsURL ;
                    }

                    // betfred
                    var betfredURL = 'https://xml.betfred.com/Horse-Racing-Daily.xml';

                    function betfredOriginalURL(button) {
                       var buttonVal = button.name,
                       textbox = document.getElementById('<?php echo $this->plugin_name; ?>-betfred_feed_url');
                       textbox.value = betfredURL ;
                    }

                    //matchbook
                    var matchbookURL = 'https://api.matchbook.com/edge/rest/events?sport-ids=24735152712200&side=back&states=open&per-page=100&currency=GBP';

                    function matchbookOriginalURL(button) {
                       var buttonVal = button.name,
                       textbox = document.getElementById('<?php echo $this->plugin_name; ?>-matchbook_feed_url');
                       textbox.value = matchbookURL ;
                    }
                </script>