<?php
  include 'FootballData.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>phplib football-data.org</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

       
       <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>        <style>
        .crest{
            height:24px;
            width:24px;
        }
    </style>
    </head>
    <body>
        <div class="container">
                <div class="page-header">
                    <h1>Widgets</h1>
                </div>
                <?php
                // Create instance of API class
                $api = new FootballData();
                echo "<p><hr><p>"; ?>
                
                <h3>Current standing of the Premiere League</h3>
                <table class="table table-striped">
                    <tr>
                    <th>Position</th>
                    <th></th>   
                    <th>TeamName</th>
                    <th>Played</th>
                    <th>W</th>
                    <th>D</th>
                    <th>L</th>
                    <th>GF</th>
                    <th>GA</th>
                    <th>GD</th>
                    <th>Pts</th>
                    </tr>
                    <?php foreach ($api->findStandingsByCompetition(2021)->standings as $standing) { 
                          if ($standing->type == 'TOTAL') { 
                              foreach ($standing->table as $standingRow) {
                    ?>
                    <tr>
                      <td><?php echo $standingRow->position; ?></td>
                      <td><img src="<?php echo $standingRow->team->crestUrl ; ?>" class="crest"/></td>
                      <td><a href="team.php?id=<?php echo $standingRow->team->id ; ?>"><?php echo $standingRow->team->name; ?></a></td>
                      <td><?php echo $standingRow->playedGames; ?></td>
                      <td><?php echo $standingRow->won; ?></td>
                      <td><?php echo $standingRow->draw; ?></td>
                      <td><?php echo $standingRow->lost; ?></td>
                      <td><?php echo $standingRow->goalsFor; ?></td>
                      <td><?php echo $standingRow->goalsAgainst; ?></td>
                      <td><?php echo $standingRow->goalDifference; ?></td>
                      <td><?php echo $standingRow->points; ?></td>
                    </tr>
                    <?php }}} ?>
                    <tr>
                    </tr>
                </table>

            <?php
                echo "<p><hr><p>";
                // fetch all available upcoming matches for the next 3 days
                $now = new DateTime();
                $end = new DateTime(); $end->add(new DateInterval('P7D'));
                $response = $api->findMatchesForDateRange($now->format('Y-m-d'), $end->format('Y-m-d'), 2021);
            ?>
            <h3>Upcoming matches within the next 7 days</h3>
                <table class="table table-striped">
                    <tr>
                        <th>HomeTeam</th>
                        <th></th>
                        <th>AwayTeam</th>
                        <th colspan="3">Result</th>
                    </tr>
                    <?php foreach ($response->matches as $match) { ?>
                    <tr>
                        <td><?php echo $match->homeTeam->name; ?></td>
                        <td>-</td>
                        <td><?php echo $match->awayTeam->name; ?></td>
                        <td><?php echo $match->score->fullTime->homeTeam; ?></td>
                        <td>:</td>
                        <td><?php echo $match->score->fullTime->awayTeam; ?></td>
                    </tr>
                    <?php } ?>
                </table>

            
        </div>
    </body>
</html>
