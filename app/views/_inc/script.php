<?php
	defined('__ROOT_URL__') OR exit('No direct script access allowed');
	$timestamp = time();
?>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!--
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!--
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
-->
<!-- 
DATATABLES BOOTSTRAP 4 
https://datatables.net/examples/styling/bootstrap4
-->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<!-- DATATABLES BUTTONS EXPORT
https://datatables.net/extensions/buttons/examples/initialisation/export.html
-->
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js
"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

<!-- Bootstrap Switch Button -->
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<!-- SCRIPTS -->
<script>
$(document).ready(function() {
	 
	var uTable = $('#users_td').DataTable({
		"bProcessing": true,
        "bServerSide": true,
        //"sAjaxSource": "<?=__ROOT_URL__?>/pages/SspDataTables",
		ajax: {
			url: "<?=__ROOT_URL__?>/Pages/SspUsersDT",
			type: 'POST',
			data: {
				//alert('OK');
			}
		}//,
		//dom: 'Bfrtip',
        //buttons: [
        //    'copy', 'csv', 'excel', 'pdf', 'print'
        //]
	});
	
    $('#server_side').DataTable({
		"bProcessing": true,
        "bServerSide": true,
        //"sAjaxSource": "<?=__ROOT_URL__?>/pages/SspDataTables",
		ajax: {
			url: "<?=__ROOT_URL__?>/Pages/SspDataTable",
			type: 'POST',
			data: {}
		},
		dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});	
	
	// REFRESH TABLE
	$(document).on('click', '#fnDrawBtn', function() {
		//alert('OK');
		//https://datatables.net/reference/api/ajax.reload()
		//https://stackoverflow.com/questions/28313331/datatable-ajax-reload-not-defined
		uTable.ajax.reload(null, false);
		//uTable.api().ajax.reload();
		//alert('ok');
	});

	// CLEAR TABLE
	$(document).on('click', '#fnClearBtn', function() {
		//alert('OK');
		//https://datatables.net/reference/api/ajax.reload()
		//https://stackoverflow.com/questions/28313331/datatable-ajax-reload-not-defined
		//uTable.api().ajax.reload(null, false);
		uTable.ajax.reload();
		//alert('ok');
	});

	
	
	// MODAL
	
	$('.modal').on('hidden.bs.modal', function(){
		$(this).find('form')[0].reset();
		//uTable.api().ajax.reload(null, false);
	});
	
	$(document).on('click', '#btn-user-modal', function() {
		//alert('OK');
		$('#form_add_user').submit();
		return false;
	});
	
	// ON_CLICK
	
	$(document).on('click', '.btn_edit_user', function(event) {				
		event.preventDefault();
		$('#active').prop( "checked", false ).change();
		//var id = $(this).attr('rel');
		var e = $(this);
		var id = e.data('user-id');
		var url = '<?=__ROOT_URL__?>/Users/AjaxUserEdit';
				
		//alert('Mode ID: ' + id);
		//$('#myModal').modal('toggle');
		//$('#myModal').modal('show');
		//$('#myModal').modal('hide');	
		$.ajax({
			url: url,//+ Math.random(),
			type: 'post', 
			dataType: 'json',
			cache: false,
			data: {
				'id' : id,
				'timestamp' : '<?=$timestamp?>',
				'token'     : '<?=md5('unique_salt' . $timestamp)?>'
			},
			success: function(data){
				//alert('Üzenet: ' + data['name']);
				if (data) {
					//uTable.api().ajax.reload();
					//alert('Üzenet: ' + data['name']);
					
					$('input[name=newEmail]').val(data['email']);
					$('input[name=origyEmail]').val(data['email']);
					$('input[name=fullname]').val(data['fullname']);
					$('input[name=newPassword]').val('');
					$('input[name=confirmPassword]').val('');
					$('input[name=id]').val(data['id']);
					$('#role').val(data['role']);
					
					if ( data['active'] == 1 ) {
						$('#active').parent('.toggle').trigger('click');
					}
					
					$('#newPassword').prop( "required", false );
					$('#confirmPassword').prop( "required", false );
					$('.request-hide').hide();
					
					//$.strength($("#password-strength"), $('#inputPassword').val());
					//$("#btn-user-modal").removeClass("btn-primary").addClass("btn-warning").text("Módosíts");
					//$('#userModalCenter').find('.modal-title').text('HELLO');
					//$('#userModalCenter').modal('show');
					//$('select .selectpicker').selectpicker('refresh');
					//alert('OK');
					uTable.ajax.reload();
				} else {
					var results = response[0];
					var title = 'Error! ';
					var icons = 'error';
					var btn = 'danger';				
					//fn_alert(title,results,icons,btn);
					alert('Message: ' + title);
				}
			
			},
			error: function(jqXHR, textStatus, errorThrown) { 
				alert("Error while accessing api \n-url: "+url+"\n-status: "+textStatus+"\n-error: "+errorThrown); return false;    
			}
		});
	});
	
	$(document).on('click', '.btn_del_user', function(event) {
		event.preventDefault();
		//var id = $(this).attr('rel');
		var e = $(this);
		var id = e.data('user-id');
		var url = '<?=__ROOT_URL__?>/Users/AjaxUserDel';
	
		if (confirm('Are you sure you want to delete this?')) {			
			$.ajax({
				url: url,//+ Math.random(),
				type: 'post',
				dataType: 'json',
				cache: false,
				data: {
					'id' : id,
					'timestamp' : '<?=$timestamp?>',
					'token'     : '<?=md5('unique_salt' . $timestamp)?>'
				},			
				success: function(response){
					if ( response[1] ) {
						var title = 'Sikeres!';
						var results = 'A törlés sikeres.';
						var icons = 'success';
						var btn = 'success';					
						//alert('Üzenet: ' + data);					
					} else {
						var results = response[0];
						var title = 'Error! ';
						var icons = 'error';
						var btn = 'danger';
					}				
					//uTable.api().ajax.reload();
					uTable.ajax.reload(); //$('#users_td')
					//fn_alert(title,results,icons,btn);
					alert('Message: ' + title);
				},
				error: function(jqXHR, textStatus, errorThrown) { 
					alert("Error while accessing api \n-url: "+url+"\n-status: "+textStatus+"\n-error: "+errorThrown); return false;    
				}
			});
			
		} else {
			return false;
		}
	});
	
	$("#form_add_user").submit(function(e) {
		e.preventDefault();
		var url = '<?=__ROOT_URL__?>/Users/AjaxUserAddForm';
		var form = $(this);
		//var url = form.attr('action');
		
		$.ajax({
			url: url, 
			type: 'post', 	
			dataType: 'json',
			//async: false,
			data: form.serialize() + '&timestamp=<?=$timestamp?>&token=<?=md5(__UNIQID__ . $timestamp)?>',
			success: function(response) {						
				if ( response[1] ) {
					// CLOSE MODAL???
					//$('#exampleModalCenter').modal('toggle');
					var resp;
					if (response[1] == 'modify' ) {
						resp = 'Módosítás';
					} else {
						resp = 'Felvétel';
					}
					var title = 'Sikeres!'; //alert('message: ' + response[1] );
					var results = resp +  ' sikeres.';//response[1];
					var icons = 'success';
					var btn = 'success';
					
					uTable.ajax.reload();					
					$('#userModalCenter').modal('toggle');	
				} else {
					var len = Object.keys(response).length; //response.list.length;
					var title = 'Error! ';
					var results = ''; 
					var icons = 'error';
					var btn = 'danger';
					Object.keys( response ).forEach(function( key ) {
						//console.log('key name: ', key);
						//console.log('value: ', response[key]);
						//alert('message: ' + response[key] );
						results += response[key] + '\n\n';				
					});
				}
				//fn_alert(title,results,icons,btn);
				alert(title + results);
							
			},
			error: function(jqXHR, textStatus, errorThrown) { 
				alert("Error while accessing api \n-url: "+url+"\n-status: "+textStatus+"\n-error: "+errorThrown); return false;    
			}          
		});		
		
	});
	
	setInterval(function() { //jsonOnlineVisitors
		uTable.ajax.reload(null, false);
	}, 20000); 
	

});
</script>