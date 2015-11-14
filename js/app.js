//(function (){})();
(function() { 'use strict';
	angular
		.module('kindly', []);
})();

(function() { 'use strict';
	angular
		.module('kindly')
		.factory('MusicAPI', MusicAPI);

	MusicAPI.$inject = ['$http'];

	function MusicAPI($http) {
		return {
			getTopBands: function () {
				return $http.get('/api.php?action=kindly_api_band_get_bands&order_by=plays_right_now&limit=5&context=top_chart');
			},
			searchBands: function (bandName) {
				bandName = encodeURIComponent(bandName);
				return $http.get('/api.php?action=kindly_api_band_get_bands&order_by=plays_right_now&order=DESC&limit=10&page=1&context=list&search=' + bandName);
			},
			getLatestBands: function () {
				return $http.get('/api.php?action=kindly_api_band_get_bands&order_by=id&order=DESC&limit=10&page=1&context=list');
			},
			getBandTracks: function(bandId) {
				return $http.get('/api.php??action=kindly_api_media_get_tracks_by_band&band=' + bandId);
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

