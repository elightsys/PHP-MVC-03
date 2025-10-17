<?php
	defined('__ROOT_URL__') OR exit('No direct script access allowed');

	require_once (__ROOT_APP__ . '/views/_inc/header.php');
?>
<body class="d-flex flex-column h-100">
<?php
	require_once (__ROOT_APP__ . '/views/_inc/navbar.php');
?>
	<!-- Begin page content -->
	<main role="main" class="flex-shrink-0">
		<div class="container mb-4">
			<h1 class="mt-5"><?=$data['title']?></h1>
			<p class="lead"></p>
			
			<div class="d-flex my-2" style="width: 100%;">
				<button type="button" id="addUserModal" class="btn btn-primary d-none d-sm-inline-block mr-2" data-toggle="modal" data-target="#userModalCenter">
				<i class="fas fa-user-plus"></i> Add a new User
				</button>
				
				<button id="fnClearBtn" class="btn btn-icon btn-warning btn-xs btn-refresh-cards float-sm-right mr-2" title="Reset"><i class="fas fa-redo-alt"></i></button>
				<button id="fnDrawBtn" class="btn btn-icon btn-primary btn-xs btn-refresh-cards float-sm-right mr-2" title="Refresh"><span class="fa fa-sync-alt"></span></button>
				
			</div>
			
			<table id="users_td" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>Full name</th>
						<th>Active</th>
						<th>Role</th>
						<th>Group</th>
						<th>E-mail</th>
						<th>Last.Date</th>
						<th>Reg.Date</th>
						<th>Functions</th>						
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Full name</th>
						<th>Active</th>
						<th>Role</th>
						<th>Group</th>
						<th>E-mail</th>
						<th>Last.Date</th>
						<th>Reg.Date</th>
						<th>Functions</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</main>
	
	<!-- Modal -->
	
	<div class="modal fade" id="userModalCenter" tabindex="-1" aria-labelledby="userModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">	
			<div class="modal-content">			
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title" id="userModalLongTitle">Add User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="form_add_user" class="form-signin needs-validation" method="post" novalidate>
						<div class="form-group">
							<label class="sr-only" for="fullname">Full name</label>
							<div class="input-group">
								<input class="form-control form-control-sm" id="fullname" name="fullname" placeholder="Full name" type="text" value="" autocomplete="off" aria-describedby="inputGroupPrepend" required>
								<div class="invalid-feedback">Please enter a correct format full name.</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="sr-only" for="newEmail">Email address</label>
							<div class="input-group">
								<input class="form-control form-control-sm" id="newEmail" name="newEmail" placeholder="Email address" type="email" value="" autocomplete="off" aria-describedby="inputGroupPrepend" required>
								<div class="invalid-feedback">Please enter correct e-mail address.</div>
							</div>
						</div>
						
						<div class="form-group form-show-validation row">			
							<label for="active" class="col-lg-4 col-md-4 col-sm-4 mt-sm-2 text-left">Enable User </label>		
							<div class="col-lg-6 col-md-4 col-sm-8 input-group">
								<input type="checkbox" id="active" name="active" class="form-control btn-lg" data-toggle="toggle" value="1" />
								<div class="invalid-feedback">Please select something.</div>
							</div>
						</div>
						
						<div class="form-group form-show-validation row">			
						<label for="role" class="col-lg-4 col-md-4 col-sm-4 mt-sm-2 text-left">Role </label>						
						<div class="col-lg-6 col-md-4 col-sm-8 input-group">
							<select id="role" name="role" class="form-control" required="" tabindex="-1" >
									<!--
									<option value="">Kérem válasszon...</option>
									-->
									<option value="0">Disabled</option>
									<option value="2">Visitor</option>
									<option value="3">User</option>
									
									<option value="4">Admin</option>
									<?php									
									if($_SESSION['role'] == 5):
									?>
									<option value="5">Root</option>
									<?php 
									endif;
									?>
							</select>
							<div class="input-group-append">
								<span class="input-group-text">
									<i class="fas fa-user-tag"></i>
								</span>
							</div>
						</div>									
					</div>	
					  
						<div class="form-group">
							<label class="sr-only" for="newPassword">New Password</label>
							<div class="input-group">
								<input name="newPassword" type="password" autocomplete="new-password" class="form-control form-control-sm" id="newPassword" placeholder="New Password" aria-describedby="inputGroupPrepend" required />
								<div class="invalid-feedback">Please enter new password.</div>
							</div>
						</div>
						  
						<div class="form-group">
							<label class="sr-only" for="confirmPassword">Confirm Password</label>
							<div class="input-group">
								<input name="confirmPassword" type="password" autocomplete="off" class="form-control form-control-sm" id="confirmPassword" placeholder="Confirm Password" aria-describedby="inputGroupPrepend" oninput="check(this)" required />
								<div class="invalid-feedback">Password not a match.</div>
							</div>
						</div>
						
						<input type="hidden" name="origyEmail" value="" />
						<input type="hidden" name="id" value="0" />
						
					</form>
				</div>
				<div class="modal-footer">				
					<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btn-user-modal">Send</button>
				</div>
			</div>			
		</div>
	</div>

<?php
	require_once (__ROOT_APP__ . '/views/_inc/footer.php');
	require_once (__ROOT_APP__ . '/views/_inc/script.php');
?>

</body>
</html>