<html>  
    <head>  
        <title>Añadir producto</title>  
		<link rel="stylesheet" href="jquery-ui.css">
        <link rel="stylesheet" href="bootstrap.min.css" />
		<script src="jquery.min.js"></script>  
		<script src="jquery-ui.js"></script>
    </head>  
    <body>  
        <div class="container">
			<br />
			
			<h3 align="center">Añadir producto</a></h3><br />
			<br />
			<div align="right" style="margin-bottom:5px;">
			<button type="button" name="add" id="add" class="btn btn-success btn-xs">Añadir</button>
			</div>
			<div class="table-responsive" id="user_data">
				
			</div>
			<br />
		</div>
		<!-- //interaccion de la ventana -->
		<div id="user_dialog" title="Add Data">
			<form method="post" id="user_form">
				<div class="form-group">
					<label>Nombre del Producto</label>
					<input type="text" name="first_name" id="first_name" class="form-control" />
					<span id="error_product" class="text-danger"></span>
				</div>
				<div class="form-group">
					<label>Precio del Producto</label>
					<input type="text" name="last_name" id="last_name" class="form-control" />
					<span id="error_price" class="text-danger"></span>
				</div>
				<!-- añadir actualizar -->
				<div class="form-group">
					<input type="hidden" name="action" id="action" value="insert" />
					<input type="hidden" name="hidden_id" id="hidden_id" />
					<input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Insert" />
				</div>
			</form>
		</div>
		
		<div id="action_alert" title="Action">
			
		</div>
		
		<div id="delete_confirmation" title="Confirmation">
		<p>¿Estás seguro de que deseas eliminar estos datos?</p>
		</div>
		
    </body>  
</html>  




<script>  
$(document).ready(function(){  

	//llamamos a los datos
	load_data();
    //funcion optener datos
	function load_data()
	{
		//ajax 
		$.ajax({
			url:"fetch.php",
			method:"POST",
			success:function(data)
			{
				//resive informacion
				$('#user_data').html(data);
			}
		});
	}
	
	$("#user_dialog").dialog({
		autoOpen:false,
		width:400
	});
	
	$('#add').click(function(){
		$('#user_dialog').attr('title', 'Add Data');
		$('#action').val('insert');
		$('#form_action').val('Añadir');
		$('#user_form')[0].reset();
		$('#form_action').attr('disabled', false);
		$("#user_dialog").dialog('open');
	});
	
	//detecta los eerores de producto
	$('#user_form').on('submit', function(event){
		event.preventDefault();
		var error_product = '';
		var error_last_name = '';
		if($('#first_name').val() == '')
		{
			//donde no se ingresa el nombre del producto
			error_product = 'Se requiere el nombre Producto';
			$('#error_product').text(error_product);
			$('#first_name').css('border-color', '#cc0000');
		}
		else
		{
			error_product = '';
			$('#error_product').text(error_product);
			$('#first_name').css('border-color', '');
		}
		if($('#last_name').val() == '')
		{
			//donde no se ingresa el
			error_price = 'Se requiere el precio';
			$('#error_last_name').text(error_price);
			$('#last_name').css('border-color', '#cc0000');
		}
		else
		{
			error_price = '';
			$('#error_last_name').text(error_price);
			$('#last_name').css('border-color', '');
		}
		
		if(error_product != '' || error_price != '')
		{
			return false;
		}
		else
		{
			$('#form_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#user_dialog').dialog('close');
					$('#action_alert').html(data);
					$('#action_alert').dialog('open');
					load_data();
					$('#form_action').attr('disabled', false);
				}
			});
		}
		
	});
	
	$('#action_alert').dialog({
		autoOpen:false
	});
	
	$(document).on('click', '.edit', function(){
		var id = $(this).attr('id');
		var action = 'fetch_single';
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#first_name').val(data.first_name);
				$('#last_name').val(data.last_name);
				$('#user_dialog').attr('title', 'Editar Datos');
				$('#action').val('update');
				$('#hidden_id').val(id);
				$('#form_action').val('Editar');
				$('#user_dialog').dialog('open');
			}
		});
	});
	
	$('#delete_confirmation').dialog({
		autoOpen:false,
		modal: true,
		buttons:{
			Ok : function(){
				var id = $(this).data('id');
				var action = 'delete';
				$.ajax({
					url:"action.php",
					method:"POST",
					data:{id:id, action:action},
					success:function(data)
					{
						$('#delete_confirmation').dialog('Cerrar');
						$('#action_alert').html(data);
						$('#action_alert').dialog('abrir');
						load_data();
					}
				});
			},
			Cancel : function(){
				$(this).dialog('close');
			}
		}	
	});
	
	$(document).on('click', '.delete', function(){
		var id = $(this).attr("id");
		$('#delete_confirmation').data('id', id).dialog('open');
	});
	
});  
</script>