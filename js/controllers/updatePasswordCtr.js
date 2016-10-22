app.controller('updatePasswordCtr', ['$rootScope', '$scope', '$http', '$localStorage', 'hashService',
	function ($rootScope, $scope, $http, $localStorage, hashService) {

		$scope.new = {
			currentPassword: null,
			newPassword: null,
			retypePassword: null
		}

		$scope.$watch('$parent.showUpdatePassword', function () {
			$scope.user = $localStorage.user;
			if ($scope.$parent.showUpdatePassword) {
				$http({
				    method: 'GET',
				    url: '../php/getPassword.php',
				    params: $scope.user,
				    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).
				success(function (res) {
					$scope.user.password = res.password;
				})
			}
		});

		$scope.confirmUpdatePassword = function () {
			if (!document.getElementsByClassName('invalid_cred').length) {
				$scope.user.newPassword = $scope.new.newPassword;
				console.log($scope.user)
				$http({
				    method: 'POST',
				    url: '../php/updatePassword.php',
				    data: $scope.user,
				    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).
				success(function (res) {
					if (res === '1') {
						$localStorage.user.password = $scope.new.newPassword;
						$scope.user.password = $scope.new.newPassword;
						$scope.changePasswordMsg = 'Update password successful!';
					}
				})
			}
			
		};

		$scope.cancelUpdatePassword = function () {
			$scope.new = {
				currentPassword: null,
				newPassword: null,
				retypePassword: null
			};
			$scope.$parent.showUpdatePassword = false;
			$scope.$parent.showProducts = true;
		};

	}]
)

