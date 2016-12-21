app.controller('dashboardCtr', ['$rootScope', '$scope', '$http', '$localStorage', '$timeout',
	function ($rootScope, $scope, $http, $localStorage, $timeout) {

		$scope.registration = false;
		$scope.login = false;
		$scope.loggedIn = false;
		$scope.loggingIn = false;
		$scope.registering = false;
		$scope.loggedIn = false;
		$scope.showProducts = true;

		$scope.example = {};
		$scope.products = [];
		$scope.loginCtr = $scope.$$prevSibling;

		$scope.clearCreds = function () {
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
			$scope.loggingIn = false;
			$scope.registering = false;
		};
		$scope.clearCreds();

		$scope.notifications = [
			'',
			'Record created successfully!',
			'Something went wrong! Please try again later.',
			'Record already exists. Please try another email.',
			'Record not found!',
			'Record found! Logging in...',
		];


		$scope.$on('viewProducts', function () {
			$scope.viewProducts();
			$scope.getUnviewed();
		});


		if (!$localStorage.user) {
			$scope.loggedIn = false;
		}
		else {
			$scope.loggedIn = true;
			$scope.user = $localStorage.user;
		}



		$scope.logoutUser = function () {
			$scope.loggedIn = false;
			$localStorage.user = null;
			$scope.user = null;
			document.getElementById('user-dropdown').style.display = "none";
			window.location.reload();
		};


		$scope.refreshAndViewProducts = function () {
			$scope.viewProducts();
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
						$scope.registering = true;
						$scope.notification = $scope.notifications[1];
						$localStorage.user = $scope.register;

						$timeout(function () {
							$scope.loginUserAndGiveControl();
						}, 1000);

					}
					else if (res === '2') {
						$scope.notification = $scope.notifications[2];
						$scope.registering = false;
					}
					else {
						$scope.notification = $scope.notifications[3];
						$scope.registering = false;	
					}
				})
			}
			else {
				$scope.failedRegister = true;
				$scope.registering = false;
			}
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
						$scope.loggingIn = true;
						$scope.notification = $scope.notifications[5];

						$timeout(function () {
							$scope.loginUserAndGiveControl(res);
						}, 1000);

					}
					else {
						$scope.notification = $scope.notifications[4];
						$scope.loggingIn = false;
					}
				});
			}
		};


		$scope.loginUserAndGiveControl = function (user) {
			if (user) {
				user.isAdmin = parseInt(user.isAdmin);
				$scope.user = user;
				$localStorage.user = user;
			}
			else {
				$localStorage.user.isAdmin = parseInt($localStorage.user.isAdmin);
				$scope.user = $localStorage.user;
			}
			
			$scope.showProducts = true;
			$scope.loggedIn = true;
			
			$scope.registration = false
			$scope.login = false;
			$scope.showUpdatePassword = false;
			$scope.showEditAccount = false;
			$scope.showCreateAdminAccount = false;
			$scope.showCart = false;
			$scope.showAddProducts = false;
			$scope.showFeedback = false;
			$scope.showOrdersTable = false;
			$scope.showRequestReservation = false;
			$scope.showReservationsTable = false;
		};


		$scope.openRegister = function () {
			$scope.registration = true;
			$scope.login = false;
			$scope.showProducts = false;
			$scope.showUpdatePassword = false;
			$scope.showEditAccount = false;
			$scope.showCreateAdminAccount = false;
			$scope.showCart = false;
			$scope.showAddProducts = false;
			$scope.showFeedback = false;
			$scope.showOrdersTable = false;
			$scope.showRequestReservation = false;
			$scope.showReservationsTable = false;
			$scope.clearCreds();
		};

		$scope.openLogin = function () {
			$scope.login = true;
			$scope.registration = false
			$scope.showProducts = false;
			$scope.showUpdatePassword = false;
			$scope.showEditAccount = false;
			$scope.showCreateAdminAccount = false;
			$scope.showCart = false;
			$scope.showAddProducts = false;
			$scope.showFeedback = false;
			$scope.showOrdersTable = false;
			$scope.showRequestReservation = false;
			$scope.showReservationsTable = false;
			$scope.clearCreds();
		};
		

		$scope.setEditAccount = function () {
			$scope.showUpdatePassword = false;
			$scope.showEditAccount = true;
			$scope.showCreateAdminAccount = false;
			$scope.showProducts = false;
			$scope.showCart = false;
			$scope.showAddProducts = false;
			$scope.showFeedback = false;
			$scope.showOrdersTable = false;
			$scope.showRequestReservation = false;
			$scope.showReservationsTable = false;
			$scope.registration = false;
			$scope.login = false;
		};

		$scope.setUpdatePassword = function () {
			$scope.showUpdatePassword = true;
			$scope.showEditAccount = false;
			$scope.showCreateAdminAccount = false;
			$scope.showProducts = false;
			$scope.showCart = false;
			$scope.showAddProducts = false;
			$scope.showFeedback = false;
			$scope.showOrdersTable = false;
			$scope.showRequestReservation = false;
			$scope.showReservationsTable = false;
			$scope.registration = false;
			$scope.login = false;
		};

		$scope.setNewAdminAccount = function () {
			$scope.showUpdatePassword = false;
			$scope.showEditAccount = false;
			$scope.showCreateAdminAccount = true;
			$scope.showProducts = false;
			$scope.showCart = false;
			$scope.showAddProducts = false;
			$scope.showFeedback = false;
			$scope.showOrdersTable = false;
			$scope.showRequestReservation = false;
			$scope.showReservationsTable = false;
			$scope.registration = false;
			$scope.login = false;
		};

		$scope.viewProducts = function () {
			$scope.showUpdatePassword = false;
			$scope.showEditAccount = false;
			$scope.showCreateAdminAccount = false;
			$scope.showProducts = true;
			$scope.showCart = false;
			$scope.showAddProducts = false;
			$scope.showFeedback = false;
			$scope.showOrdersTable = false;
			$scope.showRequestReservation = false;
			$scope.showReservationsTable = false;
			$scope.registration = false;
			$scope.login = false;
			$scope.getProducts();
		};

		$scope.viewCart = function () {
			$scope.showUpdatePassword = false;
			$scope.showEditAccount = false;
			$scope.showCreateAdminAccount = false;
			$scope.showProducts = false;
			$scope.showCart = true;
			$scope.showAddProducts = false;
			$scope.showFeedback = false;
			$scope.showOrdersTable = false;
			$scope.showRequestReservation = false;
			$scope.showReservationsTable = false;
			$scope.registration = false;
			$scope.login = false;
		};

		$scope.addNewProducts = function () {
			$scope.showUpdatePassword = false;
			$scope.showEditAccount = false;
			$scope.showCreateAdminAccount = false;
			$scope.showProducts = false;
			$scope.showCart = false;
			$scope.showAddProducts = true;
			$scope.showFeedback = false;
			$scope.showOrdersTable = false;
			$scope.showRequestReservation = false;
			$scope.showReservationsTable = false;
			$scope.registration = false;
			$scope.login = false;
		};

		$scope.viewSendFeedback = function () {
			$scope.showUpdatePassword = false;
			$scope.showEditAccount = false;
			$scope.showCreateAdminAccount = false;
			$scope.showProducts = false;
			$scope.showCart = false;
			$scope.showAddProducts = false;
			$scope.showFeedback = true;
			$scope.showOrdersTable = false;
			$scope.showRequestReservation = false;
			$scope.showReservationsTable = false;
			$scope.registration = false;
			$scope.login = false;
			$scope.setFeedbacksToViewed();
		};

		$scope.viewOrdersTable = function () {
			$scope.showUpdatePassword = false;
			$scope.showEditAccount = false;
			$scope.showCreateAdminAccount = false;
			$scope.showProducts = false;
			$scope.showCart = false;
			$scope.showAddProducts = false;
			$scope.showFeedback = false;
			$scope.showOrdersTable = true;
			$scope.showRequestReservation = false;
			$scope.showReservationsTable = false;
			$scope.registration = false;
			$scope.login = false;
			$scope.setOrdersToViewed();
		};

		$scope.viewRequestReservation = function () {
			$scope.showUpdatePassword = false;
			$scope.showEditAccount = false;
			$scope.showCreateAdminAccount = false;
			$scope.showProducts = false;
			$scope.showCart = false;
			$scope.showAddProducts = false;
			$scope.showFeedback = false;
			$scope.showOrdersTable = false;
			$scope.showRequestReservation = true;
			$scope.showReservationsTable = false;
			$scope.registration = false;
			$scope.login = false;
		};

		$scope.viewReservationsTable = function () {
			$scope.showUpdatePassword = false;
			$scope.showEditAccount = false;
			$scope.showCreateAdminAccount = false;
			$scope.showProducts = false;
			$scope.showCart = false;
			$scope.showAddProducts = false;
			$scope.showFeedback = false;
			$scope.showOrdersTable = false;
			$scope.showRequestReservation = false;
			$scope.showReservationsTable = true;
			$scope.registration = false;
			$scope.login = false;
			$scope.setReservationsToViewed();
		};

		$scope.getProducts = function () {
			$scope.productsDetected = true;

			$http({
			    method: 'GET',
			    url: '../php/getProducts.php',
			    data: $scope.user,
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).
			success(function (res) {
				if (res.length) {
					angular.forEach(res, function (item) {
						item.standby = true;
						// delete item.image;
					});
					$scope.products = res;
					console.log($scope.products)
				}
				else {
					$scope.productsDetected = false;
					$scope.products = [];
				}

				if ($scope.user) {
					$scope.user.isAdmin = parseInt($scope.user.isAdmin);	
				}
			});
		};

		$scope.getUnviewed = function () {
			$http({
			    method: 'GET',
			    url: '../php/getUnviewed.php',
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).
			success(function (res) {
				if (typeof res === 'object') {
					$scope.notifications = res;
				}
				console.log($scope.notifications);
			});
		};

		$scope.setFeedbacksToViewed = function () {
			if ($scope.user.isAdmin) {
				$http({
				    method: 'GET',
				    url: '../php/setFeedbacksToViewed.php',
				    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).
				success(function (res) {
					if (res === '1') {
						$scope.notifications.feedbacks = [];
					}
				});
			}
		};

		$scope.setOrdersToViewed = function () {
			if ($scope.user.isAdmin) {
				$http({
				    method: 'GET',
				    url: '../php/setOrdersToViewed.php',
				    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).
				success(function (res) {
					if (res === '1') {
						$scope.notifications.orders = [];
					}
				});
			}
		};

		$scope.setReservationsToViewed = function () {
			if ($scope.user.isAdmin) {
				$http({
				    method: 'GET',
				    url: '../php/setReservationsToViewed.php',
				    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).
				success(function (res) {
					if (res === '1') {
						$scope.notifications.reservations = [];
					}
				});
			}
		};

		// $scope.viewProducts();
		$scope.getProducts();
		$scope.getUnviewed();

	}]
)

