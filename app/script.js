var myApp = angular.module('myApp', ['ngRoute', 'angular.filter']);

myApp.config(function ($routeProvider) {
	$routeProvider
		.when('/', {
			templateUrl: 'pages/home.html',
			controller: 'homeController'
		})
		.when('/home', {
			templateUrl: 'pages/home.html',
			controller: 'homeController'
		})
		.when('/market', {
			templateUrl: 'pages/market.html',
			controller: 'marketController'
		})
		.when('/football', {
			templateUrl: 'pages/football.php',
			controller: 'footballController'
		})

		.when('/contact', {
			templateUrl: 'pages/contact.html',
			controller: 'contactController'
		});
});

myApp.controller('homeController', function ($scope, $http, $filter, $interval, $location) {
	// setInterval(function() {

	// 	var h = window.innerHeight;
	// 	var w = window.innerWidth;
	  
	// 	var iframe = document.getElementsByTagName("iframe")[0];
	  
	// 	if(iframe) {
	// 		iframe.style.height = h + "px";
	// 		iframe.style.width = w + "px";
	// 	}
	  
	//   }, 100);
	localStorage.setItem('runners', '');
	$scope.is_loading = true;
	$scope.live_odds = true;
	
	$scope.is_show_betfair = false;
	$scope.is_show_betfred = false;
	$scope.is_show_matchbook = false;
	$scope.is_show_smarkets = false;
	$scope.is_show_williamhill = false;

	$scope.globalMarketId = 0;
	$scope.globalEventId = 0;
	$scope.globalDateTime = 0

	$scope.changeView = function (view) {
		$location.path(view);
	}

	$scope.getTitle = function(value) {
		$scope.runnerLength = $scope.runners.length;
		$scope.title = value[0].event.venue;
	}

	$scope.showEventDetails = function (title, value) {
		console.log(title, value);
		$scope.runners = null;
		$scope.eventTitle = title;
		$scope.events = value;
	}

	function callToIframe() {
		/* Call to parent for height*/
        var body = document.body,
        html = document.documentElement;

        var height = Math.max( body.scrollHeight, body.offsetHeight, 
                       html.clientHeight, html.scrollHeight, html.offsetHeight );


        console.log("height--->", height);

        function bindEvent(element, eventName, eventHandler) {
            if (element.addEventListener) {
                element.addEventListener(eventName, eventHandler, false);
            } else if (element.attachEvent) {
                element.attachEvent('on' + eventName, eventHandler);
            }
        }
        var sendMessage = function (msg) {
            // Make sure you are sending a string, and to stringify JSON
            window.parent.postMessage(msg, '*');
        };

        setTimeout(function(){
            sendMessage('' + height);
        });
		/* END */
	}

	function getData() {
		console.log('getData');
		$http({
			method: 'GET',
			url: 'https://bushell.net/betfair.php'
		}).then(function successCallback(response) {
			$scope.tempData = angular.copy(response.data);
			$scope.filterData('today');
			$scope.is_loading = false;
			setTimeout(function(){
				callToIframe();
			});
		}, function errorCallback(response) {});
	}

	function slugify(text) {
		return text.toString().toLowerCase()
			.replace(/\s+/g, '-') // Replace spaces with -
			.replace(/[^\w\-]+/g, '') // Remove all non-word chars
			.replace(/\-\-+/g, '-') // Replace multiple - with single -
			.replace(/^-+/, '') // Trim - from start of text
			.replace(/-+$/, ''); // Trim - from end of text
	}

	$scope.callEvery30Sec = function () {
		var getValue = localStorage.getItem('runners');
		if(getValue && getValue !== null) {
			var getValue = JSON.parse(getValue);
			$scope.showRunners(getValue.datetime, getValue.markertName, getValue.runners, getValue.datetime, getValue.obj, getValue.marketId);		
		}
	}

	$scope.betfair_affiliate_id = '';
	$scope.betfred_affiliate_id = '';
	$scope.matchbook_affiliate_id = '';
	$scope.smarkets_affiliate_id = '';
	$scope.unibet_affiliate_id = '';
	$scope.williamhill_affiliate_id = '';
	$scope.unibet_app_key = '';
	$scope.unibet_app_id = '';

	$scope.bookmarkData = function () {
		$http({
			method: 'GET',
			url : 'https://bushell.net/demo/wp-content/plugins/horse-exchange/app/pages/config.php?data=bookmaker_data'
		}).then(function successCallback(response) {
			$scope.betfair_affiliate_id = response.data.betfair_affiliate_id;
			$scope.betfred_affiliate_id = response.data.betfred_affiliate_id;
			$scope.matchbook_affiliate_id = response.data.matchbook_affiliate_id;
			$scope.smarkets_affiliate_id = response.data.smarkets_affiliate_id;
			$scope.unibet_affiliate_id = response.data.unibet_affiliate_id;
			$scope.williamhill_affiliate_id = response.data.williamhill_affiliate_id;
			$scope.unibet_app_key = response.data.unibet_app_key;
			$scope.unibet_app_id = response.data.unibet_app_id;
			var tempObj = response.data;
			if(tempObj.show_betfair == 1) {
				$scope.is_show_betfair = true;
			}
			if(tempObj.show_betfred == 1) {
				$scope.is_show_betfred = true;
			}
			if(tempObj.show_matchbook == 1) {
				$scope.is_show_matchbook = true;
			}
			if(tempObj.show_smarkets == 1) {
				$scope.is_show_smarkets = true;
			}
			if(tempObj.show_williamhill == 1) {
				$scope.is_show_williamhill = true;
			}

			if(tempObj.live_odds == 1) {
				setInterval(function(){
					$scope.callEvery30Sec();
				}, 30000)
			}
		}, function errorCallback(response) {});
	}
	$scope.bookmarkData();
	
	$scope.showRunners = function (datetime, markertName, runners, datetime, obj, marketId) {
		var tempObj = {
			'datetime' : datetime,
			'markertName' : markertName,
			'runners' : runners,
			'datetime' : datetime,
			'obj' : obj,
			'marketId' : marketId
		}
		localStorage.setItem('runners', JSON.stringify(tempObj));

		$scope.globalMarketId = obj.marketId;
		$scope.globalDateTime = datetime;

		for (j = 0; j < runners.length; j++) {
			runners[j].price = 0.0;
			runners[j].slug = slugify(runners[j]['runnerName']);
		}
		// $scope.teamData = [];
		// $http({
		// 	method: 'GET',
		// 	url: 'http://81.4.120.65/betfair/results.php'
		// }).then(function successCallback(response) {
		// 	for (var i = 0; i < response.data.length; i++) {
		// 		if (response.data[i].marketId == $scope.globalMarketId && response.data[i].dayToSearch == $scope.globalDateTime) {
		// 			$scope.teamData = response.data[i].data;
		// 			for (z = 0; z < $scope.teamData.length; z++) {
		// 				for (y = 0; y < runners.length; y++) {
		// 					if (slugify($scope.teamData[z].teamName).indexOf(runners[y].slug) > -1) {
		// 						$("#scrap-" + runners[y].slug).html($scope.teamData[z].point);
		// 					}
		// 				}
		// 			}
		// 			break;
		// 		}
		// 	}
		// });
		
		function getunibetData() {
			$scope.unibetArr = [];
			var startDate = encodeURIComponent(datetime);
			var endDate = new Date(datetime);
			endDate.setDate(endDate.getDate() + 1); 
			var endDate = encodeURIComponent(endDate.toISOString());
			var unibetUrl = "https://api.unicdn.net/v1/feeds/sunrise/api/v1/meetings.json?app_id="+$scope.unibet_app_id+"&app_key="+$scope.unibet_app_key+"&searchRequest.startDateTime=" +startDate+ "&searchRequest.endDateTime="+endDate+"&searchRequest.countryCodes=GBR";
			$http({
				url: unibetUrl,
				method: 'GET'
			}).then(function successCallback(response) {
				if (response) {
					var data = response.data;
					var eventKey = getEventKey(data);
					if (eventKey == undefined) {
						for(var i = 0, len = $scope.runners.length; i < len; i++) {
							$scope.unibetArr.push('N/A');		
						}					
					} else {
						$http({
							url: 'https://api.unicdn.net/v1/feeds/sunrise/api/v1/events/'+eventKey+'.json?app_id='+$scope.unibet_app_id+'&app_key='+$scope.unibet_app_key,
							method: 'GET'
						}).then(function successCallback(response) {
							if (response) {
								for(var i = 0, len = $scope.runners.length; i < len; i++) {
									var tempVal = checkRuunnerNameInUnibet(response.data, $scope.runners[i]['runnerName']);
									$scope.unibetArr.push(tempVal);		
								}
								callToIframe();
							}
						});
					}

				}
			});
		}
		getunibetData();


		function checkRuunnerNameInUnibet(data, runnerName) {
			var fulldata = data.competitors;
			for (var i = 0, len = fulldata.length ; i < len ; i++) {
				if(fulldata[i]['name'] == runnerName) {
					return fulldata[i]['prices'][0]['price'];
				}
			}
			return "SP";
		}

		function getEventKey(data) {
			for (var i = 0 , len = data.meetings.length ; i < len ; i++) {
				if(obj.event.venue === data.meetings[i]['name']) {
					for(var j = 0 , len = data.meetings[i]['events'].length ; j < len ; j++) {
						var checkDate = new Date(datetime).getHours() + ":" + new Date(datetime).getMinutes();
						var utc = new Date(data.meetings[i]['events'][j]['eventDateTimeUtc']).getHours() + ":" + new Date(data.meetings[i]['events'][j]['eventDateTimeUtc']).getMinutes();
						if(utc === checkDate) {
							return data.meetings[i]['events'][j]['eventKey'];
						} 
					}
				} 
			}
		}

		function getLasVegasData() {
			$scope.lasvegasEventId = '';
			$scope.lasVegasOdds = [];
			$http({
				url: 'https://eu-offering.kambicdn.org/offering/v2018/leoal/meeting/horse_racing.json?lang=en_GB&market=GB',
				method: 'GET'
			}).then(function successCallback(response) {
				if (response) {
					var data = response.data;
					$scope.lasvegasEventId = checkStartTimeEvent(data);
		
					$http({
						url: 'https://eu-offering.kambicdn.org/offering/v2018/leoal/betoffer/event/' + $scope.lasvegasEventId + '.json?lang=en_GB&market=GB',
						method: 'GET'
					}).then(function successCallback(response) {
						if (response) {
							for(var i = 0, len = $scope.runners.length; i < len; i++) {
								var tempVal = checkRuunnerNameInLasvegas(response.data, $scope.runners[i]['runnerName']);
								$scope.lasVegasOdds.push(tempVal);		
							}
							callToIframe();
						}
					});
				}
			});
		}
		getLasVegasData();

		function checkRuunnerNameInLasvegas(data, runnerName) {
			for (var i = 0, len = data['betOffers'].length ; i < len ; i++) {
				for (var j = 0, jLen = data['betOffers'][i]['outcomes'].length ; j < jLen ; j++) {
					if(data['betOffers'][i]['outcomes'][j]['label'].toLowerCase() == runnerName.toLowerCase()) {
						if(data['betOffers'][i]['outcomes'][j]['oddsFractional']) {
							console.log(data['betOffers'][i]['outcomes'][j]['oddsFractional']);
							var a = data['betOffers'][i]['outcomes'][j]['oddsFractional'].split("/");
							return (a[0]/a[1])+1; 
						}else {
							return "SP"
						}
					}	
				}
			}
		}

		function checkStartTimeEvent(data) {
			for (var i = 0 , len = data.length ; i < len ; i++) {
				if(obj.event.venue === data[i]['context']['course']['name']) {
					for(var j = 0 , len = data[i]['events'].length ; j < len ; j++) {
						var checkDate = new Date(datetime).getHours() + ":" + new Date(datetime).getMinutes();
						if(data[i]['events'][j]['originalStartTime'] === checkDate) {
							return data[i]['events'][j]['id'];
						} 
					}
				} 
			}
		}

		// decimal odds calculation
		// $http({
		// 	url: 'https://eu-offering.kambicdn.org/offering/v2018/leoal/betoffer/event/1005056397.json?lang=en_GB&market=GB',
		// 	method: 'GET'
		// }).then(function successCallback(response) {
		// 	if (response) {
		// 		console.log(response);
		// 	}
		// });

		// $http({
		// 	url: '',
		// 	method: 'GET'
		// }).then(function successCallback(response) {
		// 	if (response) {
		// 		console.log(response);
		// 	}
		// });




		$scope.datetime = datetime;
		$scope.eventMarkertName = markertName;
		$scope.horseStatus = [];
		$scope.runners = runners;

		$scope.marketPrice = [];
		$http({
			url: 'feeds/betfair.php',
			method: 'POST',
			data: {
				"marketId": marketId
			}
		}).then(function successCallback(response) {
			if (response) {
				if (response.data.eventTypes.length) {
					var tempArray = response.data.eventTypes[0].eventNodes[0].marketNodes[0].runners;
					for (var i = 0, len = tempArray.length; i < len; i++) {
						var price = 0;
						var horse_status = 0;
						if (Object.keys(tempArray[i].exchange).length) {
							price = tempArray[i].exchange.availableToBack[0].price;
							horse_status = tempArray[i].state.status;
						}
						$scope.marketPrice.push(price);
						$scope.horseStatus.push(horse_status);
					}
				}
			}
		});

		$scope.matchbookOdds = [];
		$http({
			url: 'feeds/matchbook.php',
			method: 'GET'
		}).then(function successCallback(response) {
			var tempArray = response.data.events;
			if($scope.runners) {
				for (var i = 0, len = $scope.runners.length; i < len; i++) {
					var name = $scope.runners[i].metadata.CLOTH_NUMBER_ALPHA + ' ' + $scope.runners[i].runnerName;
					name = name.split(".").join(" ");
					var newVal = $scope.checkRunners(name, tempArray);
					if (newVal) {
						$scope.matchbookOdds.push(newVal);
					} else {
						$scope.matchbookOdds.push("N/A");
					}
				}
			}
		});


		$scope.decimalPrice = [];
		var toWinArray = [];
		$scope.greenUrl = [];
		$http({
			url: 'feeds/smarkets.php',
			method: 'GET'
		}).then(function successCallback(response) {
			if (response) {
				var data = response.data.event;
				for (var i = 0, len = data.length; i < len; i++) {
					var win = data[i].market[0];
					if (win) {
						if (win['@attributes'].slug === 'to-win') {
							toWinArray.push(data[i]);
						}
					}
				}
			}
		});
		setTimeout(function () {

			for (var i = 0, len = $scope.runners.length; i < len; i++) {
				var name = $scope.runners[i].runnerName;
				var newVal = $scope.getDecimal(name, toWinArray);

				var url = $scope.createUrlDecimal(name, toWinArray);
				if(url){
					$scope.greenUrl.push(url);
				} else {
					$scope.greenUrl.push("");
				}

				if (newVal) {
					$scope.decimalPrice.push(newVal);
				} else {
					$scope.decimalPrice.push("N/A");
				}
			}
		}, 1500);


		$scope.horseRacingdecimalPrice = [];
		$scope.horseRacingdecimalPriceURL = [];
		
		$http({
			url: 'feeds/betfred.php',
			method: 'GET'
		}).then(function successCallback(response) {
			if (response) {
				var events = response.data.event || [];
				if( events.length ) {
					for(var i = 0, len = $scope.runners.length; i < len; i++) {
						var name = $scope.runners[i].runnerName;
						var newVal = $scope.getHorseRacingPrice(name, events);
						var url = $scope.getHorseRacingPriceURL(name, events);
						if (newVal) {
							$scope.horseRacingdecimalPrice.push(newVal);
							$scope.horseRacingdecimalPriceURL.push(url);
						} else {
							$scope.horseRacingdecimalPrice.push("N/A");
							$scope.horseRacingdecimalPriceURL.push('');
						}		
					}
				}				
			}
		});

		$scope.hierarchyByMarketType = [];
		$scope.hierarchyByMarketTypeURL = [];
		$http({
			url: 'feeds/williamhill.php',
			method: 'GET'
		}).then(function successCallback(response) {
			if (response) {
				console.log(response.data);
				var data = response.data['response']['williamhill']['class']['type'] || [];
				if( data.length ) {
					for(var i = 0, len = $scope.runners.length; i < len; i++) {
						var name = $scope.runners[i].runnerName;
						var newVal = $scope.gethierarchyByMarketType(name, data);
						var url = $scope.createUrlhierarchyByMarketType(name, data);
						if(url) {
							$scope.hierarchyByMarketTypeURL.push(url);
						}

						if (newVal) {
							$scope.hierarchyByMarketType.push(newVal);
						} else {
							$scope.hierarchyByMarketType.push("N/A");
						}		
					}
				}				
			}
		});


		stop = $interval(function () {
			for (j = 0; j < runners.length; j++) {
				runners[j].price = 0.0;
			}

			var data = datetime.split("T");
			data[1] = data[1].substring(0, data[1].length - 1);
			var time = data[1].split(".");
			$http({
				method: 'GET',
				url: 'https://bushell.net/smarkets.php?meeting=' + $scope.eventTitle + '&date=' + data[0] + '&time=' + time[0] + ''
			}).then(function successCallback(response) {
				for (i = 0; i < (response.data.market || []).length; i++) {
					if (response.data.market[i]['@attributes']['slug'] == "to-win") {
						for (j = 0; j < response.data.market[i]['contract'].length; j++) {
							var rName = response.data.market[i]['contract'][j]['@attributes']['slug'];
							try {
								var rPrice = response.data.market[i]['contract'][j]['bids']['price'][0]['@attributes']['decimal']

								$("#" + rName).html(rPrice);
								//$scope.runners[l]['price'] = response.data.market[i]['contract'][j]['bids']['price'][0]['@attributes']['decimal']
							} catch (e) {
								$("#" + rName).html("N/A");
							}
						}
					}
				}

			}, function errorCallback(response) {});
		}, 30000);

		var data = datetime.split("T");
		data[1] = data[1].substring(0, data[1].length - 1);
		var time = data[1].split(".");
		$http({
			method: 'GET',
			url: 'https://bushell.net/smarkets.php?meeting=' + $scope.eventTitle + '&date=' + data[0] + '&time=' + time[0] + ''
		}).then(function successCallback(response) {
			for (i = 0; i < (response.data.market || []).length; i++) {
				if (response.data.market[i]['@attributes']['slug'] == "to-win") {
					for (j = 0; j < response.data.market[i]['contract'].length; j++) {
						var rName = response.data.market[i]['contract'][j]['@attributes']['slug'];
						try {
							var rPrice = response.data.market[i]['contract'][j]['bids']['price'][0]['@attributes']['decimal']

							$("#" + rName).html(rPrice);
							//$scope.runners[l]['price'] = response.data.market[i]['contract'][j]['bids']['price'][0]['@attributes']['decimal']
						} catch (e) {
							$("#" + rName).html("N/A");
						}
					}
					$scope.totalCount();
				}
				callToIframe();
			}

		}, function errorCallback(response) {});
	}

	$scope.checkRunners = function (runnerName, data) {
		for (var i = 0, len = (data || []).length; i < len; i++) {
			if (!data[i] && data[i].markets.length) {
				var tempArray = data[i].markets[0].runners;
				for (var j = 0, len1 = tempArray.length; j < len1; j++) {
					if (runnerName === tempArray[j].name) {
						return tempArray[j].prices[0].odds;
					}
				}
			}
		}
	}

	$scope.gethierarchyByMarketType = function (runnerName, data) {
		for (var i = 0, len = (data || []).length; i < len; i++) {
			var market = data[i]['market'];
			if (market.length) {
				for (var j = 0, len1 = market.length; j < len1; j++) {
					var participant = market[j]['participant'];
					if (participant) {
						for (var z = 0, len2 = participant.length; z < len2; z++) {
							var finalData = participant[z]['@attributes']['name'];
							if(runnerName === finalData) {
								return participant[z]['@attributes']['oddsDecimal'];
							}
						}	
					}
				}
			}
		}
	}

	$scope.createUrlhierarchyByMarketType = function (runnerName, data){
		for (var i = 0, len = (data || []).length; i < len; i++) {
			var market = data[i]['market'];
			if (market.length) {
				for (var j = 0, len1 = market.length; j < len1; j++) {
					var participant = market[j]['participant'];
					if (participant) {
						for (var z = 0, len2 = participant.length; z < len2; z++) {
							var finalData = participant[z]['@attributes']['name'];
							if(runnerName === finalData) {
								var id = participant[z]['@attributes']['id'];
								var url = market[j]['@attributes']['url'];
								var finalUrl = "http://ads2.williamhill.com/redirect.aspx?pid=" + id + "&bid=0&redirectURL=" + url;
								// var finalUrl = "http://www.williamhill.com/nui/c30-open-account-page?var3=nui/c30-open-account-page/#http://sports.williamhill.com/bet/EN/addtoslip?action=BuildSlip&sel=" + id + "&price=y&ew=n&url=" + url;
								return finalUrl;
							}
						}	
					}
				}
			}
		}
	}

	$scope.getHorseRacingPrice = function (runnerName, data) {
		for (var i = 0, len = (data || []).length; i < len; i++) {
			var betArray = data[i]['bettype']['bet'];
			if (betArray.length) {
				for (var j = 0, len1 = betArray.length; j < len1; j++) {
					if (runnerName === betArray[j]['@attributes']['name']) {
						return betArray[j]['@attributes']['priceDecimal'];
					}
				}
			}
		}
	}

	$scope.getHorseRacingPriceURL = function (runnerName, data) {
		for (var i = 0, len = (data || []).length; i < len; i++) {
			var betArray = data[i]['bettype']['bet'];
			if (betArray.length) {
				for (var j = 0, len1 = betArray.length; j < len1; j++) {
					if (runnerName === betArray[j]['@attributes']['name']) {
						var id = betArray[j]['@attributes']['id'];
						var priceDecimal = betArray[j]['@attributes']['priceDecimal'];
						var url = "https://www.betfred.com/sport?oc_multiples=" + id + "|" + priceDecimal + "~" + "&affid=" + $scope.betfred_affiliate_id;
						return url;
					}
				}
			}
		}
	}

	$scope.getDecimal = function (runnerName, data) {
		var tempArray = [];
		for (var i = 0, len = data.length; i < len; i++) {
			var d = data[i]['market'][0]['contract'];
			for (var j = 0, len1 = d.length; j < len1; j++) {
				if (runnerName === d[j]['@attributes'].name) {
					if (Object.keys(d[j]['offers']).length) {
						return d[j]['offers']['price'][0]['@attributes']['decimal'];
					}
				}
			}
		}
	}

	$scope.createUrlDecimal = function (runnerName, data) {
		var tempArray = [];
		for (var i = 0, len = data.length; i < len; i++) {
			var d = data[i]['market'][0]['contract'];
			for (var j = 0, len1 = d.length; j < len1; j++) {
				if (runnerName === d[j]['@attributes'].name) {
					if (Object.keys(d[j]['offers']).length) {
						var eventId = data[i]['@attributes']['id'];
						var eventUrl = data[i]['@attributes']['url'];
						var id = d[j]['@attributes']['id'];
						var price = d[j]['offers']['price'][0]['@attributes']['decimal'];
						var finalUrl = "https://smarkets.com/event/"+eventId + eventUrl+"?cid="+id+"&price="+price+"&side=buy&stake=10.0";
						return finalUrl;
					}
				}
			}
		}
	}

	

	

	$scope.filterData = function (key) {
		$scope.currentFilter = key;
		var date = new Date();
		switch (key) {
			case 'tomorrow':

				date = date.setDate(date.getDate() + 1);
				break;
			case 'nextday':
				date = date.setDate(date.getDate() + 2);
				break;
			default:
				break;
		}
		date = $filter('date')(date, 'dd/MMM/yyyy');
		$scope.data = $filter('filter')($scope.tempData, function (item) {
			return date === $filter('date')(item.marketStartTime, 'dd/MMM/yyyy');
		});
		$scope.data = $filter('orderBy')($scope.data, 'event.countryCode');
	};

	$scope.showEvent = function () {
		$scope.runners = null;
	}

	getData();

	$scope.goToSmarkets = function () {
		window.open('https://smarkets.com/event/', '_blank');		
	}
	$scope.goToBetfair = function () {
		window.open('https://betfair.com/', '_blank');		
	}
	$scope.goToMatchbook = function () {
		window.open('https://matchbook.com/', '_blank');		
	}
	$scope.goToBetfred = function () {
		window.open('https://betfred.com/', '_blank');		
	}
	$scope.goToUnibet = function () {
		window.open('https://unibet.com/', '_blank');		
	}

	$scope.goToWilliamHill = function (index) {
		var url = $scope.hierarchyByMarketTypeURL[index];
		if (url) {
			window.open(url, '_blank');
		} else {
			window.open('https://williamhill.com/', '_blank');		
		}
	}
	$scope.horseRacingdecimalButton = function (index) {
		console.log("index", index);
		var url = $scope.horseRacingdecimalPriceURL[index];
		console.log(url);
		window.open(url, '_blank');
	}
	$scope.matchbookOddsButton = function () {
		var url = document.location.href + "?affid=" + $scope.matchbook_affiliate_id;
		window.open(url, '_blank');
	}
	$scope.greenButton = function (index) {
		var url = "https://smarkets.com/events/1121014/sport/horse-racing/wetherby/2018/12/08/13:10?affid=" + $scope.smarkets_affiliate_id;
		window.open(url, '_blank');
	}
	$scope.yelloButton = function (globalMarketId) {
		// var url = "https://www.betfair.com/exchange/plus/horse-racing/market/" + globalMarketId;
		var url = "https://www.betfair.com/exchange/plus/horse-racing/market/" + globalMarketId + "&pid=" + $scope.betfair_affiliate_id;
		window.open(url, '_blank');		
	}

});

