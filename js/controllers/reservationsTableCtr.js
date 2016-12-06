app.controller('reservationsTableCtr', ['$rootScope', '$scope', '$http', '$localStorage', '$timeout',
	function ($rootScope, $scope, $http, $localStorage, $timeout) {

		$scope.$watch('$parent.showReservationsTable', function () {
			if ($scope.$parent.showReservationsTable) {
				$scope.user = angular.copy($localStorage.user);
				$scope.statuses = [
		  			{name: 'All'},
		  			{name: 'Reserved'},
		  			{name: 'Completed'},
		  			{name: 'Cancelled'}
		  		];
		  		$scope.status = $scope.statuses[0];
		  		$scope.sortType = 'datereserved';
  				$scope.sortReverse = true; 
				$scope.getReservations({name: 'All'});
				console.log($scope.user)
			}
		});

		$scope.getReservations = function (status) {
			var user = $scope.user;
			user.status = status;

			$http({
			    method: 'POST',
			    data: user,
			    url: '../php/getReservations.php',
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).
			success(function (res) {
				if (typeof res === 'object') {
					$scope.reservations = res;
					angular.forEach($scope.reservations, function (res) {
						res.food = JSON.parse(res.food);
						res.arrivaltime = $scope.tConvert(res.arrivaltime);
					});
				}
				else {
					$scope.reservations = [];
					$scope.filterMsg = res;
				}
			});
		};

		$scope.tConvert = function (time) {
		  // Check correct time format and split into components
			time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

			if (time.length > 1) { // If time format correct
			    time = time.slice (1);  // Remove full string match value
			    time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
			    time[0] = +time[0] % 12 || 12; // Adjust hours
			}
		  	return time.join (''); // return adjusted time or original string
		};

		$scope.updateReservationStatus = function (id, status) {
			$http({
			    method: 'POST',
			    url: '../php/updateReservationStatus.php',
			    data: {id: id, name: status},
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).
			success(function (res) {
				if (res === '1') {
					$scope.getReservations();
				}
			});
		};

		$scope.sortStatusBy = function (status) {
			$scope.currentStatus = status;
			$scope.getReservations($scope.currentStatus);
			$scope.sortType = 'datereserved';
  			$scope.sortReverse = true; 
		};



	}]
)

