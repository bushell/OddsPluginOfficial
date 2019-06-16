<style>
	.bestOdds {
		border: 1px solid red;
	}
</style>
<div class="container">

	<div style="padding-top: 100px;" ng-show="is_loading">
		<center>
			<h1 style="font-size: 60px;">
				<i class="fa fa-spinner fa-spin"></i>
			</h1>
		</center>
	</div>

	<div>
		<h2><a style="cursor:pointer" ng-click="changeView('home')">Horses</a></h2>
	</div>

	<div class="options">
		Betfair Market:

		<select name="Market">
			<option value="volvo">Back Odds</option>
			<option value="saab">Lay Odds</option>
		</select>
		<br>
		<br>
	</div>
	<div class="row">
		<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
			<div class="list-group" ng-repeat="(key, value) in data | groupBy:'competitionRegion'">
				<a class="list-group-item active">
					{{key}}
				</a>
				<a ng-repeat="(keyInner,valueInner) in value" class="list-group-item" ng-click="showEventDetails(valueInner['competition'].id, valueInner['competition'].name)">{{valueInner['competition'].name}}
					<i class="fa fa-chevron-right" style="float:right;"></i>
				</a>
			</div>
		</div>
		<div class="col-lg-5 col-md-6 col-sm-12 col-xs-12" ng-if="events">
			<div class="list-group">
				<a class="list-group-item active">
					{{eventTitle}}
				</a>

				<a ng-repeat="(key, value) in events" class="list-group-item" ng-click="showRunners(value)">
					{{value['event'].openDate | date:'dd-MMMM-yyyy h:mma'}} - {{value['event'].name}}
					<!-- {{value['event'].openDate}} -->
					<any style="float: right;">
						<i class="fa fa-bar-chart-o"></i> {{value.marketCount}} &nbsp;&nbsp;&nbsp;&nbsp;
						<i class="fa fa-chevron-right"></i>
					</any>
				</a>
			</div>
		</div>
		<div class="col-lg-4" ng-if="runners">
			<div class="list-group">
				<span class="list-group-item active">
					{{currentEvents['event'].openDate | date:'dd-MMMM-yyyy h:mma'}} - {{currentEvents['event'].name}} - <a href="https://www.betfair.com/exchange/plus/horse-racing/market/{{globalMarketId}}" target="_blank">Open</a> 
				</span>

				<a ng-repeat="(key, value) in runners track by $index" class="list-group-item">
					<!-- <img style ="border: 1px solid #dddddd; border-radius: 20%;"src="https://content-cache.cdnbf.net/feeds_images/Horses/SilkColours/{{value.metadata.COLOURS_FILENAME}}"/> -->
					{{value.marketName}}
					<!-- <div style="margin-left: 30px; font-size: 9px;"><strong>Jockey: </strong> {{value.metadata.JOCKEY_NAME}}</div> -->
					


					<!-- <any style="float: right; margin-top: -32px; background: #00B073; border-radius: .25em; margin-right: 55px;" ng-class="{bestOdds: marketPrice[$index] > matchbookOdds[$index]}" >
						<div style="width: 48px;">
							<span class="label"  style="line-height: 28px; padding: 0.2em 0.9em .3em; margin-left: 6px;">
								<img ng-if="!marketPrice[$index] && marketPrice[$index] !== 0" src="images/ajaxSpinner.gif" alt="Spinner" height="16" width="16" />
								{{ marketPrice[$index] }}
								
							</span>
						</div>
					</any> -->

					<!-- <any style="float: right; margin-top: -32px; background: #428bca; border-radius: .25em;" ng-class="{bestOdds: matchbookOdds[$index] > marketPrice[$index]}">
						<div style="width: 48px;">
						<span class="label" id="{{value.slug}}" style="line-height: 28px; padding: 0.2em 0.9em .3em; margin-left: 6px;">
							<img ng-if="!matchbookOdds[$index] && matchbookOdds[$index] !== 'N/A'" src="images/ajaxSpinner.gif" alt="Spinner" height="16" width="16" />
							{{ matchbookOdds[$index] }}
						</span></div>
					</any> -->
				</a>
			</div>
		</div>
	</div>
</div>