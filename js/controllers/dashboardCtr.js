app.controller('dashboardCtr', ['$rootScope', '$scope', '$http', '$localStorage',
	function ($rootScope, $scope, $http, $localStorage) {


		$scope.example = {};
		$scope.products = [];
		$scope.loginCtr = $scope.$$prevSibling;
		$scope.$watch('loginCtr.loggedIn', function () {
			$scope.user = $localStorage.user;
			if ($scope.user) {
				$scope.user.isAdmin = parseInt($scope.user.isAdmin);	
			}
		});

		$scope.$on('viewProducts', function () {
			$scope.viewProducts();
			$scope.getUnviewed();
		});


		$scope.refreshAndViewProducts = function () {
			window.location.reload();
			$scope.viewProducts();
		};


		$scope.resetter = function () {
			$scope.showEditAccount = false;
			$scope.loginCtr.loggedIn = false;
			$scope.loginCtr.notification = null;
			$localStorage.user = null;
		};


		$scope.logoutUser = function () {
			$scope.resetter();
			$rootScope.$broadcast('resetLoginAndRegister');
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
					});
					$scope.products = res;
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
		};

		$scope.setOrdersToViewed = function () {
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
		};

		$scope.setReservationsToViewed = function () {
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
		};

		$scope.viewProducts();
		$scope.getUnviewed();

	}]
)

