app.controller('ordersTableCtr', ['$rootScope', '$scope', '$http', '$localStorage', '$timeout',
	function ($rootScope, $scope, $http, $localStorage, $timeout) {


		$scope.sortType = 'timeordered';
  		$scope.sortReverse = true; 
  		$scope.missingFilter = false;
  		$scope.statuses = [
  			{name: 'All'},
  			{name: 'Active'},
  			{name: 'Completed'},
  			{name: 'Returned'}
  		];
  		$scope.status = $scope.statuses[0];

		$scope.$watch('$parent.showOrdersTable', function () {
			if ($scope.$parent.showOrdersTable) {
				$scope.receiver = $localStorage.user;
				$scope.adminOrders = $scope.receiver.isAdmin ? true : false;
				$scope.getOrders({name: 'All'});
			}
		});


		$scope.getOrders = function (status) {
			$http({
			    method: 'GET',
			    url: '../php/getOrders.php',
			    params: status,
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).
			success(function (res) {
				if (typeof res === 'object') {
					$scope.missingFilter = false;
					$scope.customerOrders = res;
					if ($scope.customerOrders.length) {
						angular.forEach($scope.customerOrders, function (order) {
							order.orders = JSON.parse(order.orders);
						});
					}
				}
				else {
					$scope.missingFilter = res;
				}
			});
		};


		$scope.sortStatusBy = function (status) {
			$scope.currentStatus = status;
			$scope.getOrders($scope.currentStatus);
			$scope.sortType = 'timeordered';
  			$scope.sortReverse = true; 
		};

		$scope.updateOrderStatus = function (id, status) {
			$http({
			    method: 'POST',
			    url: '../php/updateOrderStatus.php',
			    data: {id: id, name: status},
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).
			success(function (res) {
				if (res === '1') {
					$scope.getOrders({name: $scope.currentStatus || 'All'});
					$scope.sortType = 'timeordered';
		  			$scope.sortReverse = true; 
				}
			});
		};


	}]
)

