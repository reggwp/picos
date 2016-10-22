app.controller('dashboardCtr', ['$rootScope', '$scope', '$http', '$localStorage',
	function ($rootScope, $scope, $http, $localStorage) {


		$scope.example = {};

		$scope.loginCtr = $scope.$$prevSibling;
		$scope.$watch('loginCtr.loggedIn', function () {
			$scope.user = $localStorage.user;
			if ($scope.user) {
				$scope.user.isAdmin = parseInt($scope.user.isAdmin);	
			}
		});

		$scope.$on('viewProducts', function () {
			$scope.viewProducts();
		});


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
		};

		$scope.getProducts = function () {
			$http({
			    method: 'GET',
			    url: '../php/getProducts.php',
			    data: $scope.user,
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).
			success(function (res) {
				angular.forEach(res, function (item) {
					item.standby = true;
				});
				$scope.products = res;

				if ($scope.user) {
					$scope.user.isAdmin = parseInt($scope.user.isAdmin);	
				}
			});
		};


		$scope.getProducts();
		$scope.viewProducts();

	}]
)