myApp.controller('marketController', function ($scope, $http, $filter, $interval, $location) {
	setInterval(function() {

		var h = window.innerHeight;
		var w = window.innerWidth;
	  
		var iframe = document.getElementsByTagName("iframe")[0];
	  
		if(iframe) {
			iframe.style.height = h + "px";
			iframe.style.width = w + "px";
		}
	  
	  }, 100);
	localStorage.setItem('runners', '');
	$scope.is_loading = true;
	$scope.isErrorMessage = false;
	$scope.is_show_betfair = false;
	$scope.is_show_betfred = false;
	$scope.is_show_matchbook = false;
	$scope.is_show_smarkets = false;
	$scope.is_show_williamhill = false;
	
	
	$scope.marketId = $location.search();

	$scope.globalMarketId = 0;
	$scope.globalEventId = 0;
	$scope.globalDateTime = 0

	$scope.changeView = function (view) {
		$location.path(view);
	}

	$scope.getTitle = function(value) {
		$scope.runnerLength = $scope.runners.length;
		$scope.title = value[0].event.venue;
	}

	$scope.showEventDetails = function (title, value) {
		console.log(title, value);
		$scope.runners = null;
		$scope.eventTitle = title;
		$scope.events = value;
	}

	function getData() {
		$http({
			method: 'GET',
			url: 'https://bushell.net/betfair.php'
		}).then(function successCallback(response) {
			$scope.tempData = angular.copy(response.data);
			$scope.filterData('today');
			var data =	getRunngerById($scope.data);
			
			if (data) {
				$scope.showRunners(data.marketStartTime,data.marketName,data.runners,data.marketStartTime,data, data.marketId);
				$scope.runnerLength = data.runners.length;
				$scope.title = data.event.venue;
			} else {
				getEndRaceData();
			}
		

			$scope.is_loading = false;
		}, function errorCallback(response) {});
	}

	function getEndRaceData() {
		var url = 'win_nr/api.php?market_id=' + $scope.marketId.marketID;
		$http({
			method: 'GET',
			url: url
		}).then(function successCallback(response) {
			$scope.raceEndNumber = response.data.cloth_number;
			$scope.raceEndHourse = response.data.horse;
			$scope.isErrorMessage = true;
		}, function errorCallback(response) {});
	}

	function getRunngerById(data) {
		for (var i = 0 , len = data.length ; i < len ; i ++) {
			if(data[i].marketId == $scope.marketId.marketID) {
				return data[i];
				// function showRunners(marketStartTime,marketName,runners,marketStartTime, data, marketId);
				// $scope.runners = data[i];
				break;
			}
		}
	}

	function slugify(text) {
		return text.toString().toLowerCase()
			.replace(/\s+/g, '-') // Replace spaces with -
			.replace(/[^\w\-]+/g, '') // Remove all non-word chars
			.replace(/\-\-+/g, '-') // Replace multiple - with single -
			.replace(/^-+/, '') // Trim - from start of text
			.replace(/-+$/, ''); // Trim - from end of text
	}


	$scope.callEvery30Sec = function () {
		var getValue = localStorage.getItem('runners');
		if(getValue && getValue !== null) {
			var getValue = JSON.parse(getValue);
			$scope.showRunners(getValue.datetime, getValue.markertName, getValue.runners, getValue.datetime, getValue.obj, getValue.marketId);		
		}
	}

	$scope.betfair_affiliate_id = '';
	$scope.betfred_affiliate_id = '';
	$scope.matchbook_affiliate_id = '';
	$scope.smarkets_affiliate_id = '';
	$scope.unibet_affiliate_id = '';
	$scope.williamhill_affiliate_id = '';

	$scope.bookmarkData = function () {
		$http({
			method: 'GET',
			url : 'https://bushell.net/demo/wp-content/plugins/horse-exchange/app/pages/config.php?data=bookmaker_data'
		}).then(function successCallback(response) {

			$scope.betfair_affiliate_id = response.data.betfair_affiliate_id;
			$scope.betfred_affiliate_id = response.data.betfred_affiliate_id;
			$scope.matchbook_affiliate_id = response.data.matchbook_affiliate_id;
			$scope.smarkets_affiliate_id = response.data.smarkets_affiliate_id;
			$scope.unibet_affiliate_id = response.data.unibet_affiliate_id;
			$scope.williamhill_affiliate_id = response.data.williamhill_affiliate_id;

			var tempObj = response.data;
			if(tempObj.show_betfair == 1) {
				$scope.is_show_betfair = true;
			}
			if(tempObj.show_betfred == 1) {
				$scope.is_show_betfred = true;
			}
			if(tempObj.show_matchbook == 1) {
				$scope.is_show_matchbook = true;
			}
			if(tempObj.show_smarkets == 1) {
				$scope.is_show_smarkets = true;
			}
			if(tempObj.show_williamhill == 1) {
				$scope.is_show_williamhill = true;
			}

			if(tempObj.live_odds == 1) {
				setInterval(function(){
					$scope.callEvery30Sec();
				}, 30000)
			}
		}, function errorCallback(response) {});
	}
	$scope.bookmarkData();

	$scope.showRunners = function (datetime, markertName, runners, datetime, obj, marketId) {
		console.log("update");
		var tempObj = {
			'datetime' : datetime,
			'markertName' : markertName,
			'runners' : runners,
			'datetime' : datetime,
			'obj' : obj,
			'marketId' : marketId
		}
		localStorage.setItem('runners', JSON.stringify(tempObj));

		$scope.globalMarketId = obj.marketId;
		$scope.globalDateTime = datetime;

		for (j = 0; j < runners.length; j++) {
			runners[j].price = 0.0;
			runners[j].slug = slugify(runners[j]['runnerName']);
		}
		// $scope.teamData = [];
		// $http({
		// 	method: 'GET',
		// 	url: 'http://81.4.120.65/betfair/results.php'
		// }).then(function successCallback(response) {
		// 	for (var i = 0; i < response.data.length; i++) {
		// 		if (response.data[i].marketId == $scope.globalMarketId && response.data[i].dayToSearch == $scope.globalDateTime) {
		// 			$scope.teamData = response.data[i].data;
		// 			for (z = 0; z < $scope.teamData.length; z++) {
		// 				for (y = 0; y < runners.length; y++) {
		// 					if (slugify($scope.teamData[z].teamName).indexOf(runners[y].slug) > -1) {
		// 						$("#scrap-" + runners[y].slug).html($scope.teamData[z].point);
		// 					}
		// 				}
		// 			}
		// 			break;
		// 		}
		// 	}
		// });

		$scope.datetime = datetime;
		$scope.eventMarkertName = markertName;
		$scope.horseStatus = [];
		$scope.runners = runners;

		$scope.marketPrice = [];
		$http({
			url: 'feeds/betfair.php',
			method: 'POST',
			data: {
				"marketId": marketId
			}
		}).then(function successCallback(response) {
			if (response) {
				if (response.data.eventTypes.length) {
					var tempArray = response.data.eventTypes[0].eventNodes[0].marketNodes[0].runners;
					for (var i = 0, len = tempArray.length; i < len; i++) {
						var price = 0;
						var horse_status = 0;
						if (Object.keys(tempArray[i].exchange).length) {
							price = tempArray[i].exchange.availableToBack[0].price;
							horse_status = tempArray[i].state.status;
						}
						$scope.marketPrice.push(price);
						$scope.horseStatus.push(horse_status);
					}
				}
			}
		});

		$scope.matchbookOdds = [];
		$http({
			url: 'pages/matchbookData.php',
			method: 'GET'
		}).then(function successCallback(response) {
			var tempArray = response.data.events;
			for (var i = 0, len = $scope.runners.length; i < len; i++) {
				var name = $scope.runners[i].metadata.CLOTH_NUMBER_ALPHA + ' ' + $scope.runners[i].runnerName;
				name = name.split(".").join(" ");
				var newVal = $scope.checkRunners(name, tempArray);
				if (newVal) {
					$scope.matchbookOdds.push(newVal);
				} else {
					$scope.matchbookOdds.push("N/A");
				}
			}
		});


		$scope.decimalPrice = [];
		var toWinArray = [];
		$scope.greenUrl = [];
		$http({
			url: 'feeds/smarkets.php',
			method: 'GET'
		}).then(function successCallback(response) {
			if (response) {
				var data = response.data.event;
				for (var i = 0, len = data.length; i < len; i++) {
					var win = data[i].market[0];
					if (win) {
						if (win['@attributes'].slug === 'to-win') {
							toWinArray.push(data[i]);
						}
					}
				}
			}
		});
		setTimeout(function () {

			for (var i = 0, len = $scope.runners.length; i < len; i++) {
				var name = $scope.runners[i].runnerName;
				var newVal = $scope.getDecimal(name, toWinArray);

				var url = $scope.createUrlDecimal(name, toWinArray);
				if(url){
					$scope.greenUrl.push(url);
				} else {
					$scope.greenUrl.push("");
				}

				if (newVal) {
					$scope.decimalPrice.push(newVal);
				} else {
					$scope.decimalPrice.push("N/A");
				}
			}
		}, 1500);


		$scope.horseRacingdecimalPrice = [];
		$http({
			url: 'feeds/betfred.php',
			method: 'GET'
		}).then(function successCallback(response) {
			if (response) {
				var events = response.data.event || [];
				if( events.length ) {
					for(var i = 0, len = $scope.runners.length; i < len; i++) {
						var name = $scope.runners[i].runnerName;
						var newVal = $scope.getHorseRacingPrice(name, events);
						var url = $scope.getHorseRacingPriceURL(name, events);
						if (newVal) {
							$scope.horseRacingdecimalPrice.push(newVal);
							$scope.horseRacingdecimalPriceURL.push(url);
						} else {
							$scope.horseRacingdecimalPrice.push("N/A");
							$scope.horseRacingdecimalPriceURL.push('');
						}		
					}
				}				
			}
		});

		$scope.hierarchyByMarketType = [];
		$scope.hierarchyByMarketTypeURL = [];
		$http({
			url: 'feeds/williamhill.php',
			method: 'GET'
		}).then(function successCallback(response) {
			if (response) {
				var data = response.data['response']['williamhill']['class']['type'] || [];
				if( data.length ) {
					for(var i = 0, len = $scope.runners.length; i < len; i++) {
						var name = $scope.runners[i].runnerName;
						var newVal = $scope.gethierarchyByMarketType(name, data);
						var url = $scope.createUrlhierarchyByMarketType(name, data);
						if(url) {
							$scope.hierarchyByMarketTypeURL.push(url);
						}

						if (newVal) {
							$scope.hierarchyByMarketType.push(newVal);
						} else {
							$scope.hierarchyByMarketType.push("N/A");
						}		
					}
				}				
			}
		});


		stop = $interval(function () {
			for (j = 0; j < runners.length; j++) {
				runners[j].price = 0.0;
			}

			var data = datetime.split("T");
			data[1] = data[1].substring(0, data[1].length - 1);
			var time = data[1].split(".");
			$http({
				method: 'GET',
				url: 'https://bushell.net/smarkets.php?meeting=' + $scope.eventTitle + '&date=' + data[0] + '&time=' + time[0] + ''
			}).then(function successCallback(response) {
				for (i = 0; i < (response.data.market || []).length; i++) {
					if (response.data.market[i]['@attributes']['slug'] == "to-win") {
						for (j = 0; j < response.data.market[i]['contract'].length; j++) {
							var rName = response.data.market[i]['contract'][j]['@attributes']['slug'];
							try {
								var rPrice = response.data.market[i]['contract'][j]['bids']['price'][0]['@attributes']['decimal']

								$("#" + rName).html(rPrice);
								//$scope.runners[l]['price'] = response.data.market[i]['contract'][j]['bids']['price'][0]['@attributes']['decimal']
							} catch (e) {
								$("#" + rName).html("N/A");
							}
						}
					}
				}

			}, function errorCallback(response) {});
		}, 30000);

		var data = datetime.split("T");
		data[1] = data[1].substring(0, data[1].length - 1);
		var time = data[1].split(".");
		$http({
			method: 'GET',
			url: 'https://bushell.net/smarkets.php?meeting=' + $scope.eventTitle + '&date=' + data[0] + '&time=' + time[0] + ''
		}).then(function successCallback(response) {
			for (i = 0; i < (response.data.market || []).length; i++) {
				if (response.data.market[i]['@attributes']['slug'] == "to-win") {
					for (j = 0; j < response.data.market[i]['contract'].length; j++) {
						var rName = response.data.market[i]['contract'][j]['@attributes']['slug'];
						try {
							var rPrice = response.data.market[i]['contract'][j]['bids']['price'][0]['@attributes']['decimal']

							$("#" + rName).html(rPrice);
							//$scope.runners[l]['price'] = response.data.market[i]['contract'][j]['bids']['price'][0]['@attributes']['decimal']
						} catch (e) {
							$("#" + rName).html("N/A");
						}
					}
					$scope.totalCount();
				}
			}

		}, function errorCallback(response) {});
	}

	$scope.checkRunners = function (runnerName, data) {
		for (var i = 0, len = (data || []).length; i < len; i++) {
			if (!data[i] && data[i].markets.length) {
				var tempArray = data[i].markets[0].runners;
				for (var j = 0, len1 = tempArray.length; j < len1; j++) {
					if (runnerName === tempArray[j].name) {
						return tempArray[j].prices[0].odds;
					}
				}
			}
		}
	}

	$scope.gethierarchyByMarketType = function (runnerName, data) {
		for (var i = 0, len = (data || []).length; i < len; i++) {
			var market = data[i]['market'];
			if (market.length) {
				for (var j = 0, len1 = market.length; j < len1; j++) {
					var participant = market[j]['participant'];
					if (participant) {
						for (var z = 0, len2 = participant.length; z < len2; z++) {
							var finalData = participant[z]['@attributes']['name'];
							if(runnerName === finalData) {
								return participant[z]['@attributes']['oddsDecimal'];
							}
						}	
					}
				}
			}
		}
	}

	$scope.createUrlhierarchyByMarketType = function (runnerName, data){
		for (var i = 0, len = (data || []).length; i < len; i++) {
			var market = data[i]['market'];
			if (market.length) {
				for (var j = 0, len1 = market.length; j < len1; j++) {
					var participant = market[j]['participant'];
					if (participant) {
						for (var z = 0, len2 = participant.length; z < len2; z++) {
							var finalData = participant[z]['@attributes']['name'];
							if(runnerName === finalData) {
								var id = participant[z]['@attributes']['id'];
								var url = market[j]['@attributes']['url'];
								var finalUrl = "http://ads2.williamhill.com/redirect.aspx?pid" + id + "&bid=0&redirectURL=" + url;
								console.log("finalUrl", finalUrl);
								// var finalUrl = "http://www.williamhill.com/nui/c30-open-account-page?var3=nui/c30-open-account-page/#http://sports.williamhill.com/bet/EN/addtoslip?action=BuildSlip&sel=" + id + "&price=y&ew=n&url=" + url;
								return finalUrl;
							}
						}	
					}
				}
			}
		}
	}

	$scope.getHorseRacingPrice = function (runnerName, data) {
		for (var i = 0, len = (data || []).length; i < len; i++) {
			var betArray = data[i]['bettype']['bet'];
			if (betArray.length) {
				for (var j = 0, len1 = betArray.length; j < len1; j++) {
					if (runnerName === betArray[j]['@attributes']['name']) {
						return betArray[j]['@attributes']['priceDecimal'];
					}
				}
			}
		}
	}

	$scope.getHorseRacingPriceURL = function (runnerName, data) {
		for (var i = 0, len = (data || []).length; i < len; i++) {
			var betArray = data[i]['bettype']['bet'];
			if (betArray.length) {
				for (var j = 0, len1 = betArray.length; j < len1; j++) {
					if (runnerName === betArray[j]['@attributes']['name']) {
						var id = betArray[j]['@attributes']['id'];
						var priceDecimal = betArray[j]['@attributes']['priceDecimal'];
						var url = "https://www.betfred.com/sport?oc_multiples=" + id + "|" + priceDecimal + "~" + "&affid=" + $scope.betfred_affiliate_id;
						return url;
					}
				}
			}
		}
	}

	$scope.getDecimal = function (runnerName, data) {
		var tempArray = [];
		for (var i = 0, len = data.length; i < len; i++) {
			var d = data[i]['market'][0]['contract'];
			for (var j = 0, len1 = d.length; j < len1; j++) {
				if (runnerName === d[j]['@attributes'].name) {
					if (Object.keys(d[j]['offers']).length) {
						return d[j]['offers']['price'][0]['@attributes']['decimal'];
					}
				}
			}
		}
	}

	$scope.createUrlDecimal = function (runnerName, data) {
		var tempArray = [];
		for (var i = 0, len = data.length; i < len; i++) {
			var d = data[i]['market'][0]['contract'];
			for (var j = 0, len1 = d.length; j < len1; j++) {
				if (runnerName === d[j]['@attributes'].name) {
					if (Object.keys(d[j]['offers']).length) {
						var eventId = data[i]['@attributes']['id'];
						var eventUrl = data[i]['@attributes']['url'];
						var id = d[j]['@attributes']['id'];
						var price = d[j]['offers']['price'][0]['@attributes']['decimal'];
						var finalUrl = "https://smarkets.com/event/"+eventId + eventUrl+"?cid="+id+"&price="+price+"&side=buy&stake=10.0";
						return finalUrl;
					}
				}
			}
		}
	}

	

	

	$scope.filterData = function (key) {
		$scope.currentFilter = key;
		var date = new Date();
		switch (key) {
			case 'tomorrow':

				date = date.setDate(date.getDate() + 1);
				break;
			case 'nextday':
				date = date.setDate(date.getDate() + 2);
				break;
			default:
				break;
		}
		date = $filter('date')(date, 'dd/MMM/yyyy');
		$scope.data = $filter('filter')($scope.tempData, function (item) {
			return date === $filter('date')(item.marketStartTime, 'dd/MMM/yyyy');
		});
		$scope.data = $filter('orderBy')($scope.data, 'event.countryCode');
	};

	$scope.showEvent = function () {
		$scope.runners = null;
	}

	getData();

	$scope.goToSmarkets = function () {
		window.open('https://smarkets.com/event/', '_blank');		
	}
	$scope.goToBetfair = function () {
		window.open('https://betfair.com/', '_blank');		
	}
	$scope.goToMatchbook = function () {
		window.open('https://matchbook.com/', '_blank');		
	}
	$scope.goToBetfred = function () {
		window.open('https://betfred.com/', '_blank');		
	}
	$scope.goToUnibet = function () {
		window.open('https://unibet.com/', '_blank');		
	}

	$scope.goToWilliamHill = function (index) {
		var url = $scope.hierarchyByMarketTypeURL[index];
		if (url) {
			window.open(url, '_blank');
		} else {
			window.open('https://williamhill.com/', '_blank');		
		}
	}
	$scope.horseRacingdecimalButton = function (index) {
		var url = $scope.horseRacingdecimalPriceURL[index];
		window.open(url, '_blank');
	}
	$scope.matchbookOddsButton = function () {
		var url = document.location.href + "?affid=" + $scope.matchbook_affiliate_id;
		window.open(url, '_blank');
	}
	$scope.greenButton = function (index) {
		var url = "https://smarkets.com/events/1121014/sport/horse-racing/wetherby/2018/12/08/13:10?affid=" + $scope.smarkets_affiliate_id;
		window.open(url, '_blank');
	}
	$scope.yelloButton = function (index) {
		// var url = "https://www.betfair.com/exchange/plus/horse-racing/market/" + globalMarketId;
		var url = "https://www.betfair.com/exchange/plus/horse-racing/market/" + globalMarketId + "&pid=" + $scope.betfair_affiliate_id;
		window.open(url, '_blank');		
	}

});

