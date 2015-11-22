//(function (){})();
(function() { 'use strict';
	angular
		.module('kindly', ['angularSoundManager']);
})();

(function() { 'use strict';
	angular
		.module('kindly')
		.config(config);

	config.$inject = ['$locationProvider'];

	function config($locationProvider) {
		$locationProvider.html5Mode({
			enabled: true,
			requireBase: false
		});
	}
})();

(function() { 'use strict';
	angular
		.module('kindly')
		.factory('MusicAPI', MusicAPI);

	MusicAPI.$inject = ['$http'];

	function MusicAPI($http) {
		return {
			getTopBands: function () {
				return $http.get('/proxy.php?action=kindly_api_band_get_bands&order_by=plays_right_now&limit=5&context=top_chart');
			},
			searchBands: function (bandName) {
				bandName = encodeURIComponent(bandName);
				return $http.get('/proxy.php?action=kindly_api_band_get_bands&order_by=plays_right_now&order=DESC&limit=10&page=1&context=list&search=' + bandName);
			},
			getLatestBands: function () {
				return $http.get('/proxy.php?action=kindly_api_band_get_bands&order_by=id&order=DESC&limit=10&page=1&context=list');
			},
			getBandTracks: function(bandId) {
				return $http.get('/proxy.php??action=kindly_api_media_get_tracks_by_band&band=' + bandId);
			},
			getTracks: function(trackIds) {
				return $http.get('get_tracks.php?id[]=' + trackIds.join("&id[]="));
			}
		};
	}
})();

(function() { 'use strict';
	angular
		.module('kindly')
		.controller('TopBandCtrl', TopBandCtrl);

	TopBandCtrl.$inject = ['MusicAPI'];

	function TopBandCtrl(MusicAPI) {
		var vm = this;
		vm.topTracks = [];

		activate();

		function activate() {
			return getTopBands();
		}

		function getTopBands() {
			return MusicAPI.getTopBands()
				.then(function(result) {
					vm.topBands = result.data;
					return vm.topBands;
				});
		}
	}
})();

(function() { 'use strict';
	angular
		.module('kindly')
		.controller('SearchCtrl', SearchCtrl);

	SearchCtrl.$inject = ['MusicAPI', '$scope'];

	function SearchCtrl(MusicAPI, $scope) {
		var vm = this;
		vm.bands = [];
		vm.bandName = '';
		vm.toggleBandTracks = function (band) {
			if(band.tracks !== undefined && band.tracks.length > 0) {
				band.tracks = undefined;
				return;
			}
			return MusicAPI.getBandTracks(band.ID)
				.then(function(result) {
					band.tracks = result.data;
					return band.tracks;
			});
		};

		activate();

		$scope.$watch(
			function(){return vm.bandName;},
			function(newVal, oldVal) {
				if(newVal !== oldVal) {
					searchBands(newVal);
				}
		});

		function activate() {
			return getLatestBands();
		}

		function getLatestBands() {
			return MusicAPI.getLatestBands()
				.then(function (result) {
					vm.bands = result.data;
					return vm.bands;
			});
		}

		function searchBands(bandName) {
			return MusicAPI.searchBands(bandName)
				.then(function(result) {
					vm.bands = result.data;
					return vm.bands;
			});
		}
	}
})();

(function() { 'use strict';
	angular
		.module('kindly')
		.controller('PlayCtrl', PlayCtrl);

	PlayCtrl.$inject = ['MusicAPI', '$location', 'angularPlayer'];

	function PlayCtrl(MusicAPI, $location, angularPlayer) {
		var vm = this;
		vm.removeTrack = removeTrack;
		vm.addTrackToPlaylist = addTrackToPlaylist;
		vm.addAndPlayTrackPlaylist = addAndPlayTrackPlaylist;
		vm.getCurrentUrl = getCurrentUrl;

		activate();
		
		function getCurrentUrl() {
			return $location.absUrl();
		}

		function getPlaylistIds() {
			var playlistIds = $location.search().id;
			if (playlistIds === undefined) {
				return [];
			}
			return playlistIds.split(",");
		}

		function addTrackToPlaylist(track) {
			var playlistIds = getPlaylistIds();
			var index = playlistIds.indexOf(track.id.toString());
			if (index === -1) {
				playlistIds.push(track.id);
			}
			$location.search("id", playlistIds.toString());
			angularPlayer.addTrack(track);
		}

		function removeTrack(track) {
			var playlistIds = getPlaylistIds();
			var index = playlistIds.indexOf(track.id.toString());
			if (index > -1) {
				playlistIds.splice(index, 1);
			}
			$location.search("id", playlistIds.toString());
			angularPlayer.removeSong(track);
		}

		function addAndPlayTrackPlaylist(track) {
			addTrackToPlaylist(track);
			angularPlayer.playTrack(track);

		}

		function activate() { 
			var playlistIds = getPlaylistIds();

			MusicAPI.getTracks(playlistIds).then(function (result) {
				result.data.forEach(function(track) {
					angularPlayer.addTrack(track);
				});
			});
		
		}
	}
})();
