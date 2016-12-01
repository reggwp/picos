app.controller('loginAndRegistrationCtr', ['$rootScope', '$scope', '$http', '$localStorage', '$timeout',
	function ($rootScope, $scope, $http, $localStorage, $timeout) {

		$scope.failedRegister = false;
		$scope.loggedIn = false;
		$scope.login = true;
		$scope.loginMsg = 'Login';
		$scope.user = {
			username: null,
			password: null
		};
		$scope.register = {
			username: null,
			firstname: null,
			lastname: null,
			location: null,
			contact: null,
			password: null,
			retypePassword: null,
			email: null
		};
		$scope.notifications = [
			'',
			'Record created successfully!',
			'Something went wrong! Please try again later.',
			'Record already exists. Please try another email.',
			'Record not found!',
			'Record found! Logging in...',
		];

		$scope.$on('resetLoginAndRegister', function () {
			$scope.user = {
				username: null,
				password: null
			};
			$scope.register = {
				username: null,
				firstname: null,
				lastname: null,
				location: null,
				contact: null,
				password: null,
				retypePassword: null,
				email: null
			};
			window.location.reload();
		});

		$scope.checkLoginIntegrity = function () {
			if ($localStorage.user) {
				$scope.loggedIn = true;
			}
		};


		$scope.setLogin = function (bool) {
			$scope.login = bool ? true : false;
			$scope.loginMsg = bool ? 'Login' : 'Register';
			angular.forEach($scope.user, function (item) {
				item = null;
			});
			angular.forEach($scope.register, function (item) {
				item = null;
			});
		};


		$scope.loginUser = function () {
			$scope.notification = null;
			if (!document.getElementsByClassName('invalid_cred_login').length) {
				$http({
				    method: 'POST',
				    url: '../php/login.php',
				    data: $scope.user,
				    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).
				success(function (res) {
					if (res !== '2') {

						$scope.notification = $scope.notifications[5];

						$timeout(function () {
							$scope.loggedIn = true;
							$localStorage.user = res;
							
							$rootScope.$broadcast('viewProducts');

						}, 1000);

					}
					else {
						$scope.notification = $scope.notifications[4];
					}
				});
			}
		};

		$scope.registerUser = function () {
			$scope.notification = null;
			if (!document.getElementsByClassName('invalid_cred_register').length) {
				$scope.failedRegister = false;
				$http({
				    method: 'POST',
				    url: '../php/register.php',
				    data: $scope.register,
				    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).
				success(function (res) {
					if (res === '1') {
						$scope.notification = $scope.notifications[1];
						$scope.loggedIn = true;
						$localStorage.user = $scope.register;
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
				$scope.failedRegister = true;
			}
		};


		$scope.checkLoginIntegrity();


	}]
)

