<?php
session_start();
include ("consulta/libSigpi.php");
    if ($_SESSION['sesion']== 0 or  $_SESSION['idRol'] != 1){
      header('Location: ../index.php' );
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SIGPI</title>

    
     <link href="../css/interfaz.css" rel="stylesheet">

    <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../imagenes/favicon.ico" type="image/x-icon">
   
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

   
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    

</head>

<body>
    <?php 
include('modals/md_registrarProyecto.php');
include('modals/md_modificarProyecto.php');
include('modals/md_eliminarProyecto.php');
include('modals/md_registrarEquipo.php');

?>
<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-custom" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">.....................</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">SIGPI</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                              

                   <li><a href="consulta/cerrarSesion.php"><i class="fa fa-sign-out fa-fw"></i> Salir</a></li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
        </div>
            <div class="profile" style="margin:20px; margin-bottom: -50px;">
                <!--img_2 -->
              <div class="profile_pic" style="margin-left:70px;">
                <br>
                  <img src="../imagenes/logofinal4.png" alt="..." class="img-circle profile_img" >
              </div>
              <div class="profile_info" style="margin-left:35px;">
                 <h3> <span>Bienvenido</span></h3>
                  <h5><i><?php echo $_SESSION['empleado'];?></i> / <font style="text-transform: uppercase; color:black; "><?php echo $_SESSION['rol'] ?></font></h5>
              </div>
          </div>

         

                       <div class="navbar-default sidebar" role="navigation">

                <div class="sidebar-nav navbar-collapse">

                    <ul class="nav" id="side-menu">
                     


                        <li>
                            <a href="lobbyJp.php"><i class="fa fa-home fa-fw"></i>&nbsp;&nbsp; Inicio</a>
                        </li>
                        <li>
                            <a href="gestionProyectoJp.php"><i class="fa fa-bar-chart-o fa-fw"></i>&nbsp;&nbsp; Gestion Proyecto<span></span></a>
                           
                        </li>

                        <li>
                            <a><i class="fa fa-book fa-fw"></i>&nbsp;&nbsp; Contactos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="gestionClienteJp.php"> &nbsp;&nbsp;Clientes</a>
                                </li>
                                <li>
                                    <a href="gestionProveedorJp.php"> &nbsp;&nbsp;Proveedores</a>
                                </li>
                               
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>


        <div id="page-wrapper">
           
          

    <div class="container-fluid">
    
    <div class='col-xs-6'>  
      <h3> Listado de proyectos</h3>
    </div>
    <div class='col-xs-6'>
      <h3 class='text-right'>   
        <button type="button" class="btn btn-tema btn-sm" data-toggle="modal" data-target="#registroProyecto" >
            Nuevo proyecto
          </button>
      </h3>
    </div>  
    
    <div class="row">
    
    
    
    <div class="col-xs-12">
    <div id="loadProyecto" class="text-center"> <img src="loader.gif"></div>
    <div class="datos_ajax_delete"></div><!-- Datos ajax Final -->
    <div class="outer_div"></div><!-- Datos ajax Final -->
    </div>
    </div>
   
  </div>

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


  <script src="../js/jquery.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/app.js"></script>
  <script>
    $(document).ready(function(){
      load(1);
    });
  </script>
  <script>
    function load(page){
        var parametros = {"action":"ajax","page":page};
        $("#loadProyecto").fadeIn('slow');
        $.ajax({
            url:'consulta/cargarProyectoJp.php',
            data: parametros,
             beforeSend: function(objeto){
            $("#loadProyecto").html("<img src='../imagenes/loader.gif'>");
            },
            success:function(data){
                $(".outer_div").html(data).fadeIn('slow');
                $("#loadProyecto").html("");
            }
        })
    }
  </script>




    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../js/sb-admin-2.js"></script>

</body>

</html>
