<!DOCTYPE html>
<html lang="en" ng-app="kindly">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<title>Royalbeer Music Player</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/main.css">

	<script src="/bower_components/angular/angular.min.js"></script>
	<script src="/js/app.js"></script>
</head>
<body>
	<header></header>
	<main class="container">
		<h1>Royalbeer Music Player</h1>
		<div class="row">
			<div class="col-md-8" ng-controller="SearchCtrl as searchCtrl">
				<h3>Browse music</h3>
				<input type="search" class="form-control input-lg" 
							 placeholder="Search for band names" 
							 ng-model="searchCtrl.bandName" 
						   ng-model-options="{ debounce: 1000 }">
				<ul class="list-group">
					<li class="list-group-item" ng-repeat="band in searchCtrl.bands">
						<img class="img-circle list-cover-art" ng-src="{{::band.featured_images['medium-square'][0]}}"><span ng-bind="::band.title"></span>
					</li>
					<li class="list-group-item" ng-show="searchCtrl.bands.length == 0">No bands found.</li>
				</ul>
			</div>
			<div class="col-md-3 top-bands" ng-controller="TopBandCtrl as topBandCtrl">
				<h3>Top 5 bands</h3>
				<ul class="list-group">
					<li class="list-group-item" ng-repeat="band in ::topBandCtrl.topBands">
						<img class="img-circle list-cover-art" ng-src="{{::band.featured_images['small-square'][0]}}"><span ng-bind="::band.title"></span>
					</li>
				</ul>
			</div>
		</div>
	</main>
	<footer></footer>
</body>
</html>

