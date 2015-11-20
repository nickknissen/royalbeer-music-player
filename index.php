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
	<script src="/bower_components/angular-soundmanager2/dist/angular-soundmanager2.min.js"></script>
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
						<div class="band-info" ng-click="searchCtrl.toggleBandTracks(band)">
							<img class="img-circle list-cover-art" ng-src="{{::band.featured_images['medium-square'][0]}}"><span ng-bind="::band.title"></span>
						</div>
						<ul class="band-tracks list-group" ng-show="band.tracks">
							<li class="list-group-item" ng-repeat="track in band.tracks">
								<span ng-bind="::track.title"></span>
								<span class="track-buttons">
									<button music-player="play" add-song="track" class="btn btn-info btn-xs glyphicon glyphicon-play"></button>
									<button music-player add-song="track" class="btn btn-info btn-xs glyphicon glyphicon-plus"></button>
								</span>
							</li>
						</ul>
					</li>
					<li class="list-group-item" ng-show="searchCtrl.bands.length == 0">No bands found.</li>
				</ul>
			</div>
			<div class="col-md-3">
				<sound-manager></sound-manager>
				<h3>Play music</h3>
				<div class="btn-group btn-group-justified">
					<div class="btn-group">
						<button prev-track class="btn btn-info glyphicon glyphicon-step-backward"></button>
					</div>
					<div class="btn-group">
						<button play-pause-toggle 
							class="btn btn-info glyphicon glyphicon-play" 
							ng-class="{'glyphicon-pause': isPlaying}" 
							data-play="" 
							data-pause=""></button>
					</div>
					<div class="btn-group">
						<button next-track class="btn btn-info glyphicon glyphicon-step-forward"></button>
					</div>
				</div>
				<img ng-src="{{currentPlaying.featured_images['small-square'][0]}}" style="width: 100%"/>
				<div class="btn-group btn-group-justified" role="group" aria-label="...">
				<div class="progress">
					<div class="progress-bar" ng-style="{width : ( progress + '%' ) }"></div>
				</div>
				<ul class="band-tracks list-group">
					<li class="list-group-item" ng-repeat="track in playlist" ng-class="{'active': currentPlaying.id == track.id}" play-from-playlist="track" >
						<span ng-bind="::track.title"></span>
						<span class="track-buttons">
							<a remove-from-playlist="track" data-index="{$index}" class="btn btn-info btn-xs glyphicon glyphicon-trash"></a>
						</span>
					</li>
				</ul>
			</div>
		</div>
	</main>
	<footer></footer>
</body>
</html>

