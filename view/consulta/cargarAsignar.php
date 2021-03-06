<?php
session_start();
include ("libSigpi.php");

	# conectare la base de datos
    $con = conectar();
    if(!$con){
        die("imposible conectarse: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		include ('pagination.php'); //incluir el archivo de paginación
		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 8; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		//Cuenta el número total de filas de la tabla*/
		$count_query   = mysqli_query($con,"SELECT count(*) AS numrows FROM Orden where estado = '0' && Orden.visibilidad = '1'");
		if ($row= mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
		$total_pages = ceil($numrows/$per_page);
		$reload = 'gestionAsignar.php';
		//consulta principal para recuperar los datos
		$query = mysqli_query($con,"select idOrden, cantidadRequerida, cantidadDisponible, descripcion, nombre, cantidadConsumida, estado, Material_idMaterial, Plano_idPlano, referencia, especificaciones from Orden inner join Material on Material_idMaterial = idMaterial inner join Plano on Plano.idPlano = Orden.Plano_idPlano inner join Proyecto on Proyecto.idProyecto = Plano.Proyecto_idProyecto where estado = '0' && Orden.visibilidad = '1' LIMIT $offset,$per_page");
		
		if ($numrows>0){
			?>
		<table class="table table-bordered">
			  <thead>
			  	<tr>
			  		<td> Proyecto</td>
			  		<td> Plano </td>
				    <td> Material requerido</td>
				    <td> Dimensiones </td>
				    <td> Cantidad requerida </td>
				    <td> Cantidad disponible </td>
				    <td> Estado de la orden</td>
				    <td> Acciones </td>
			  	</tr>
			</thead>
			<tbody>
			<?php
			while($row = mysqli_fetch_array($query)){
				?>
				<tr>
					<td><?php echo $row['nombre'];?></td>
					<td><?php echo $row['descripcion'];?></td>
					<td><?php echo $row['referencia'];?></td>
					<td><?php echo $row['especificaciones'];?></td>
					<td><?php echo $row['cantidadRequerida'];?></td>
					<td><?php echo $row['cantidadDisponible'];?></td>
					<td>
						<?php 
						
						if ($row['estado'] == '0'){
							echo 'Orden sin asignar';
							if ($row['cantidadRequerida']<= $row['cantidadDisponible']) {
								echo '<button type="button" class="btn btn-tema pull-right" data-toggle="modal" data-target="#registroTramite" data-ord="'.$row["idOrden"].'" data-mat="'.$row["Material_idMaterial"].'" data-req="'.$row["cantidadRequerida"].'" data-disp="'.$row["cantidadDisponible"].'" data-emp="'.$_SESSION["idEmpleado"].'"><span class="fa fa-indent"></span></i> Asignar </button>';
							}
							if ($row['cantidadRequerida']> $row['cantidadDisponible']){
								echo '<p align="left" style="margin-top: -18px;"><br><i class="glyphicon glyphicon-warning-sign"></i> (No hay suficiente material)</p>';
							}
							
						} 

						if ($row['estado'] == '1'){
							echo 'Orden asignada';
						}

						?>


					</td>
					<td>
						<button type="button" class="btn btn-tema " data-toggle="modal" data-target="#eliminarOrden" data-id="<?php echo $row['idOrden']; ?>"><i class='glyphicon glyphicon-trash'></i> Eliminar</button>
					</td>

				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<div class="table-pagination pull-right">
			<?php echo paginate($reload, $page, $total_pages, $adjacents);?>
		</div>
		
			<?php
			
		} else {
			?>
			<div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>Aviso!!!</h4> No hay datos para mostrar
            </div>
			<?php
		}
	}
?>
