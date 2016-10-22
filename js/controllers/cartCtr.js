app.controller('cartCtr', ['$rootScope', '$scope', '$http', '$localStorage', '$timeout',
	function ($rootScope, $scope, $http, $localStorage, $timeout) {
		
		$scope.$on('updateGrandTotal', function (){
			var totalPrices = [];
			angular.forEach($scope.orders, function (order) {
				order.totalPrice = parseInt(order.price) * order.inCart;
				totalPrices.push(order.totalPrice);
			});
			$scope.grandTotal = totalPrices.reduce(function(a, b) { return a + b; }, 0);
		});

		$scope.$watch('$parent.showCart', function (){
			if ($scope.$parent.showCart) {
				$scope.resetter();
			}
		});

		$scope.resetter = function () {
			localStorage.captchaValidated = false;
			$scope.orders = $rootScope.currentOrders;
			// $scope.orders = JSON.parse('{"Pork Adobo":{"id":"1","name":"Pork Adobo","description":"A staple of Filipino cuisine. The pork adobo is the Philippines\' national dish. Taste it and you\'ll see why.","serving":"3","price":"200","sold":"1422","image":"images/1.jpg","standby":true,"value":2,"adding":false,"totalPrice":400,"success":false,"inCart":2},"Pancit Canton":{"id":"2","name":"Pancit Canton","description":"Our best-selling noodle dish. Our pancit canton has all the great flavors you love without the preservatives. Try it and taste the difference!","serving":"3","price":"180","sold":"7526","image":"images/2.jpg","standby":true,"value":13,"adding":false,"totalPrice":2340,"success":false,"inCart":13},"Lumpiang Shanghai":{"id":"3","name":"Lumpiang Shanghai","description":"A Chinese delicacy with a Filipino twist! Enjoy our freshly fried spring rolls with our signature dipping sauce. Crunchy and yummy!","serving":"3","price":"150","sold":"556","image":"images/3.jpg","standby":true,"value":27,"adding":false,"totalPrice":4050,"success":false,"inCart":27}}');
			$scope.length = Object.keys($scope.orders).length;
			$scope.receiver = $localStorage.user;
			$scope.deliveryInformation = {
				ownName: true,
				ownContact: true,
				ownLocation: true
			};
			$scope.new = {
				name: null,
				contact: null,
				location: null,
				time: null,
				money: null
			};
			$scope.finalInfo = {
				orders: null,
				name: null,
				contact: null,
				location: null,
				desiredTime: null,
				money: null,
				grandtotal: null,
				datetimeOfOrder: null,
				status: 'Active',
				captchaPassed: false
			};
			$scope.standby = true;
			$scope.loading = false;
			$scope.orderMsg = null;
			$scope.generalConfirmMsg = null;
			$scope.timeError = null;
			$scope.moneyError = null;

			$scope.$emit('updateGrandTotal');
		};


		function timeNow () {
		  	var d = new Date(),
		     	h = (d.getHours()<10?'0':'') + d.getHours(),
		      	m = (d.getMinutes()<10?'0':'') + d.getMinutes();
	  		return h + ':' + m;
		}

		$scope.updateOrderLength = function () {
			$scope.length = Object.keys($scope.orders).length;
		};

		$scope.removeAll = function (order) {
			delete $scope.orders[order.name];
			order.inCart = 0;
			$localStorage.previousValue = 0;
			$scope.updateOrderLength();
			$scope.$emit('updateGrandTotal');
		};

		$scope.removeOne = function (order) {
			if (order.inCart > 0) {
				order.inCart -= 1;
			}
			if (!order.inCart) {
				delete $scope.orders[order.name];
				$localStorage.previousValue = 0;
				// $scope.orders.splice(1, index);
			}
			$scope.updateOrderLength();
			$scope.$emit('updateGrandTotal');
		};

		$scope.addOne = function (order) {
			if (order.inCart <= 999) {
				order.inCart += 1;
			}
			$scope.$emit('updateGrandTotal');
		};

		$scope.checkTime = function () {
			// '01/01/2011 is arbitrary its's just used for datetime conversion
			console.log($scope.new.time)
			var dt = Date.parse('01/01/2011 ' + $scope.new.time + ':00'),
				ct = Date.parse('01/01/2011 ' + timeNow() + ':00');

			if (isNaN(dt)) {
				$scope.timeError = 'Please input a desired time for delivery (Allow up to at least 30 minutes from now).';
			}
			else {
				if (dt >= ct) {
					if (dt - ct >= 1800000) {
					    $scope.finalInfo.desiredTime = $scope.new.time;
					    $scope.timeError = null;
					}
					else {
						$scope.timeError = 'Please allow at least 30 minutes for the delivery time.';
					}
				}
				else {
					$scope.timeError = 'Cannot have delivery time less than or equal to current time';
				}
			}
		};


		$scope.checkChange = function () {
			var gt = parseInt($scope.grandTotal),
				m = parseInt($scope.new.money);
			
			if (isNaN(m)) {
				$scope.moneyError = 'Please enter a larger or equal amount than the grand total price.';
			}
			else if (gt > m) {
				$scope.moneyError = 'Please enter a larger or equal amount than the grand total price.';
			}
			else if (gt <= m) {
				$scope.finalInfo.money = $scope.new.money;
				$scope.moneyError = null;
			}
		};


		$scope.confirmOrder = function () {
			$scope.checkTime();
			$scope.checkChange();

			$scope.finalInfo.orders = JSON.stringify($scope.orders);
			$scope.finalInfo.cleanOrders = $scope.orders;
			$scope.finalInfo.name = $scope.deliveryInformation.ownName ? $scope.receiver.firstname + ' ' +$scope.receiver.lastname : $scope.new.name;
			$scope.finalInfo.contact = $scope.deliveryInformation.ownContact ? $scope.receiver.contact : $scope.new.contact;
			$scope.finalInfo.location = $scope.deliveryInformation.ownLocation ? $scope.receiver.location : $scope.new.location;
			$scope.finalInfo.datetimeOfOrder = new Date();
			$scope.finalInfo.grandtotal = $scope.grandTotal.toString();
			$scope.finalInfo.referrer = $scope.receiver.email;

			// checks if there is internet connection, if there is, use captcha, if not, disregards captcha
			$scope.finalInfo.captchaPassed = navigator.onLine ? (localStorage.captchaValidated === "true") : true;
			// ======================================================================================================

			console.log($scope.finalInfo)
			console.log(document.getElementsByClassName('invalid_cred_cart'))

			if (!document.getElementsByClassName('invalid_cred_cart').length && $scope.finalInfo.captchaPassed) {

				$scope.loading = true;
				$scope.standby = false;
				$scope.generalConfirmMsg = null;
			
				$http({
				    method: 'POST',
				    url: '../php/confirmOrder.php',
				    data: $scope.finalInfo,
				    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).
				success(function (res) {
					if (res === '1') {
						$timeout(function () {
							$scope.loading = false;
							$scope.orderMsg = 'Order confirmed! Expect your delivery at around 30 minutes. (Make sure you or someone is there to pick it up)'
							$timeout(function () {
								$scope.orderMsg = null;
								$scope.resetter();
								$scope.length = 0;
								$scope.orders = {};
								$rootScope.$broadcast('viewProducts');
								// empties out the cart after confirming the order
							}, 6000);
						}, 1500);
					}
				});

			}
			else {
				$scope.generalConfirmMsg = 'Please fill out all the necessary information for your order confirmation and delivery.';
			}

		};





	}]
)

