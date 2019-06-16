# Install #

This README would normally document whatever steps are necessary to get your application up and running.

### First ###

* For this plugin to work you NEED a BetFair Developer account.
* Enter username/password/app key here: \app\win_nr\includes
* Setup the following cronjobs
Cron Jobs
The following cron jobs need to be setup in order for the plugin to work correctly. These are the recommended cronjob settings, feel free to adjust these to your needs 0 0,12 * * * wget -q https://bushell.net/demo/wp-content/plugins/horse-exchange/app/win_nr/get_daily_runners.php > /dev/null 2>&1 */20 * * * * wget -q https://bushell.net/demo/wp-content/plugins/horse-exchange/app/win_nr/get_horse_status.php > /dev/null 2>&1 */10 * * * * wget -q https://bushell.net/demo/wp-content/plugins/horse-exchange/app/feeds/smarkets_downloader.php?key=88LWnm2bhh8pQ32g > /dev/null 2>&1

### How do I get set up? ###

* Summary of set up
* Configuration
* Dependencies
* Database configuration
* How to run tests
* Deployment instructions

### Contribution guidelines ###

* Writing tests
* Code review
* Other guidelines

### Who do I talk to? ###

* Repo owner or admin
* Other community or team contact
