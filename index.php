<!DOCTYPE html>
<html ng-app="picossystem">
<head>
	<title>Picos Restobar</title>

	<!-- SCRIPTS -->
	<script type="text/javascript" src="resources/jquery.js"></script>
	<script type="text/javascript" src="resources/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="resources/angular/angular.min.js"></script>
	<script type="text/javascript" src="resources/ngStorage/ngStorage.min.js"></script>
	<script type="text/javascript" src="js/app.js"></script>

	<!-- CONTROLLERS -->
	<script type="text/javascript" src="js/controllers/mainCtr.js"></script>
	<script type="text/javascript" src="js/controllers/loginAndRegistrationCtr.js"></script>
	<script type="text/javascript" src="js/controllers/dashboardCtr.js"></script>
	<script type="text/javascript" src="js/controllers/productsCtr.js"></script>
	<script type="text/javascript" src="js/controllers/cartCtr.js"></script>
	<script type="text/javascript" src="js/controllers/editAccountCtr.js"></script>
	<script type="text/javascript" src="js/controllers/updatePasswordCtr.js"></script>
	<script type="text/javascript" src="js/controllers/createAdminAccountCtr.js"></script>
	<script type="text/javascript" src="js/controllers/addProductsCtr.js"></script>
	<script type="text/javascript" src="js/controllers/sendFeedbackCtr.js"></script>
	<script type="text/javascript" src="js/controllers/ordersTableCtr.js"></script>
	<script type="text/javascript" src="js/controllers/reservationsCtr.js"></script>

	<!-- SERVICES -->
	<script type="text/javascript" src="js/services/hashService.js"></script>

	<!-- DIRECTIVES -->
	<script type="text/javascript" src="js/directives/fileread.js"></script>

	<!-- FILTERS -->
	<script type="text/javascript" src="js/filters/convert24hourTo12hour.js"></script>

	<!-- STYLESHEETS -->
	<link rel="stylesheet" type="text/css" href="resources/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="resources/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/navbar.css">
	<link rel="stylesheet" type="text/css" href="css/loginAndRegister.css">
	<link rel="stylesheet" type="text/css" href="css/editAccount.css">
	<link rel="stylesheet" type="text/css" href="css/updatePassword.css">
	<link rel="stylesheet" type="text/css" href="css/createAdminAccount.css">
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	<link rel="stylesheet" type="text/css" href="css/cart.css">
	<link rel="stylesheet" type="text/css" href="css/addProducts.css">
	<link rel="stylesheet" type="text/css" href="css/sendFeedback.css">
	<link rel="stylesheet" type="text/css" href="css/ordersTable.css">
	<link rel="stylesheet" type="text/css" href="css/reservations.css">

	<script src="https://www.google.com/recaptcha/api.js?onload=prepCaptcha&render=explicit"></script>

	<script type="text/javascript">
		// 6LeN5AkUAAAAAENsf9jW48i6l5NR4fKj9NDa2OeB
		var cartCaptcha,
			reservationCaptcha;

		function callback () {
			localStorage.captchaValidated = true;
			console.log(localStorage)
		}

		function expiredCallback () {
			localStorage.captchaValidated = false;
			console.log(localStorage)
		}

		function callbackReservation () {
			localStorage.captchaValidatedReservation = true;
			console.log(localStorage)
		}

		function expiredCallbackReservation () {
			localStorage.captchaValidatedReservation = false;
			console.log(localStorage)
		}

		function prepCaptcha() {
			cartCaptcha = grecaptcha.render('RecaptchaField1', {
	          'sitekey' : '6LeN5AkUAAAAAENsf9jW48i6l5NR4fKj9NDa2OeB',
	          'callback': callback,
	          'expired-callback': expiredCallback
	        });
	        reservationCaptcha = grecaptcha.render('RecaptchaField2', {
	          'sitekey' : '6LeN5AkUAAAAAENsf9jW48i6l5NR4fKj9NDa2OeB',
	          'callback': callbackReservation,
	          'expired-callback': expiredCallbackReservation
	        });

		}
  	</script>

