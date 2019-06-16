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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php
        $id = $_GET['id'];
        echo $id;
        ?>
        <div class="container">

                <?php
                // Create instance of API class
                $api = new FootballData();
                ?>

            <?php
                echo "<p><hr><p>";
                // fetch all available upcoming matches for the next 3 days
                $now = new DateTime();
                $end = new DateTime(); $end->add(new DateInterval('P7D'));
                $response = $api->findMatchesForDateRange($now->format('Y-m-d'), $end->format('Y-m-d'), 2021);
                $team = $api->findTeamById($id);
            ?>
            <div class="page-header">
                <h1><?php echo $team->name; ?></h1>
            </div>
<img src="<?php echo $team->crestUrl ;?>" height="150px" width="150px"/><br>
<span>Venue: <?php echo $team->venue ; ?> </span><br>
<span>Founded: <?php echo $team->founded ; ?> </span><br>
<span>Website: <?php echo $team->website ; ?> </span><br>
<span>Club Colours: <?php echo $team->clubColors ; ?> </span>


            <?php
                echo "<p><hr><p>";
                $matches = $api->findUpcomingMatchesByTeam($id, 5);
            ?>
                <h3>Next 5 games for <?php echo $team->name; ?>:</h3>
                <table class="table table-striped">
                    <tr>
                        <th>HomeTeam</th>
                        <th></th>
                        <th>AwayTeam</th>
                        <th>Date</th>
                    </tr>
                    <?php foreach ($matches as $match) { ?>
                    <tr onclick="window.location.href='match.php?id=<?php echo $match->id; ?>';">  
                                        
                        <td><?php echo $match->homeTeam->name; ?></a></td>
                        <td>-</td>
                        <td><?php echo $match->awayTeam->name; ?></td>
                        <td><?php echo $match->utcDate ;?></td>
            
                    </tr>
                    <?php } ?>
                </table>



<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
        All Home Games</a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
      <div class="panel-body">
                      <?php
                echo "<p><hr><p>";
                $matches = $api->findHomeMatchesByTeam($id);
            ?>
                <h3>All home matches of <?php echo $team->name; ?>:</h3>
                <table class="table table-striped">
                    <tr>
                        <th>HomeTeam</th>
                        <th></th>
                        <th>AwayTeam</th>
                        <th colspan="3">Result</th>
                    </tr>
                    <?php foreach ($matches as $match) { ?>
                    <tr onclick="window.location.href='match.php?id=<?php echo $match->id; ?>';" style="cursor: pointer">  
                                        
                        <td><?php echo $match->homeTeam->name; ?></td>
                        <td>-</td>
                        <td><?php echo $match->awayTeam->name; ?></td>
                        <td><?php echo $match->score->fullTime->homeTeam;  ?></td>
                        <td>:</td>
                        <td><?php echo $match->score->fullTime->awayTeam;  ?></td>
            
                    </tr>
                    <?php } ?>
                </table>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
        All Away Games</a>
      </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse">
      <div class="panel-body">
            <?php
                echo "<p><hr><p>";
                $matches = $api->findAwayMatchesByTeam($id);
            ?>
                <h3>All away matches of <?php echo $team->name; ?>:</h3>
                <table class="table table-striped">
                    <tr>
                        <th>HomeTeam</th>
                        <th></th>
                        <th>AwayTeam</th>
                        <th colspan="3">Result</th>
                    </tr>
                    <?php foreach ($matches as $match) { ?>
                    <tr>                        
                        <td><?php echo $match->homeTeam->name; ?></td>
                        <td>-</td>
                        <td><?php echo $match->awayTeam->name; ?></td>
                        <td><?php echo $match->score->fullTime->homeTeam;  ?></td>
                        <td>:</td>
                        <td><?php echo $match->score->fullTime->awayTeam;  ?></td>
                    </tr>
                    <?php } ?>
                </table>
      </div>
    </div>
  
  </div>
</div>








            <?php
                echo "<p><hr><p>";
                // show players of a specific team
                
            ?>
            <h3>Players of <?php echo $team->name; ?></h3>
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Position</th>                    
                <th>Shirtnumber</th>
                    <th>Date of birth</th>
                </tr>
                <?php foreach ($team->squad as $player) { ?>
                <tr>
                    <td><?php echo $player->name; ?></td>
                    <td><?php echo $player->position; ?></td>                    
                    <td><?php echo $player->shirtNumber; ?></td>
                    <td><?php echo $player->dateOfBirth; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </body>
</html>
