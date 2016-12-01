app.controller('createAdminAccountCtr', ['$rootScope', '$scope', '$http', '$localStorage',
	function ($rootScope, $scope, $http, $localStorage) {

		$scope.notifications = [
			'',
			'New admin record created successfully!',
			'Something went wrong! Please try again later.',
			'Admin record already exists. Please try another email.',
			'Please provide correct and complete information'
		];

		$scope.$watch('$parent.showCreateAdminAccount', function () {
			$scope.user = $localStorage.user;
		});

		$scope.cancelCreateAdminAccount = function () {
			$scope.$parent.showCreateAdminAccount = false;
			$scope.$parent.showProducts = true;
			$scope.notification = null;
		};

		$scope.confirmCreateAdminAccount = function () {
			if (!document.getElementsByClassName('invalid_cred_newadmin').length) {
				$scope.notification = null;
				$http({
				    method: 'POST',
				    url: '../php/registerAdmin.php',
				    data: $scope.newadmin,
				    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).
				success(function (res) {
					if (res === '1') {
						$scope.notification = $scope.notifications[1];
						$scope.loggedIn = true;
						$localStorage.user = $scope.register;
						$scope.newadmin = {};
					}
					else if (res === '2') {
						$scope.notification = $scope.notifications[2];
					}
					else {
						$scope.notification = $scope.notifications[3];	
					}
				})
			}
			else {
				$scope.notification = $scope.notifications[4];
			}
		};

	}]
)