</head>
<body>

	<!-- LOGIN AND REGISTRATION AREA -->
	<div ng-cloak ng-show="!loggedIn" ng-controller="loginAndRegistrationCtr">
		<center>
			<div ng-cloak ng-if="login">
				<div class="row">
					<div class="col-sm-4">&nbsp;</div>
					<div class="col-sm-4">
						<div class="login">
							<h3>Login</h3>
							<span ng-cloak ng-if="notification" style="font-weight: bold;">{{notification}}<br/><br/></span>
							<input ng-class="{'invalid_cred_login' : !user.username}" type="text" placeholder="Username" class="form-control mb-5" ng-model="user.username">
							<input ng-class="{'invalid_cred_login' : !user.password}" type="password" placeholder="Password" class="form-control mb-30" ng-model="user.password">
							<button ng-click="loginUser()" class="form-control btn btn-primary mb-5">Login</button>
							<a href="" ng-click="setLogin(false)">Go to sign-up</a>
						</div>
					</div>
					<div class="col-sm-4">&nbsp;</div>
				</div>
			</div>
			<div ng-cloak ng-if="!login">
				<div class="row">
					<div class="col-sm-4">&nbsp;</div>
					<div class="col-sm-4">
						<div class="register">
							<h3>Register</h3>
							<span ng-cloak ng-if="notification" style="font-weight: bold;">{{notification}}<br/><br/></span>
							<input ng-class="{'invalid_cred_register' : !register.username}" type="text" placeholder="Set new username" class="form-control mb-5" ng-model="register.username">
							<input type="text" placeholder="Set new first name" class="form-control mb-5" ng-model="register.firstname">
							<input type="text" placeholder="Set new last name" class="form-control mb-5" ng-model="register.lastname">
							<input type="text" placeholder="Set new location" class="form-control mb-5" ng-model="register.location">
							<input type="text" placeholder="Set new contact number" maxlength="11" class="form-control mb-5" onkeypress='return event.charCode >= 48 && event.charCode <= 57' ng-model="register.contact"></input>
							<input ng-class="{'invalid_cred_register' : !register.password || register.password !== register.retypePassword}" type="password" placeholder="Set new password" class="form-control mb-5" ng-model="register.password">
							<input ng-class="{'invalid_cred_register' : !register.retypePassword || register.password !== register.retypePassword}" type="password" placeholder="Retype password" class="form-control mb-5" ng-model="register.retypePassword">
							<input ng-class="{'invalid_cred_register' : !register.email}" type="email" placeholder="Set new Email" class="form-control mb-30" ng-model="register.email">
							<button ng-click="registerUser()" class="form-control btn btn-primary mb-5">Register</button>
							<a href="" ng-click="setLogin(true)">Back to login</a>
						</div>
					</div>
					<div class="col-sm-4">&nbsp;</div>
				</div>
			</div>
		</center>
	</div>

	<!-- DASHBOARD AREA -->
	<div class="dashboard" ng-cloak ng-show="$$prevSibling.loggedIn" ng-controller="dashboardCtr">


		<!-- NAVBAR -->
		<div class="picos_navbar">
			<nav class="navbar navbar-default">
			  <div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			      <a class="navbar-brand" href="" ng-click="viewProducts()">Pico's Restobar</a>
			      <a ng-cloak ng-if="!user.isAdmin" class="btn btn-success btn-sm view_cart_btn" href="#" class="" ng-click="viewCart()"><i class="fa fa-shopping-cart"></i> View cart</a>
			      <ul class="nav navbar-nav navbar-right pull-right">
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome, {{user.username}} <span class="caret"></span></a>
			          <ul class="dropdown-menu">

						<li ng-cloak ng-if="user.isAdmin"><a href="" ng-click="addNewProducts()"><i class="fa fa-plus"></i> Add new products</a></li>
						<li><a href="" ng-click="setEditAccount()"><i class="fa fa-pencil"></i> Edit account</a></li>
						<li><a href="" ng-click="setUpdatePassword()"><i class="fa fa-lock"></i> Update password</a></li>
						<li ng-cloak ng-if="user.isAdmin"><a href="" ng-click="setNewAdminAccount()"><i class="fa fa-user-secret"></i> Create new admin account</a></li>

						<li ng-cloak ng-if="!user.isAdmin"><a href="" ng-click="viewSendFeedback()"><i class="fa fa-comment"></i> Send feedback</a></li>
						<li ng-cloak ng-if="user.isAdmin"><a href="" ng-click="viewSendFeedback()"><i class="fa fa-comment"></i> View customer feedbacks</a></li>

						
						<li ng-cloak ng-if="!user.isAdmin"><a href="" ng-click="viewOrdersTable()"><i class="fa fa-list"></i> View my orders</a></li>
						<li ng-cloak ng-if="user.isAdmin"><a href="" ng-click="viewOrdersTable()"><i class="fa fa-list"></i> View customer orders</a></li>

						<li ng-cloak ng-if="!user.isAdmin"><a href="" ng-click="viewRequestReservation()"><i class="fa fa-clock-o"></i> Make a reservation</a></li>
						<li ng-cloak ng-if="!user.isAdmin"><a href="" ng-click="viewMyReservations()"><i class="fa fa-th-list"></i> View my reservations</a></li>
						<li ng-cloak ng-if="user.isAdmin"><a href="" ng-click="viewReservationsTable()"><i class="fa fa-th-list"></i> View customer reservations</a></li>


			            <li ng-cloak ng-if="!user.isAdmin" role="separator" class="divider"></li>

			            <li ng-cloak ng-if="!user.isAdmin"><a href="" ng-click="viewCart()"><i class="fa fa-shopping-cart"></i> View cart</a></li>

			            <li role="separator" class="divider"></li>

			            <li><a href="" ng-click="logoutUser()"><i class="fa fa-sign-out"></i> Logout</a></li>
			          </ul>
			        </li>
			      </ul>
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
		</div>



		<!-- ADD PRODUCTS CONTAINER -->
		<div ng-cloak ng-show="showAddProducts" ng-controller="addProductsCtr">

			<div class="row">
				<div class="col-sm-1">&nbsp;</div>
				<div class="col-sm-10">
					
					<div class="add_products">

						<div class="row">
							<div class="col-sm-6"><h3>Add new products</h3></div>
							<div class="col-sm-2 pr-5"><button ng-disabled="disableSubmitAll" ng-cloak ng-if="newProducts.length" class="btn btn-warning add_row" ng-click="clearAllRows()"><i class="fa fa-minus"></i> Clear all</button></div>
							<div class="col-sm-2 pr-5 pl-5"><button ng-disabled="disableSubmitAll" ng-cloak ng-if="newProducts.length" class="btn btn-danger add_row" ng-click="removeAllRows()"><i class="fa fa-times"></i> Remove all</button></div>
							<div class="col-sm-2 pl-5"><button ng-disabled="disableSubmitAll" class="btn btn-primary add_row" ng-click="addAnotherRow()"><i class="fa fa-plus"></i> Add row</button></div>
						</div>

						<div ng-cloak ng-if="newProducts.length" class="mt-20">
							<div class="row">
								<div class="col-sm-1 pr-5">&nbsp;</div>
								<div class="col-sm-2 pl-5 pr-5"><b>Preview image</b></div>
								<div class="col-sm-3 pl-5 pr-5"><b>Name</b></div>
								<div class="col-sm-2 pl-5 pr-5"><b>Description</b></div>
								<div class="col-sm-1 pl-5 pr-5"><b>Serving</b></div>
								<div class="col-sm-1 pl-5 pr-5"><b>Price</b></div>
								<div class="col-sm-2 pr-l">&nbsp;</div>
							</div><br/>

							<div ng-repeat="newProduct in newProducts" class="add_product_row">
								<div class="progress" ng-cloak ng-if="newProduct.loading">
									<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								    	<span class="sr-only">100% Complete</span>
								  	</div>
								</div>

								<div ng-cloak ng-if="newProduct.duplicate">
									<center><span>{{saveMsg}}</span><span> <a href="" ng-click="goBack(newProduct, true)">Go back</a></span></center>
								</div>


								<div ng-cloak ng-if="newProduct.inserted">
									<center><span>{{saveMsg}}</span><span> <a href="" ng-click="goBack(newProduct, false)">Go back</a></span></center>
								</div>

								<div class="row" ng-cloak ng-if="newProduct.standby">
									<div class="col-sm-1 pr-5">
										<label for="file-upload-{{$index}}" class="btn btn-primary btn-sm">
										    <i class="fa fa-upload"></i>
										</label>
										<input id="file-upload-{{$index}}" type="file" name="{{$index}}" fileread="vm.uploadme" />
									</div>
									<div class="col-sm-2 pl-5 pr-5"><img ng-src="" id="image-preview-{{$index}}" width="100%" height="80px;" class="preview-image"></div>
									<div class="col-sm-3 pl-5 pr-5"><input ng-class="{'invalid_cred_newProduct' : !newProduct.name}" type="text" class="form-control" ng-model="newProduct.name"></div>
									<div class="col-sm-2 pl-5 pr-5"><textarea class="form-control" ng-model="newProduct.description" rows="1"></textarea></div>
									<div class="col-sm-1 pl-5 pr-5"><input type="text" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' ng-model="newProduct.serving"></div>
									<div class="col-sm-1 pl-5 pr-5"><input ng-class="{'invalid_cred_newProduct' : !newProduct.price}" type="text" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' ng-model="newProduct.price"></div>
									<div class="col-sm-2 pl-5">
										<div class="pull-right">
											<button ng-disabled="!newProduct.name && !newProduct.price" class="btn btn-sm btn-success" ng-click="saveRow(newProduct, $index)"><i class="fa fa-check"></i></button>
											<button class="btn btn-sm btn-warning" ng-click="clearRow(newProduct, $index)"><i class="fa fa-minus"></i></button>
											<button class="btn btn-sm btn-danger" ng-click="removeRow($index)"><i class="fa fa-times"></i></button>
										</div>
									</div>
								</div>
							</div>
						</div>


						<div ng-cloak ng-if="newProducts.length" class="row mt-20">
							<div class="col-sm-9">&nbsp;</div>
							<div class="col-sm-3"><button class="btn btn-success add_row" ng-click="submitAllRows()" ng-disabled="disableSubmitAll">Submit all products</button></div>
						</div>

						<div ng-cloak ng-if="!newProducts.length"><br/><center>Click the 'Add another row' button to start adding product information.</center></div>

					</div>				

				</div>
				<div class="col-sm-1">&nbsp;</div>
			</div>

		</div>




		<!-- MAIN PRODUCT VIEW -->
		<div ng-cloak ng-show="showProducts" class="picos_products" ng-controller="productsCtr">

			<!-- EDIT PRODUCT MODAL -->
			<div class="modal fade" id="editProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Edit Product</h4>
			      </div>
			      <div class="modal-body">
			       	
				    	<div class="row">
				    		<div class="col-sm-4">
				    			<label>Image</label>
						    	<label for="file-upload-edit" class="btn btn-primary btn-sm">
								    <i class="fa fa-upload"></i> <span>Browse product image</span>
								</label>
								<input id="file-upload-edit" type="file" fileread="vm.uploadme" />
				    		</div>
				    		<div class="col-sm-5">
				    			<label>&nbsp;</label>
				    			<img ng-cloak ng-show="showAngularImage" width="100%" height="120px;" ng-src="{{tbe.image}}">
				    			<img ng-cloak ng-show="!showAngularImage" id="image-preview-edit-na" width="100%" height="120px;">
				    		</div>
				    		<div class="col-sm-3">&nbsp;</div>
				      	</div><br/>

				      	<div>
				      		<label>Name</label>
				      		<input ng-class="{'invalid_cred_productedit' : !tbe.name}" type="text" class="form-control" placeholder="Update product name" ng-model="tbe.name">
				      		<div ng-cloak ng-if="duplicateProduct" class="cr mt5">There is already a product with this name.</div>
				      	</div><br/>

				      	<div><label>Description</label><textarea class="form-control" placeholder="Update product description" ng-model="tbe.description"></textarea></div><br/>

				      	<div class="row">
				      		<div class="col-sm-6">
				      			<label>Serving</label><input ng-class="{'invalid_cred_productedit' : !tbe.serving}" type="text" class="form-control" placeholder="Update product serving" onkeypress='return event.charCode >= 48 && event.charCode <= 57' ng-model="tbe.serving">
				      		</div>
				      		<div class="col-sm-6">
				      			<label>Pricing</label><input ng-class="{'invalid_cred_productedit' : !tbe.price}" type="text" class="form-control" placeholder="Update product price" onkeypress='return event.charCode >= 48 && event.charCode <= 57' ng-model="tbe.price">
				      		</div>
				      	</div>

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			        <button type="button" class="btn btn-success" ng-click="confirmEditProduct()">Save changes</button>
			      </div>
			    </div>
			  </div>
			</div>

			<!-- DELETE PRODUCT MODAL -->
			<div class="modal fade" id="deleteProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Delete Product</h4>
			      </div>
			      <div class="modal-body">
			       	<span ng-cloak ng-if="!deleteMsg">Are you sure you want to delete the product <b>{{tbd.name}}</b>?</span>
			       	<div ng-cloak ng-if="deleteMsg" class="alert alert-danger">{{deleteMsg}}</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			        <button type="button" class="btn btn-danger" ng-click="confirmDeleteProduct()">Confirm delete</button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="jumbotron">
			  	<h1>Menu</h1>
			  	<p>Our selection of the greatest, tastiest pinoy food!</p>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<input type="text" class="form-control" placeholder="Filter by name, description, serving suggestion or price" ng-model="productInformation">
					</div>
					<div class="col-sm-4">
						<div class="row">
							<div class="col-sm-3">
								<span class="pull-right">Sort by:</span>		
							</div>
							<div class="col-sm-9">

								<select ng-options="item as item.name for item in productFilter" ng-model="status" ng-change="sortProductsBy(status)" class="form-control"></select>


							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="row">

					<div ng-cloak ng-if="!products.length">
						<center ng-cloak ng-if="productsDetected">Fetching products...</center>
						<center ng-cloak ng-if="!productsDetected">There are currently no products in the database.</center>
					</div>

					<div ng-cloak ng-if="products.length" ng-repeat="product in products | filter:productInformation | orderBy:sortType" class="col-sm-4">
						<div class="product_card">
							<img ng-src="{{product.image}}" width="100%" height="194px;">
							<div class="product_info" title="This product was updated last {{product.dateupdated | date:'fullDate'}}">
								<div>
									<span class="product_name">{{product.name}}</span>
									<span ng-cloak ng-if="product.sold >= 500" class="label label-warning label-lg">Best-seller!</span>
								</div><br/>
								<div class="product_background"><span>{{product.description}}</span></div><br/>
								<div class="product_description">
									<span ng-cloak ng-if="product.serving > 1">Serves 1 to {{product.serving | number}} persons</span>
									<span ng-cloak ng-if="product.serving === 1">Serves 1 person</span>
								</div>
								<div class="product_price">
									<span class="price">{{product.price | currency:"₱"}}</span> <span class="per_serving">/ order</span>
								</div>
								<div ng-cloak ng-if="!user.isAdmin" class="in_cart_count">
									<span ng-cloak ng-if="product.inCart" class="label label-success">Currently {{product.inCart | number}} in cart</span>
									<span ng-cloak ng-if="!product.inCart" class="label label-default">Currently 0 in cart</span>
								</div>
								<br/>

								<div ng-cloak ng-if="user.isAdmin">

									<button class="btn btn-warning" ng-click="setProductStock(product)"><i class="fa fa-exclamation-circle"></i>
										<span ng-cloak ng-if="product.isOutOfStock === '0'">Set as out of stock</span>
										<span ng-cloak ng-if="product.isOutOfStock === '1'">Set as in stock</span>
									</button>

									<button class="btn btn-primary" data-toggle="modal" data-target="#editProduct" ng-click="prepEditProduct(product)"><i class="fa fa-pencil"></i> Edit product</button>
									<button class="btn btn-danger" data-toggle="modal" data-target="#deleteProduct" ng-click="prepDeleteProduct(product, $index)"><i class="fa fa-times"></i> Delete product</button>
								</div>



								<div ng-cloak ng-if="!user.isAdmin && product.isOutOfStock === '0'">
									<div class="row">
										<div class="col-sm-6">
											<input type="number" name="input" ng-model="product.value" min="1" max="999" required class="form-control" placeholder="Quantity">
										</div>
										<div class="col-sm-6">
											<div class="total"><span>Total: </span><span class="total_price">{{product.price * product.value | currency:"₱"}}</span></div>
										</div>
									</div>
									<div class="row atc_div">
										<div class="col-sm-12">
											<button class="btn btn-primary" ng-click="addProductToCart(product)" ng-disabled="!product.value || !product.standby">
												<span><i class="fa fa-shopping-cart"></i>
													<span ng-cloak ng-if="product.adding">Adding to cart...</span>
													<span ng-cloak ng-if="product.success">Successfully added to cart!</span>
													<span ng-cloak ng-if="product.standby">Add to cart</span>
												</span>
											</button>
										</div>
									</div>
								</div>

								<div ng-cloak ng-if="!user.isAdmin && product.isOutOfStock === '1'">
									<button class="btn btn-danger w100" disabled>Currently out of stock</button>
								</div>



							</div>
						</div>
					</div>



				</div>
			</div>
		</div>





		<!-- CART -->
		<div ng-cloak ng-show="showCart" ng-controller="cartCtr">
			<div class="container">
				<div class="row">
					<div class="col-sm-1">&nbsp;</div>
					<div class="col-sm-10">
						<div ng-cloak ng-if="!length" class="cart"><center><h3>Your cart is empty. :(</h3></center></div>
						<div ng-cloak ng-show="length" class="cart">
							<table class="table table-hover">
								<thead>
									<tr>
										<td></td>
										<td><b>Items purchased</b></td>
										<td></td>
										<td><b>Quantity</b></td>
										<td></td>
										<td><b>Price per order</b></td>
										<td><b>Total price</b></td>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="order in orders">
										<td>
											<button class="btn btn-danger btn-xs" title="Remove all {{order.name}} in cart" ng-click="removeAll(order)"><i class="fa fa-times"></i></button>
										</td>
										<td ng-bind="order.name"></td>
										<td><button class="btn btn-warning btn-xs" title="Remove 1" ng-click="removeOne(order)"><i class="fa fa-minus"></i></button></td>
										<td ng-bind="order.inCart | number"></td>
										<td><button class="btn btn-success btn-xs" title="Add 1" ng-click="addOne(order)"><i class="fa fa-plus"></i></button></td>
										<td ng-bind="order.price | currency:'₱'"></td>
										<td ng-bind="order.price * order.inCart | currency:'₱'"></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td><b class="grand_total_text">Grand Total:</b></td>
										<td><span class="grand_total_value">{{grandTotal | currency:'₱'}}</span></td>
									</tr>
								</tbody>
							</table>
							<hr/>
							<div>
								<div class="row">
									<div class="col-sm-6">
										<input type="checkbox" ng-model="deliveryInformation.ownName"> Use own name</input><br/>
										<b ng-cloak ng-if="deliveryInformation.ownName">{{receiver.firstname}} {{receiver.lastname}}</b>
										<input ng-class="{'invalid_cred_cart' : !new.name}" ng-cloak ng-if="!deliveryInformation.ownName" type="text" class="form-control" ng-model="new.name">
									</div>
									<div class="col-sm-6">
										<input type="checkbox" ng-model="deliveryInformation.ownContact"> Use own contact number</input><br/>
										<b ng-cloak ng-if="deliveryInformation.ownContact">{{receiver.contact}}</b>
										<input ng-class="{'invalid_cred_cart' : !new.contact}" ng-cloak ng-if="!deliveryInformation.ownContact" type="text" class="form-control" ng-model="new.contact" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
									</div>
								</div><br/>
								<div class="row">
									<div class="col-sm-6">
										<input type="checkbox" ng-model="deliveryInformation.ownLocation"> Use own location</input><br/>
										<b ng-cloak ng-if="deliveryInformation.ownLocation">{{receiver.location}}</b>
										<input ng-class="{'invalid_cred_cart' : !new.location}" ng-cloak ng-if="!deliveryInformation.ownLocation" type="text" class="form-control" ng-model="new.location">
									</div>
									<div class="col-sm-6">
										<label for="changeFor">Desired date and time of delivery</label><br/>
										<input  ng-class="{'invalid_cred_cart' : timeError || !new.time}" id="deliveryTime" type="time" class="form-control" ng-model="new.time">
										<small class="cr" ng-cloak ng-if="timeError">{{timeError}}</small>
									</div>
								</div><br/>
								<div class="row">
									<div class="col-sm-6">
										<label for="changeFor">Bring change for</label><br/>
										<input ng-class="{'invalid_cred_cart' : moneyError}" type="text" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' ng-model="new.money">
										<small class="cr" ng-cloak ng-if="moneyError">{{moneyError}}</small>
									</div>
									<div class="col-sm-6">
										<div id="RecaptchaField1"></div>
										<!-- <div class="g-recaptcha" data-expired-callback="captchaExpire" data-callback="captchaResponse" data-sitekey="6LeN5AkUAAAAAENsf9jW48i6l5NR4fKj9NDa2OeB"></div> -->
									</div>
								</div><hr/>
								<div class="row">
									<div class="col-sm-12">

										<div ng-cloak ng-if="loading">
											<div class="progress">
												<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
											    	Submitting order... Hang on a second...
											  	</div>
											</div>
										</div>

										<div class="orderMsg" ng-cloak ng-if="orderMsg">{{orderMsg}}</div>

										<div ng-cloak ng-if="standby">
											<button class="btn btn-success btn-lg w100" ng-click="confirmOrder()">Confirm Order</button>
											<center ng-cloak ng-if="generalConfirmMsg"><br/><small class="cr">{{generalConfirmMsg}}</small></center>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-1">&nbsp;</div>
				</div>
			</div>
		</div>









		<!-- REQUEST RESERVATION -->
		<div ng-cloak ng-show="showRequestReservation" ng-controller="reservationsCtr">
			<div class="row">
				<div class="col-sm-2">&nbsp;</div>
				<div class="col-sm-8">
					<div class="reservationsTable">
						<h3>Make a reservation</h3><br/>
						<div class="row">
							<div class="col-sm-6">
								<input type="checkbox" ng-model="reservationInfo.ownName"> Use own name</input><br/>
								<b ng-cloak ng-if="reservationInfo.ownName">{{reserver.firstname}} {{reserver.lastname}}</b>
								<input ng-class="{'invalid_cred_reservation' : !new.name}" ng-cloak ng-if="!reservationInfo.ownName" type="text" class="form-control" ng-model="new.name">
							</div>
							<div class="col-sm-6">
								<input type="checkbox" ng-model="reservationInfo.ownContact"> Use own contact number</input><br/>
								<b ng-cloak ng-if="reservationInfo.ownContact">{{reserver.contact}}</b>
								<input ng-class="{'invalid_cred_reservation' : !new.contact}" ng-cloak ng-if="!reservationInfo.ownContact" type="text" class="form-control" ng-model="new.contact" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
							</div>
						</div><br/>
						<div class="row">
							<div class="col-sm-6">
								<label>Type of occasion</label>
								<select ng-options="item as item.name for item in occasionType" ng-model="occasion" class="form-control"></select>
							</div>
							<div class="col-sm-6">
								<label>Name of occasion</label>
								<input type="text" class="form-control" ng-model="reservationInfo.occasionName">
							</div>
						</div><br/>

						<div class="row">
							<div class="col-sm-6">
								<label>Number of persons</label>
								<input ng-class="{'invalid_cred_reservation' : !reservationInfo.persons}" type="text" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' ng-model="reservationInfo.persons">
								<!-- <small class="cr" ng-cloak ng-if="moneyError">{{moneyError}}</small> -->
							</div>
							<div class="col-sm-6">

								<div class="row">
									<div class="col-sm-6">
										<label for="changeFor">Date of arrival</label><br/>
										<input ng-class="{'invalid_cred_reservation' : dateError || !reservationInfo.date}" id="deliveryTime" type="date" class="form-control" ng-model="reservationInfo.date">
										<small class="cr" ng-cloak ng-if="dateError">{{dateError}}</small>
									</div>
									<div class="col-sm-6">
										<label for="changeFor">Time of arrival</label><br/>
										<input ng-class="{'invalid_cred_reservation' : timeError || !reservationInfo.time}" id="deliveryTime" type="time" class="form-control" ng-model="reservationInfo.time">
										<small class="cr" ng-cloak ng-if="timeError">{{timeError}}</small>
									</div>
								</div>

								
							</div>
						</div><br/>

						<div class="row">
							<div class="col-sm-12">
								<label>Any requests?</label>
								<textarea class="form-control" rows="4" ng-model="reservationInfo.request"></textarea>	
							</div>
						</div><br/>

						<div class="row">
							<div class="col-sm-12">
								<label>Food choices</label>
								<div class="row">
									<div ng-repeat="product in products" class="col-sm-4 mb5">
										<div class="row">
											<div class="col-sm-8">
												<span class="pull-right reservation-products">{{product.name}}</span>
											</div>
											<div class="col-sm-4">
												<input type="text" class="form-control" placeholder="pcs." onkeypress='return event.charCode >= 48 && event.charCode <= 57' ng-model="product.reservedQuantity">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div><hr/>

						<div class="row">
							<div class="col-sm-12">
								<center>
									<div id="RecaptchaField2"></div>
								</center>
							</div>
						</div><hr/>

						<div class="row">
							<div class="col-sm-12">

								<div ng-cloak ng-if="loading">
									<div class="progress">
										<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
									    	Submitting reservation... Hang on a second...
									  	</div>
									</div>
								</div>

								<div class="reservationMsg" ng-cloak ng-if="reservationMsg">{{reservationMsg}}</div>

								<div ng-cloak ng-if="standby">


									<div ng-cloak ng-if="showSendEmailConfirmation">
										<button ng-disabled="sendingEmail" class="btn btn-primary btn-lg w100" ng-click="sendEmailConfirmation()">
											<span ng-cloak ng-if="!sendingEmail">Send Email confirmation</span>
											<span ng-cloak ng-if="sendingEmail">Sending Email confirmation to {{reserver.email}}...</span>
										</button>
										<center ng-cloak ng-if="emailSendFailMsg"><br/><small class="cr">{{emailSendFailMsg}}</small></center>
									</div>
									<div ng-cloak ng-if="showConfirmCodeField">
										<div class="row">
											<div class="col-sm-3">&nbsp;</div>
											<div class="col-sm-6">
												<div class="row">
													<div class="col-sm-6">
														<input ng-class="{'invalid_cred_reservation' : userConfirmCode !== savedCode.toString()}" type="text" class="form-control" ng-model="userConfirmCode">
													</div>
													<div class="col-sm-6">
														<button class="btn btn-success w100" ng-click="confirmCode(userConfirmCode)">Confirm code</button>
													</div>
												</div>
											</div>
											<div class="col-sm-3">&nbsp;</div>
											<div ng-cloak ng-if="invalidCode" class="col-sm-12"><center><br/><small class="cr">Invalid code</small></center></div>
										</div>
									</div>
									<div ng-cloak ng-if="showConfirmReservation">
										<button class="btn btn-success btn-lg w100" ng-click="confirmReservation()">Confirm Reservation</button>
										<center ng-cloak ng-if="generalConfirmMsg"><br/><small class="cr">{{generalConfirmMsg}}</small></center>
									</div>
									
								</div>

							</div>
						</div>



					</div>
				</div>
				<div class="col-sm-2">&nbsp;</div>
			</div>
		</div>









		<!-- VIEW CUSTOMER OR ADMIN ORDERS -->
		<div ng-cloak ng-show="showOrdersTable" ng-controller="ordersTableCtr">
			<div class="row">
				<div class="col-sm-1">&nbsp;</div>
				<div class="col-sm-10">
					<div class="ordersTable">
						


						<div ng-cloak ng-if="!customerOrders.length"><center><h3>You currently have no orders. :(</h3></div>

						<div ng-cloak ng-if="customerOrders.length">
							<div class="row">
								<div class="col-sm-6">
									<h3 ng-cloak ng-if="!receiver.isAdmin">My orders</h3>
									<h3 ng-cloak ng-if="receiver.isAdmin">Customer orders</h3><br/>
								</div>
								<!-- <div ng-class="{'col-sm-6' : !receiver.isAdmin, 'col-sm-4' : receiver.isAdmin}">
									<input type="text" class="form-control" placeholder="Filter orders" ng-model="filterOrders">
								</div>
								<div ng-cloak ng-if="receiver.isAdmin" class="col-sm-2">
									<select ng-options="item as item.name for item in statuses" ng-model="status" ng-change="sortStatusBy(status)" class="form-control"></select>
								</div> -->
								<div class="col-sm-4">
									<input type="text" class="form-control" placeholder="Filter orders" ng-model="filterOrders">
								</div>
								<div class="col-sm-2">
									<select ng-options="item as item.name for item in statuses" ng-model="status" ng-change="sortStatusBy(status)" class="form-control"></select>
								</div>
							</div>
							<table class="table table-hover table-responsive">
								<thead>
									<tr>
										<td class="cp" ng-click="sortType = 'id'; sortReverse = !sortReverse">
											<b>Order ID</b>
											<span ng-show="sortType == 'id' && !sortReverse" class="fa fa-caret-down"></span>
        									<span ng-show="sortType == 'id' && sortReverse" class="fa fa-caret-up"></span>
										</td>
										<td class="cp" ng-click="sortType = 'referrer'; sortReverse = !sortReverse">
											<b>Referrer</b>
											<span ng-show="sortType == 'referrer' && !sortReverse" class="fa fa-caret-down"></span>
        									<span ng-show="sortType == 'referrer' && sortReverse" class="fa fa-caret-up"></span>
										</td>
										<td class="cp" ng-click="sortType = 'name'; sortReverse = !sortReverse">
											<b>Receiver</b>
											<span ng-show="sortType == 'name' && !sortReverse" class="fa fa-caret-down"></span>
        									<span ng-show="sortType == 'name' && sortReverse" class="fa fa-caret-up"></span>
										</td>
										<td class="cp" ng-click="sortType = 'orders'; sortReverse = !sortReverse">
											<b>Orders</b>
											<span ng-show="sortType == 'orders' && !sortReverse" class="fa fa-caret-down"></span>
        									<span ng-show="sortType == 'orders' && sortReverse" class="fa fa-caret-up"></span>
										</td>
										<td class="cp" ng-click="sortType = 'contact'; sortReverse = !sortReverse">
											<b>Contact</b>
											<span ng-show="sortType == 'contact' && !sortReverse" class="fa fa-caret-down"></span>
        									<span ng-show="sortType == 'contact' && sortReverse" class="fa fa-caret-up"></span>
										</td>
										<td class="cp" ng-click="sortType = 'location'; sortReverse = !sortReverse">
											<b>Location</b>
											<span ng-show="sortType == 'location' && !sortReverse" class="fa fa-caret-down"></span>
        									<span ng-show="sortType == 'location' && sortReverse" class="fa fa-caret-up"></span>
										</td>
										<td class="cp" ng-click="sortType = 'timedesired'; sortReverse = !sortReverse">
											<b>Delivery time</b>
											<span ng-show="sortType == 'timedesired' && !sortReverse" class="fa fa-caret-down"></span>
        									<span ng-show="sortType == 'timedesired' && sortReverse" class="fa fa-caret-up"></span>
										</td>
										<td class="cp" ng-click="sortType = 'timeordered'; sortReverse = !sortReverse">
											<b>Time ordered</b>
											<span ng-show="sortType == 'timeordered' && !sortReverse" class="fa fa-caret-down"></span>
        									<span ng-show="sortType == 'timeordered' && sortReverse" class="fa fa-caret-up"></span>
										</td>
										<td class="cp" ng-click="sortType = 'grandtotal'; sortReverse = !sortReverse">
											<b>Grand total</b>
											<span ng-show="sortType == 'grandtotal' && !sortReverse" class="fa fa-caret-down"></span>
        									<span ng-show="sortType == 'grandtotal' && sortReverse" class="fa fa-caret-up"></span>
										</td>
										<td class="cp" ng-click="sortType = 'amount'; sortReverse = !sortReverse">
											<b>Paid</b>
											<span ng-show="sortType == 'amount' && !sortReverse" class="fa fa-caret-down"></span>
        									<span ng-show="sortType == 'amount' && sortReverse" class="fa fa-caret-up"></span>
										</td>
										<td class="cp" ng-click="sortType = 'status'; sortReverse = !sortReverse">
											<b>Status</b>
											<span ng-show="sortType == 'status' && !sortReverse" class="fa fa-caret-down"></span>
        									<span ng-show="sortType == 'status' && sortReverse" class="fa fa-caret-up"></span>
										</td>
										<td ng-cloak ng-if="receiver.isAdmin">&nbsp;</td>
									</tr>
								</thead>

								<tbody ng-cloak ng-if="!receiver.isAdmin && missingFilter"><tr><td colspan="11"><center>{{missingFilter}}</center></td></tr></tbody>
								<tbody ng-cloak ng-if="!receiver.isAdmin && !missingFilter">
									<tr ng-repeat="order in customerOrders | orderBy:sortType:sortReverse | filter:filterOrders" ng-cloak ng-show="order.referrer === receiver.email">
										<td>{{order.id}}</td>
										<td>{{order.referrer}}</td>
										<td>{{order.name}}</td>
										<td><div ng-repeat="item in order.orders">{{item.name}} x {{item.inCart}}</div></td>
										<td>{{order.contact}}</td>
										<td>{{order.location}}</td>
										<td>{{order.timedesired | convert24hourTo12hour }}</td>
										<td>{{order.timeordered | date:'medium'}}</td>
										<td>{{order.grandtotal | currency:"₱"}}</td>
										<td>{{order.amount | currency:"₱"}}</td>
										<td><span class="{{order.status}}">{{order.status}}</span></td>
									</tr>
								</tbody>
								<tbody ng-cloak ng-if="receiver.isAdmin && missingFilter"><tr><td colspan="12"><center>{{missingFilter}}</center></td></tr></tbody>
								<tbody ng-cloak ng-if="receiver.isAdmin && !missingFilter">
									<tr ng-repeat="order in customerOrders | orderBy:sortType:sortReverse | filter:filterOrders">
										<td>{{order.id}}</td>
										<td>{{order.referrer}}</td>
										<td>{{order.name}}</td>
										<td><div ng-repeat="item in order.orders">{{item.name}} x {{item.inCart}}</div></td>
										<td>{{order.contact}}</td>
										<td>{{order.location}}</td>
										<td>{{order.timedesired | convert24hourTo12hour }}</td>
										<td>{{order.timeordered | date:'medium'}}</td>
										<td>{{order.grandtotal | currency:"₱"}}</td>
										<td>{{order.amount | currency:"₱"}}</td>
										<td><span class="{{order.status}}">{{order.status}}</span></td>
										<td>
											<button ng-click="updateOrderStatus(order.id, 'Completed')" ng-cloak ng-if="order.status === 'Active'" class="btn btn-sm btn-success" title="Order and delivery completed"><i class="fa fa-check"></i></button>
											<button ng-click="updateOrderStatus(order.id, 'Returned')" ng-cloak ng-if="order.status === 'Active'" class="btn btn-sm btn-danger" title="Order and delivery returned / rejected"><i class="fa fa-times"></i></button>
										</td>
									</tr>
								</tbody>

							</table>
						</div>
						


					</div>
				</div>
				<div class="col-sm-1">&nbsp;</div>
			</div>
		</div>


		<!-- EDIT ACCOUNT INFORMATION -->
		<div ng-cloak ng-show="showEditAccount" ng-controller="editAccountCtr">

			<div class="row">
				<div class="col-sm-4">&nbsp;</div>
				<div class="col-sm-4">
					<div class="editAccount">		
						<div>
							<h3>Edit Account</h3>
							<center><span>{{editAccountMsg}}</span></center><br/>
							<input class="form-control" ng-class="{'invalid_cred_edit' : !update.username}" type="text" placeholder="Edit username" ng-model="update.username"><br/>
							<input class="form-control" type="text" placeholder="Edit first name" ng-model="update.firstname"><br/>
							<input class="form-control" type="text" placeholder="Edit last name" ng-model="update.lastname"><br/>
							<input class="form-control" type="text" placeholder="Edit location" ng-model="update.location"><br/>
							<input class="form-control" type="text" placeholder="Edit contact number" onkeypress='return event.charCode >= 48 && event.charCode <= 57' ng-model="update.contact"></input><br/>
							<!-- <input ng-class="{'invalid_cred_edit' : !update.email}" type="email" placeholder="Edit Email" ng-model="update.email"><br/> -->
						</div>
						<div class="row">
							<div class="col-sm-7"><button class="btn btn-success w100" ng-click="confirmUpdateAccount()">Confirm</button></div>
							<div class="col-sm-5"><button class="btn btn-danger w100" ng-click="cancelEditAccount()">Cancel</button></div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">&nbsp;</div>
			</div>

		</div>



		<!-- UPDATE PASSWORD -->
		<div ng-cloak ng-show="showUpdatePassword" ng-controller="updatePasswordCtr">
			<div class="row">
				<div class="col-sm-4">&nbsp;</div>
				<div class="col-sm-4">
					<div class="updatePassword">
						<div>
							<h3>Update Password</h3>
							<center><span ng-cloak ng-if="changePasswordMsg">{{changePasswordMsg}}</span></center><br/>
							<input class="form-control" ng-class="{'invalid_cred_password' : new.currentPassword !== user.password}" type="password" placeholder="Current password" ng-model="new.currentPassword"><br/>
							<input class="form-control" ng-class="{'invalid_cred_password' : !new.newPassword || new.newPassword !== new.retypePassword}" type="password" placeholder="Set new password" ng-model="new.newPassword"><br/>
							<input class="form-control" ng-class="{'invalid_cred_password' : !new.retypePassword || new.newPassword !== new.retypePassword}" type="password" placeholder="Retype new password" ng-model="new.retypePassword"><br/>
						</div>
						<div class="row">
							<div class="col-sm-7"><button class="btn btn-success w100" ng-click="confirmUpdatePassword()">Confirm</button></div>
							<div class="col-sm-5"><button class="btn btn-danger w100" ng-click="cancelUpdatePassword()">Cancel</button></div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">&nbsp;</div>
			</div>
		</div>


		<!-- SET NEW ADMIN ACCOUNT -->
		<div ng-cloak ng-show="showCreateAdminAccount" ng-controller="createAdminAccountCtr">
			<div class="row">
				<div class="col-sm-4">&nbsp;</div>
				<div class="col-sm-4">
					<div class="createAdminAccount">
						<div>
							<h3>Create new admin account</h3>
							<center class="cg"><span>{{notification}}</span></center><br/>
							<input class="form-control" ng-class="{'invalid_cred_newadmin' : !newadmin.username}" type="text" placeholder="Set new admin username" ng-model="newadmin.username"><br/>
							<input class="form-control" type="text" placeholder="Set new admin first name" ng-model="newadmin.firstname"><br/>
							<input class="form-control" type="text" placeholder="Set new admin last name" ng-model="newadmin.lastname"><br/>
							<input class="form-control" type="text" placeholder="Set new admin location" ng-model="newadmin.location"><br/>
							<input class="form-control" type="text" placeholder="Set new admin contact number" onkeypress='return event.charCode >= 48 && event.charCode <= 57' ng-model="newadmin.contact"></input><br/>
							<input class="form-control" ng-class="{'invalid_cred_newadmin' : !newadmin.password || newadmin.password !== newadmin.retypePassword}" type="password" placeholder="Set new admin password" ng-model="newadmin.password"><br/>
							<input class="form-control" ng-class="{'invalid_cred_newadmin' : !newadmin.retypePassword || newadmin.password !== newadmin.retypePassword}" type="password" placeholder="Retype password" ng-model="newadmin.retypePassword"><br/>
							<input class="form-control" ng-class="{'invalid_cred_newadmin' : !newadmin.email}" type="email" placeholder="Set new admin email" ng-model="newadmin.email"><br/>
						</div>
						<div class="row">
							<div class="col-sm-7"><button class="btn btn-success w100" ng-click="confirmCreateAdminAccount()">Confirm</button></div>
							<div class="col-sm-5"><button class="btn btn-danger w100" ng-click="cancelCreateAdminAccount()">Cancel</button></div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">&nbsp;</div>
			</div>
		</div>


		<!-- SET NEW ADMIN ACCOUNT -->
		<div ng-cloak ng-show="showFeedback" ng-controller="sendFeedbackCtr">


			<div ng-cloal ng-if="respondent.isAdmin" class="row">
				<div class="col-sm-2">&nbsp;</div>
				<div class="col-sm-8">
					<div class="sendFeedback">
						<div>
							<div class="row">
								<div class="col-sm-7">
									<h3>Customer feedbacks</h3><br/>		
								</div>
								<div class="col-sm-5">
									<input type="text" class="form-control" placeholder="Filter feedbacks" ng-model="feedbackFilter">
								</div>
							</div>
							<div ng-cloak ng-if="feedbacks.length">
								<table class="table table-hover">
									<thead>
										<tr>
											<td class="cp" ng-click="sortType = 'username'; sortReverse = !sortReverse">
												<b>Respondent</b>
												<span ng-show="sortType == 'username' && !sortReverse" class="fa fa-caret-down"></span>
	        									<span ng-show="sortType == 'username' && sortReverse" class="fa fa-caret-up"></span>
											</td>
											<td class="cp" ng-click="sortType = 'content'; sortReverse = !sortReverse">
												<b>Feedback</b>
												<span ng-show="sortType == 'content' && !sortReverse" class="fa fa-caret-down"></span>
	        									<span ng-show="sortType == 'content' && sortReverse" class="fa fa-caret-up"></span>
											</td>
											<td class="cp" ng-click="sortType = 'time'; sortReverse = !sortReverse">
												<b>Date sent</b>
												<span ng-show="sortType == 'time' && !sortReverse" class="fa fa-caret-down"></span>
	        									<span ng-show="sortType == 'time' && sortReverse" class="fa fa-caret-up"></span>
											</td>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="item in feedbacks | orderBy:sortType:sortReverse | filter:feedbackFilter">
											<td>{{item.username}}</td>
											<td><p>{{item.content}}</p></td>
											<td>{{item.time| date:'medium'}}</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div ng-cloak ng-if="!feedbacks.length">
								<center>No feedbacks</center>
							</div>

						</div>
					</div>
				</div>
				<div class="col-sm-2">&nbsp;</div>
			</div>


			<div ng-cloak ng-if="!respondent.isAdmin" class="row">
				<div class="col-sm-4">&nbsp;</div>
				<div class="col-sm-4">
					<div class="sendFeedback">
						<div>
							<h3>Send feedback</h3>
							<small>Positive or negative, your feedback can go a long way in helping us improve our service for you! So feel free to write us any suggestions!</small><br/><br/>
							<center class="cg" ng-cloak ng-if="feedbackSent">Sent! Thank you for your feedback!<br/><br/></center>
							<textarea ng-class="{'invalid_cred_feedback' : !$parent.feedback}" class="form-control" rows="8" ng-model="$parent.feedback"></textarea>
						</div><br/>
						<div class="row">
							<div class="col-sm-7"><button ng-disabled="!standby" class="btn btn-success w100" ng-click="sendFeedback()">
								<span ng-cloak ng-if="standby">Send</span>
								<span ng-cloak ng-if="!standby">Sending...</span>
							</button></div>
							<div class="col-sm-5"><button ng-disabled="!standby" class="btn btn-danger w100" ng-click="cancelViewFeedback()">Cancel</button></div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">&nbsp;</div>
			</div>


		</div>


	</div>









</body>
</html>
