app.controller('editAccountCtr', ['$rootScope', '$scope', '$http', '$localStorage',
	function ($rootScope, $scope, $http, $localStorage) {

		$scope.$watch('$parent.showEditAccount', function () {
			$scope.update = angular.copy($localStorage.user);
		});

		$scope.cancelEditAccount = function () {
			$scope.$parent.showEditAccount = false;
			$scope.$parent.showProducts = true;
		};

		$scope.confirmUpdateAccount = function () {
			if (!document.getElementsByClassName('invalid_cred_edit').length) {
				$http({
				    method: 'POST',
				    url: '../php/editAccount.php',
				    data: $scope.update,
				    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).
				success(function (res) {
					if (res === '1') {
						$localStorage.user = $scope.update;
						$scope.user = $scope.update;
						$scope.editAccountMsg = 'Update account successful!';
					}
				})
			}
		};


	}]
)

