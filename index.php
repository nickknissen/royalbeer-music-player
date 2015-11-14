<!DOCTYPE html>
<html lang="en" ng-app="kindly">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<title>Royalbeer Music Player</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/main.css">

	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
	<script src="/js/app.js"></script>
</head>
<body>
	<header></header>
	<main class="container">
		<h1>Royalbeer Music Player</h1>
		<div class="row">
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

