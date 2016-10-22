app.controller('sendFeedbackCtr', ['$rootScope', '$scope', '$http', '$localStorage', '$timeout',
	function ($rootScope, $scope, $http, $localStorage, $timeout) {


		$scope.sortType = 'time';
  		$scope.sortReverse = true; 

		$scope.$watch('$parent.showFeedback', function () {
			if ($scope.$parent.showFeedback) {
				$scope.respondent = $localStorage.user;
				$scope.standby = true;
				$scope.feedbackSent = false;
				$scope.feedback = null;
				$scope.getFeedbacks();
			}
		});


		$scope.getFeedbacks = function () {
			$http({
			    method: 'GET',
			    url: '../php/getFeedbacks.php',
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).
			success(function (res) {
				$scope.feedbacks = res;
				angular.forEach($scope.feedbacks, function (feedback) {
					feedback.time = new Date(feedback.time);
				});
			});
		};


		$scope.sendFeedback = function () {
			// console.log($scope.$parent.feedback)
			console.log($scope.feedback)
			if (!document.getElementsByClassName('invalid_cred_feedback').length) {
				$scope.standby = false;
				var data = {
					username: $localStorage.user.username,
					content: $scope.feedback
				};

				console.log(data)

				$http({
				    method: 'POST',
				    url: '../php/sendFeedback.php',
				    data: data,
				    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).
				success(function (res) {
					if (res === '1') {
						$timeout(function() {
							$scope.feedbackSent = true;
							$scope.standby = true;
							$timeout(function() {
								$scope.feedbackSent = false;
							}, 1500);
						}, 1000);

					}
				});
			}
		};

		$scope.cancelViewFeedback = function () {
			// $scope.feedback = null;
			$scope.$parent.showFeedback = false;
			$scope.$parent.showProducts = true;
		};



	}]
)

