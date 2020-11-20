<?php

//fetch.php

include("database_connection.php");
//inicia la conexion 

$query = "SELECT * FROM tbl_sample";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
$output = '
<table class="table table-striped table-bordered">
	<tr>
		<th>Nombre Producto</th>
		<th>Precio Producto</th>
		<th>Editar</th>
		<th>Eliminar</th>
	</tr>
';
if($total_row > 0)
{
	foreach($result as $row)
	{
		$output .= '
		<tr>
			<td width="40%">'.$row["first_name"].'</td>
			<td width="40%">'.$row["last_name"].'</td>
			<td width="10%">
				<button type="button" name="edit" class="btn btn-primary btn-xs edit" id="'.$row["id"].'">Editar</button>
			</td>
			<td width="10%">
				<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id"].'">Eliminar</button>
			</td>
		</tr>
		';
	}
}
else
{
	$output .= '
	<tr>
		<td colspan="4" align="center">Datos no encontrados</td>
	</tr>
	';
}
$output .= '</table>';
echo $output;
?>