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
		$count_query   = mysqli_query($con,"SELECT count(*) AS numrows FROM Proyecto where visibilidad = '1'");
		if ($row= mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
		$total_pages = ceil($numrows/$per_page);
		$reload = 'gestionEmpleados.php';
		//consulta principal para recuperar los datos
		$query = mysqli_query($con,"SELECT Proyecto.nombre, EstadoProyecto.nombre as estado, idEstadoProyecto, idproyecto, fechaInicio,fechaEntrega,porcentajeAvance,Cliente_idCliente, Cliente.nombre as cliente, idCliente from Estadoproyecto inner join Proyecto on idEstadoProyecto =EstadoProyecto_idEstadoProyecto inner join Cliente on Proyecto.Cliente_idCliente = Cliente.idCliente where Proyecto.visibilidad = '1' LIMIT $offset,$per_page");
		
		if ($numrows>0){
			?>
		<table class="table table-bordered">
			  <thead>
			  	<tr>
				    <td> Proyecto</td>
				    <td> Cliente</td>
				    <td> Fecha de inicio</td>
				    <td> Fecha de entrega</td>
				    <td> Avance </td>
				    <td> Estado</td>
				    <td> Informe</td>
				    <td> Equipo</td>
				    <td> Planos </td>  
				    <td> Acciones </td>
			  	</tr>
			</thead>
			<tbody>
			<?php
			while($row = mysqli_fetch_array($query)){
				?>
				<tr>
					<td><?php echo $row['nombre'];?></td>
					<td><?php echo $row['cliente'];?></td>
					<td><?php echo $row['fechaInicio'];?></td>
					<td><?php echo $row['fechaEntrega'];?></td>
					<td>
						<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow=" <?php echo $row['porcentajeAvance']; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $row['porcentajeAvance']; ?>%;">
							<?php echo $row['porcentajeAvance']; ?>%
               			</div>
            			</div>
					</td>
					<td><?php echo $row['estado'];?></td>
					<td>
						<form method="post" action="consulta/asignarSesion.php">
						<input type="hidden" name="infProyecto" value="<?php echo $row['idproyecto'] ?>">
						<button type="submit" class="bton btn-tema" ><i class='fa fa-book'></i> </button>
						</form>
					</td>
					<td>
						<form method="post" action="consulta/asignarSesion.php">
						<input type="hidden" name="idProyecto" value="<?php echo $row['idproyecto'] ?>">
						<button type="submit" class="bton btn-tema" ><i class='fa fa-users'></i>  </button>
						</form>
					</td>
					<td>
						<form method="post" action="consulta/asignarSesion.php">
						<input type="hidden" name="numProyecto" value="<?php echo $row['idproyecto'] ?>">
						<button type="submit" class="bton btn-tema" ><i class='fa fa-file-pdf-o'></i> </button>
						</form>
					</td>
					<td>
						<button type="button" class="btn btn-tema " data-toggle="modal" data-target="#modificarProyecto" id="modi" data-id="<?php echo $row['idproyecto']?>" data-nombre="<?php echo $row['nombre']?>" data-inicio="<?php echo $row['fechaInicio']?>" data-fin="<?php echo $row['fechaEntrega']?>" data-avance="<?php echo $row['porcentajeAvance']?>" data-cliente="<?php echo $row['Cliente_idCliente']?>" data-idestado="<?php echo $row['idEstadoProyecto']?>"><i class='glyphicon glyphicon-edit'></i></button>
						<button type="button" class="btn btn-tema" data-toggle="modal" data-target="#eliminarProyecto" data-id="<?php echo $row['idproyecto']?>"  ><i class='glyphicon glyphicon-trash'></i> </button>
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
