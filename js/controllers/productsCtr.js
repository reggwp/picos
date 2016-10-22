app.controller('productsCtr', ['$rootScope', '$scope', '$http', '$localStorage', '$timeout',
	function ($rootScope, $scope, $http, $localStorage, $timeout) {

		var ctr = 0;

		$rootScope.currentOrders = {};
		$localStorage.previousValue = 0;

		$scope.addProductToCart = function (product) {

			if (product.id !== $localStorage.previousProductId) {
				$localStorage.previousValue = 0;
			}

			$localStorage.previousProductId = product.id;

			product.standby = false;
			product.adding = true;
			product.totalPrice = product.price * product.value;

			$rootScope.currentOrders[product.name] = product;

			$timeout(function () {
				product.success = true;
				product.adding = false;
				$timeout(function () {
					product.standby = true;
					product.success = false;
					// reset
				}, 1000);
				product.inCart = $localStorage.previousValue + product.value;
				$localStorage.previousValue = $localStorage.previousValue + angular.copy(product.value);
			}, 1500);			
		};


		$scope.prepDeleteProduct = function (product, decoyIndex) {
			$scope.tbd = product;
			$scope.decoyIndex = decoyIndex;
		};

		$scope.confirmDeleteProduct = function () {
			$scope.deleteMsg = null;
			$http({
			    method: 'DELETE',
			    url: '../php/deleteProduct.php',
			    params: {id: $scope.tbd.id, name: $scope.tbd.name},
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).
			success(function (res) {
				if (res === '1') {
					$scope.products.splice($scope.decoyIndex, 1);
					angular.element('#deleteProduct').modal('hide');
				}
				else {
					$scope.deleteMsg = 'Something went wrong. Please try again later.';
					$timeout(function () {
						angular.element('#deleteProduct').modal('hide');		
					}, 1500);
				}
			})
		};



	}]
)

