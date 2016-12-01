app.controller('productsCtr', ['$rootScope', '$scope', '$http', '$localStorage', '$timeout',
	function ($rootScope, $scope, $http, $localStorage, $timeout) {

		var ctr = 0;

		$scope.showAngularImage = true;
		$rootScope.currentOrders = {};
		$localStorage.previousValue = 0;

		$scope.productFilter = [
			{name: 'A-Z', filter: 'name'},
			{name: 'Z-A', filter: '-name'},
			{name: 'Best-seller', filter: '-sold'},
			{name: 'Worst-seller', filter: 'sold'},
			{name: 'Most expensive', filter: '-price'},
			{name: 'Cheapest', filter: 'price'},
			{name: 'Newest', filter: '-dateupdated'},
			{name: 'Oldest', filter: 'dateupdated'}
		];

		$scope.status = $scope.productFilter[2];
		$scope.sortType = '-sold';

		$scope.$on('showAngularImage', function () {
			$scope.showAngularImage = false;
		});

		$scope.sortProductsBy = function (filter) {
			$scope.sortType = filter.filter;
		};

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

		$scope.prepEditProduct = function (product) {
			$scope.showAngularImage = true;
			$scope.tbe = angular.copy(product);
		};

		$scope.setProductStock = function (product) {
			var stock = parseInt(product.isOutOfStock);
			console.log(stock)
			stock = stock ? 0 : 1;

			$http({
			    method: 'UPDATE',
			    url: '../php/setProductStock.php',
			    data: {id: product.id, stock: stock},
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).
			success(function (res) {
				product.isOutOfStock = stock.toString();
			});
		};

		$scope.confirmDeleteProduct = function () {
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

		$scope.confirmEditProduct = function () {
			$scope.duplicateProduct = false;

			$timeout(function () {
				if (!document.getElementsByClassName('invalid_cred_productedit').length) {

					$scope.tbe.id = parseInt($scope.tbe.id);
					$scope.tbe.serving = parseInt($scope.tbe.serving);
					$scope.tbe.price = parseInt($scope.tbe.price);
					$scope.tbe.datenow = new Date().toString();

					if (!$scope.showAngularImage) {	
						$scope.tbe.image = document.getElementById('image-preview-edit-na').src;
					}

					console.log($scope.tbe)

					$timeout(function () {
						$http({
						    method: 'POST',
						    url: '../php/updateProduct.php',
						    data: $scope.tbe,
						    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
						}).
						success(function (res) {
							if (res === '1') {
								$rootScope.$broadcast('viewProducts');
								angular.element('#editProduct').modal('hide');
							}
						});
					});
					
				}
			});
		};



	}]
)

