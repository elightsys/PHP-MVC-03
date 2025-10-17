<?php
	defined('__ROOT_URL__') OR exit('No direct script access allowed');
	
	require_once (__ROOT_APP__ . '/views/_inc/header.php');
?>

<body class="text-center">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    
<style>
html,
body {
  height: 100%;
}

body {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}
.form-signin .checkbox {
  font-weight: 400;
}
.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}	
 
.bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

@media (min-width: 768px) {
    .bd-placeholder-img-lg {
    font-size: 3.5rem;
    }
}

.ripple-wave {
    display: none !important;
}
</style>

<div class="form-signin tab-content">

	<img class="mb-4" src="//getbootstrap.com/docs/4.6/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">

	<form method="POST" id="loginbox" class="tab-pane <?=($data['page']=='signin'?'active':'fade')?>">	
		
		<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>		
		
		<?php if (isset($data['passwordError']) and !empty($data['passwordError'])) { ?>
			<div class="alert alert-danger text-center"><?php echo $data['passwordError']; ?></div>
		<?php } ?>
		<div class="form-group">
			<label for="email" class="sr-only">Email address</label>
			<input type="email" name="email" id="email" class="form-control" placeholder="Email address" autocomplete="username" required autofocus />
		</div>
		<div class="form-group">
			<label for="password" class="sr-only">Password</label>
			<input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="current-password" required />
			<a style="padding-top:15px; font-size:85%" href="#">Forgot password?</a>
		</div>
		<div class="checkbox mb-3">
			<label>
				<input type="checkbox" value="remember-me"> Remember me
			</label>
		</div>	
			
		<button class="btn btn-primary btn-block" name="btn_signin" type="submit">Login</button>
			
		<div class="col-md-12 control">
			<div style="padding-top:15px; font-size:85%">
				Don't have an account! <a href="#signupbox" class="btn-link" data-toggle="pill">Sign Up Here</a>
			</div>
		</div>

		<input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
		
		<!-- <input type="hidden" name="token" value="<?=$_SESSION['token']?>" /> -->
		
	</form>
	
	<form method="POST" id="signupbox" class="tab-pane form-signin <?=($data['err']?'was-validated':'needs-validation')?> <?=($data['page']=='signup'?'active':'fade')?>" <?=($data['err']?'':'novalidate')?>>
		<h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
		<!-------------->  
		<div class="form-group">
			<label class="sr-only" for="fullname">Full name</label>
			<div class="input-group">
				<input class="form-control form-control-sm <?=($data['fullnameError'])?'is-invalid':'is-valid'?>" id="fullname" name="fullname" placeholder="Full name" type="text" value="<?=(isset($_POST['fullname'])?$_POST['fullname']:'')?>" autocomplete="off" aria-describedby="inputGroupPrepend" required>
				<div class="invalid-feedback"><?=($data['fullnameError']? $data['fullnameError'] : 'Please enter a correct format full name.')?></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="sr-only" for="newEmail">Email address</label>
			<div class="input-group">
				<input class="form-control form-control-sm <?=($data['newEmailError'])?'is-invalid':'is-valid'?>" id="newEmail" name="newEmail" placeholder="Email address" type="email" value="<?=(isset($_POST['newEmail'])?$_POST['newEmail']:'')?>" autocomplete="off" aria-describedby="inputGroupPrepend" required>
				<div class="invalid-feedback"><?=($data['newEmailError']?$data['newEmailError']:'Please enter correct e-mail address.')?></div>
			</div>
		</div>
      
        <div class="form-group">
			<label class="sr-only" for="newPassword">New Password</label>
			<div class="input-group">
				<input name="newPassword" type="password" autocomplete="off" class="form-control form-control-sm <?=($data['newPasswordError'] || $data['confirmPasswordError'])?'is-invalid':'is-valid'?>" id="newPassword" placeholder="New Password" aria-describedby="inputGroupPrepend" required />
				<div class="invalid-feedback"><?=($data['newPasswordError']?$data['newPasswordError']:'Please enter new password.')?></div>
			</div>
        </div>
		  
		<div class="form-group">
			<label class="sr-only" for="confirmPassword">Confirm Password</label>
			<div class="input-group">
				<input name="confirmPassword" type="password" autocomplete="off" class="form-control form-control-sm <?=($data['newPasswordError'] || $data['confirmPasswordError'])?'is-invalid':''?>" id="confirmPassword" placeholder="Confirm Password" aria-describedby="inputGroupPrepend" oninput="check(this)" required />
				<div class="invalid-feedback"><?=($data['confirmPasswordError']?$data['confirmPasswordError']:'Password not a match.')?></div>
			</div>
		</div>

		<div class="form-check form-group">
			<input	class="form-check-input" type="checkbox" value=""
			id="invalidCheck" required />
			<label class="form-check-label" for="invalidCheck">
				Agree to terms and <a href="#">conditions</a>
			</label>
			<div class="invalid-feedback">You must agree before submitting.</div>
		</div>

		<button id="submitBtn" name="btn_reg" class="btn btn-md btn-primary btn-block" type="submit">Register</button>
	    <!-------------->                              

		<div class="col-md-12 control">
			<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
				Have an account? <a href="#loginbox" class="btn-link" data-toggle="pill">Log In</a>
			</div>
		</div>
		
		<input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
		<!-- <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>" /> -->
						
	</form>
	
	<p class="mt-5 mb-3 text-muted">&copy; 2023-<?=date('Y')?></p>
</div>
<?php
require_once (__ROOT_APP__ . '/views/_inc/script.php');
?>

<script>
$(document).on('click', '.btn-link', function(e){
	//alert('OK');
	$(this).removeClass('active');
	$('#loginbox')[0].reset();
	$('#signupbox')[0].reset();
	//resetFormGroup('#loginbox');
	
	$('#signupbox').trigger("reset");
	 
	let formGroup = document.getElementById('signupbox');
	formGroup.querySelectorAll('.form-control').forEach(jsContactInput => {
		jsContactInput.classList.remove("is-valid");
		jsContactInput.classList.remove("is-invalid");
	});
	$('#fullname').val('');
	$('#newEmail').val('');
	
}); 

(function() {
	'use strict';
	window.addEventListener('load', function() {
		// Fetch all the forms we want to apply custom Bootstrap validation styles to
		var forms = document.getElementsByClassName('needs-validation');
		// Loop over them and prevent submission
		var validation = Array.prototype.filter.call(forms, function(form) {
			form.addEventListener('submit', function(event) {
				if (form.checkValidity() === false) {
					event.preventDefault();
					event.stopPropagation();
				}
				form.classList.add('was-validated');
			}, false);
		});
	}, false);
})();

function check(input) {
    if (input.value != document.getElementById('newPassword').value) {
        input.setCustomValidity(true); // 'Password Must be Matching.'
    } else {
        // input is valid -- reset the error message
        input.setCustomValidity('');
    }
}
</script>
</body>
</html>