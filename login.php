<?php
	session_start();
	
	// Check if user is already logged in
	if(isset($_SESSION['loggedIn'])){
		header('Location: index.php');
		exit();
	}
	
	require_once('inc/config/constants.php');
	require_once('inc/config/db.php');
	require_once('inc/header.html');
	// Add Bootstrap 5 and Font Awesome for modern UI
	echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">';
	echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">';
	echo '<style>
		body {
			min-height: 100vh;
			background: linear-gradient(135deg, #6e8efb 0%, #a777e3 100%);
			display: flex;
			align-items: center;
			justify-content: center;
			font-family: "Segoe UI", "Roboto", Arial, sans-serif;
			animation: gradientMove 8s ease-in-out infinite alternate;
		}
		@keyframes gradientMove {
			0% { background-position: 0% 50%; }
			100% { background-position: 100% 50%; }
		}
		.glass-card {
			background: rgba(255,255,255,0.18);
			box-shadow: 0 8px 32px 0 rgba(31,38,135,0.18);
			backdrop-filter: blur(12px);
			-webkit-backdrop-filter: blur(12px);
			border-radius: 1.5rem;
			border: 1px solid rgba(255,255,255,0.24);
			padding: 2rem 2rem 1.5rem 2rem;
			margin-top: 2rem;
			margin-bottom: 2rem;
			transition: box-shadow 0.3s;
		}
		.glass-card:hover {
			box-shadow: 0 12px 40px 0 rgba(31,38,135,0.28);
		}
		.form-control {
			background: rgba(255,255,255,0.7);
			border-radius: 0.75rem;
			font-size: 1.1rem;
			padding: 0.75rem 1rem;
			border: none;
			margin-bottom: 1.2rem;
		}
		.form-control:focus {
			box-shadow: 0 0 0 0.2rem #a777e3aa;
			background: #fff;
		}
		.btn {
			border-radius: 0.75rem;
			font-size: 1.1rem;
			padding: 0.6rem 1.2rem;
			transition: transform 0.2s, box-shadow 0.2s;
			box-shadow: 0 2px 8px rgba(167,119,227,0.08);
		}
		.btn:hover {
			transform: translateY(-2px) scale(1.04);
			box-shadow: 0 4px 16px rgba(167,119,227,0.18);
		}
		.requiredIcon { color: #dc3545; margin-left: 2px; }
		.card-header {
			font-size: 2rem;
			font-weight: 700;
			background: transparent;
			border-bottom: none;
			text-align: center;
			color: #6e8efb;
			letter-spacing: 1px;
			margin-bottom: 0.5rem;
		}
		.d-flex.gap-2.mt-3 { justify-content: center; }
		.form-group label { font-size: 1.1rem; font-weight: 500; color: #333; margin-bottom: 0.3rem; }
	</style>';
?>
  <body>

<?php
// Variable to store the action (login, register, passwordReset)
$action = '';
	if(isset($_GET['action'])){
		$action = $_GET['action'];
		if($action == 'register'){
?>
			<div class="container">
			  <div class="row justify-content-center">
			  <div class="col-sm-12 col-md-5 col-lg-5">
				<div class="glass-card">
				  <div class="card-header">
					Register
				  </div>
				  <div class="card-body">
					<form action="">
					<div id="registerMessage"></div>
					  <div class="form-group">
					<label for="registerFullName"><i class="fa fa-user"></i> Name<span class="requiredIcon">*</span></label>
					<input type="text" class="form-control" id="registerFullName" name="registerFullName" placeholder="Full Name">
						<!-- <small id="emailHelp" class="form-text text-muted"></small> -->
					  </div>
					   <div class="form-group">
					<label for="registerUsername"><i class="fa fa-envelope"></i> Email<span class="requiredIcon">*</span></label>
					<input type="email" class="form-control" id="registerUsername" name="registerUsername" autocomplete="on" placeholder="Email">
					  </div>
					  <div class="form-group">
					<label for="registerPassword1"><i class="fa fa-lock"></i> Password<span class="requiredIcon">*</span></label>
					<input type="password" class="form-control" id="registerPassword1" name="registerPassword1" placeholder="Password">
					  </div>
					  <div class="form-group">
					<label for="registerPassword2"><i class="fa fa-lock"></i> Re-enter password<span class="requiredIcon">*</span></label>
					<input type="password" class="form-control" id="registerPassword2" name="registerPassword2" placeholder="Confirm Password">
					  </div>
							<div class="d-flex flex-wrap gap-2 mt-3">
								<a href="login.php" class="btn btn-outline-primary flex-fill"><i class="fa fa-sign-in-alt"></i> Login</a>
								<button type="button" id="register" class="btn btn-success flex-fill"><i class="fa fa-user-plus"></i> Register</button>
								<a href="login.php?action=resetPassword" class="btn btn-warning flex-fill"><i class="fa fa-key"></i> Reset Password</a>
								<button type="reset" class="btn btn-secondary flex-fill"><i class="fa fa-eraser"></i> Clear</button>
							</div>
					</form>
				  </div>
				</div>
				</div>
			  </div>
			</div>
<?php
			require 'inc/footer.php';
			echo '</body></html>';
			exit();
		} elseif($action == 'resetPassword'){
?>
			<div class="container">
			  <div class="row justify-content-center">
			  <div class="col-sm-12 col-md-5 col-lg-5">
				<div class="glass-card">
				  <div class="card-header">
					Reset Password
				  </div>
				  <div class="card-body">
					<form action="">
					<div id="resetPasswordMessage"></div>
					  <div class="form-group">
					<label for="resetPasswordUsername"><i class="fa fa-envelope"></i> Email</label>
					<input type="text" class="form-control" id="resetPasswordUsername" name="resetPasswordUsername" placeholder="Email">
					  </div>
					  <div class="form-group">
					<label for="resetPasswordPassword1"><i class="fa fa-lock"></i> New Password</label>
					<input type="password" class="form-control" id="resetPasswordPassword1" name="resetPasswordPassword1" placeholder="New Password">
					  </div>
					  <div class="form-group">
					<label for="resetPasswordPassword2"><i class="fa fa-lock"></i> Confirm New Password</label>
					<input type="password" class="form-control" id="resetPasswordPassword2" name="resetPasswordPassword2" placeholder="Confirm Password">
					  </div>
							<div class="d-flex flex-wrap gap-2 mt-3">
								<a href="login.php" class="btn btn-outline-primary flex-fill"><i class="fa fa-sign-in-alt"></i> Login</a>
								<a href="login.php?action=register" class="btn btn-outline-success flex-fill"><i class="fa fa-user-plus"></i> Register</a>
								<button type="button" id="resetPasswordButton" class="btn btn-warning flex-fill"><i class="fa fa-key"></i> Reset Password</button>
								<button type="reset" class="btn btn-secondary flex-fill"><i class="fa fa-eraser"></i> Clear</button>
							</div>
					</form>
				  </div>
				</div>
				</div>
			  </div>
			</div>
<?php
			require 'inc/footer.php';
			echo '</body></html>';
			exit();
		}
	}	
?>
	<!-- Default Page Content (login form) -->
    <div class="container">
      <div class="row justify-content-center">
	  <div class="col-sm-12 col-md-5 col-lg-5">
		<div class="glass-card">
		  <div class="card-header">
			Login
		  </div>
		  <div class="card-body">
			<form action="">
			<div id="loginMessage"></div>
			  <div class="form-group">
			<label for="loginUsername"><i class="fa fa-envelope"></i> Email</label>
			<input type="text" class="form-control" id="loginUsername" name="loginUsername" placeholder="Email">
			  </div>
			  <div class="form-group">
			<label for="loginPassword"><i class="fa fa-lock"></i> Password</label>
			<input type="password" class="form-control" id="loginPassword" name="loginPassword" placeholder="Password">
			  </div>
					<div class="d-flex flex-wrap gap-2 mt-3">
						<button type="button" id="login" class="btn btn-primary flex-fill"><i class="fa fa-sign-in-alt"></i> Login</button>
						<a href="login.php?action=register" class="btn btn-outline-success flex-fill"><i class="fa fa-user-plus"></i> Register</a>
						<a href="login.php?action=resetPassword" class="btn btn-outline-warning flex-fill"><i class="fa fa-key"></i> Reset Password</a>
						<button type="reset" class="btn btn-secondary flex-fill"><i class="fa fa-eraser"></i> Clear</button>
					</div>
			</form>
		  </div>
		</div>
		</div>
      </div>
    </div>
<?php
	require 'inc/footer.php';
?>
  </body>
</html>
