app.controller('reservationsCtr', ['$rootScope', '$scope', '$http', '$localStorage', '$timeout',
	function ($rootScope, $scope, $http, $localStorage, $timeout) {

		$scope.$watch('$parent.showRequestReservation', function () {
			

			if ($scope.$parent.showRequestReservation) {
				
				localStorage.captchaValidatedReservation = false;

				$scope.savedCode = null;
				$scope.userConfirmCode = null;
				$scope.showSendEmailConfirmation = true;
				$scope.showConfirmCodeField = false;
				$scope.showConfirmReservation = false;
				$scope.invalidCode = false;

				$scope.reserver = angular.copy($localStorage.user);
				$scope.new = {};
				$scope.reservationInfo = {};
				$scope.getProducts();
				$scope.standby = true;
				$scope.occasionType = [
					{name: 'Birthday party'},
					{name: 'Meeting'},
					{name: 'Reunion'},
					{name: 'Wedding reception'},
					{name: 'Graduation party'},
					{name: 'Get-together'},
					{name: 'Just a regular breakfast/lunch/dinner out!'},
					{name: 'Others'},
				];
				$scope.occasion = $scope.occasionType[6];

			}
		});


		function timeNow () {
		  	var d = new Date(),
		     	h = (d.getHours()<10?'0':'') + d.getHours(),
		      	m = (d.getMinutes()<10?'0':'') + d.getMinutes();
	  		return h + ':' + m;
		}


		$scope.checkTime = function () {
			var dt = Date.parse('01/01/2011 ' + $scope.reservationInfo.time + ':00'),
				ct = Date.parse('01/01/2011 ' + timeNow() + ':00'),
				givenDate = new Date($scope.reservationInfo.date),
				dateNow = new Date();

			if (isNaN(dt)) {
				$scope.timeError = 'Please input the time of your arrival.';
			}
			else {
				if (givenDate === dateNow) {
					if (dt >= ct) {
						if (dt - ct >= 1800000) {
						    $scope.reservationInfo.time = $scope.reservationInfo.time;
						    $scope.timeError = null;
						}
						else {
							$scope.timeError = 'Please allow at least 30 minutes for preparation.';
						}
					}
					else {
						$scope.timeError = 'Cannot have time of arrival less than or equal to current time.';
					}
				}
				else if (givenDate > dateNow) {
					$scope.timeError = null;
				}
				else if (givenDate < dateNow) {
					$scope.timeError = 'Cannot have date of arrival less than or equal current date.';
				}
			}	
		};

		$scope.checkDate = function () {
			$scope.dateError = (new Date($scope.reservationInfo.date) < new Date()) ? 'Cannot have date of arrival less than or equal current date.' : null;
		};


		$scope.sendEmailConfirmation = function () {
			// checks if there is internet connection, if there is, use captcha, if not, disregards captcha
			var captchaPassed = navigator.onLine ? (localStorage.captchaValidatedReservation === "true") : true;
			// ======================================================================================================

			if (!document.getElementsByClassName('invalid_cred_reservation').length && captchaPassed) {
				$scope.sendingEmail = true;
				var code = Math.floor(Math.random()*90000) + 10000;
				$scope.savedCode = code;
				$scope.reservationInfo.code = code;

				$http({
				    method: 'POST',
				    url: '../php/emailer.php',
				    data: {
				    	code: code,
				    	email: $scope.reserver.email,
				    },
				    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).
				success(function (res) {
					if (res === 'Message has been sent') {
						$scope.showConfirmCodeField = true;
						$scope.showSendEmailConfirmation = false;
					}
					else {
						$scope.emailSendFailMsg = 'Oops! Something went wrong! Please try again later.';
					}
					$scope.sendingEmail = false;
				});
			}
			else {
				alert();
				$scope.checkTime();
				$scope.checkDate();
				$scope.generalConfirmMsg = 'Please fill out all the necessary information for your reservation.';
			}
		};

		$scope.confirmCode = function (code) {
			if (code === $scope.savedCode.toString()) {
				$scope.invalidCode = false;
				$scope.showConfirmCodeField = false;
				$scope.showConfirmReservation = true;
			}
			else {
				$scope.invalidCode = true;
			}
		};


		$scope.confirmReservation = function () {
			var products = [];
			$scope.checkTime();
			$scope.checkDate();
			$scope.reservationInfo.name = $scope.reservationInfo.ownName ? $scope.reserver.firstname + ' ' +$scope.reserver.lastname : $scope.new.name;
			$scope.reservationInfo.contact = $scope.reservationInfo.ownContact ? $scope.reserver.contact : $scope.new.contact;
			$scope.reservationInfo.occasionType = $scope.occasion.name;

			angular.forEach($scope.products, function (product) {
				products.push({
					id: product.id,
					name: product.name,
					reservedQuantity: parseInt(product.reservedQuantity)
				});
			});

			$scope.reservationInfo.products = JSON.stringify(products);
			$scope.reservationInfo.cleanProducts = products;
			$scope.reservationInfo.dateReserved = new Date();
			$scope.reservationInfo.status = 'Reserved';
			// cancelled
			// completed

			// checks if there is internet connection, if there is, use captcha, if not, disregards captcha
			$scope.reservationInfo.captchaPassed = navigator.onLine ? (localStorage.captchaValidatedReservation === "true") : true;
			// ======================================================================================================

			$timeout(function () {
				if (!document.getElementsByClassName('invalid_cred_reservation').length && $scope.reservationInfo.captchaPassed) {
					$scope.generalConfirmMsg = null;
					$scope.loading = true;
					$scope.standby = false;

					console.log($scope.reservationInfo);

					$http({
					    method: 'POST',
					    url: '../php/confirmReservation.php',
					    data: $scope.reservationInfo,
					    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					}).
					success(function (res) {
						if (res === '1') {
							$timeout(function () {
								$scope.loading = false;
								$scope.reservationMsg = 'Thank you for reserving! Please drop us a text or call when you are about to leave so we can ready everything.'
								$timeout(function () {
									$scope.reservationMsg = null;
									$scope.new = {};
									$scope.reservationInfo = {};
									$rootScope.$broadcast('viewProducts');
									// empties out the cart after confirming the order
								}, 6000);
							}, 1500);
						}
					});
				}
				else {
					$scope.checkTime();
					$scope.checkDate();
					$scope.generalConfirmMsg = 'Please fill out all the necessary information for your reservation.';
				}
			});
			
		};



		$scope.getProducts = function () {
			$http({
			    method: 'GET',
			    url: '../php/getProducts.php',
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).
			success(function (res) {
				$scope.products = res;
			});
		};



	}]
)

