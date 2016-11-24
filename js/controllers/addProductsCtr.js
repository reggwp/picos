app.controller('addProductsCtr', ['$rootScope', '$scope', '$http', '$localStorage', '$timeout',
	function ($rootScope, $scope, $http, $localStorage, $timeout) {

		$scope.$watch('$parent.showAddProducts', function () {
			if ($scope.$parent.showAddProducts) {
				$scope.newProducts = [{
					name: null,
					description: null,
					serving: null,
					price: null,
					image: null,
					sold: 0,
					standby: true
				}];
				$scope.disableSubmitAll = false;
			}
		});


		$scope.$on('passImage', function (event, data, where) {
			document.getElementById(where === '' ? 'image-preview-edit-na' : 'image-preview-' + where).src = data;	
		});


		$scope.addAnotherRow = function () {
			$scope.newProducts.push({
				name: null,
				description: null,
				serving: null,
				price: null,
				image: null,
				sold: 0,
				standby: true
			});
		};

		$scope.saveRow = function (row, index) {
			$timeout(function () {
				if (!document.getElementsByClassName('invalid_cred_newProduct').length) {
					$scope.disableSubmitAll = true;
					row.loading = true;
					row.standby = false;
					row.image = document.getElementById('image-preview-' + index).src;
					row.dateupdated = new Date();
					$http({
					    method: 'POST',
					    url: '../php/addProduct.php',
					    data: row,
					    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					}).
					success(function (res) {
						if (res === '3') {
							$timeout(function () {
								row.standby = false;
								row.loading = false;
								row.duplicate = true;
								$scope.saveMsg = "Product name already exists. Choose another name.";
							}, 1000);
						}
						else if (res === '1') {
							$timeout(function () {
								row.standby = false;
								row.loading = false;
								row.inserted = true;
								$scope.saveMsg = "Product has been added.";
							}, 1000);
						}
					})
				}
			});
		};

		$scope.goBack = function (row, flag) {
			$scope.disableSubmitAll = false;
			row[flag ? 'duplicate' : 'inserted'] = false;
			row.name = null;
			row.description = null;
			row.serving = null;
			row.price = null;
			row.image = null;
			row.sold = 0;
			row.standby = true;
		};

		$scope.submitAllRows = function () {
			if (!document.getElementsByClassName('invalid_cred_newProduct').length) {
				angular.forEach($scope.newProducts, function (row, index) {
					$scope.saveRow(row, index);
				});
			}
		};

		$scope.removeAllRows = function () {
			$scope.newProducts = [];
		};

		$scope.clearAllRows = function () {
			angular.forEach(document.getElementsByClassName('preview-image'), function (item) {
				item.src = '';
			});
			angular.forEach($scope.newProducts, function (newProduct) {
				newProduct.name = null;
				newProduct.description = null;
				newProduct.serving = null;
				newProduct.price = null;
				newProduct.image = null;
				newProduct.sold = 0;
				newProduct.standby = true;
			});
		};

		$scope.clearRow = function (row, index) {
			document.getElementById('image-preview-' + index).src = '';
			row.name = null;
			row.description = null;
			row.serving = null;
			row.price = null;
			row.image = null;
			row.sold = 0;
			row.standby = true;
		};

		$scope.removeRow = function (index) {
			$scope.newProducts.splice(index, 1);
		};

	}]
)