myApp.controller('mainController', function ($scope, $http) {

});

myApp.controller('footballController', function ($scope, $http, $location) {
	setInterval(function() {

		var h = window.innerHeight;
		var w = window.innerWidth;
	  
		var iframe = document.getElementsByTagName("iframe")[0];
	  
		if(iframe) {
			iframe.style.height = h + "px";
			iframe.style.width = w + "px";
		}
	  
	  }, 100);
	$scope.is_loading = true;
	$http({
		method: 'GET',
		url: 'http://bushell.net/betfair-new-dev/football.php?feed=competitions&competition=null&eventId=null'
	}).then(function successCallback(response) {
		$scope.data = response.data;
		$scope.is_loading = false;
		$scope.runners = undefined;
		$scope.events = undefined;
	}, function errorCallback(response) {});

	$scope.changeView = function (view) {
		$location.path(view);
	}

	$scope.showEventDetails = function (id, title) {
		console.log(id, title);
		$http({
			method: 'GET',
			url: 'http://bushell.net/betfair-new-dev/football.php?feed=events&competition=' + id + '&eventId=null'
		}).then(function successCallback(response) {
			$scope.events = response.data;
			$scope.is_loading = false;
			$scope.competitionId = id;
			$scope.runners = undefined;
			$scope.eventTitle = title;
		}, function errorCallback(response) {});
	}

	$scope.showRunners = function (value) {
		$http({
			method: 'GET',
			url: 'http://bushell.net/betfair-new-dev/football.php?feed=markets&competition=null&eventId=' + value.event.id
		}).then(function successCallback(response) {
			$scope.currentEvents = value;
			$scope.runners = response.data;
			$scope.is_loading = false;
		}, function errorCallback(response) {});
	}
});

myApp.controller('contactController', function ($scope) {

});