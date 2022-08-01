<?php
session_start();
include("conect.php");
$conexion = conectar();
$myid = $_SESSION['id'];
//echo '<script>alert("BIENVENIDO A PALMERTEC '.$myid.'")</script>';
?>
<!DOCTYPE html>

<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
        <title>Listado de Usuarios</title>
        <link rel="stylesheet" type="text/css" href="estilo.css">
    </head>
    <body>
        <h1>Selecciona a quien mandarle mensaje</h1>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Matricula</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <?php 

            $sql_register = mysqli_query($conexion, "SELECT COUNT(*) as total_registros FROM usuario");
            $result_register = mysqli_fetch_array($sql_register);
            $total_registro = $result_register['total_registros'];
            /*
            $por_pagina = 5;

            if(empty($_GET['pagina'])){
                $pagina = 1;
            }else{
                $pagina = $_GET['pagina'];
            }

            $desde = ($pagina-1) * $por_pagina;
            $total_paginas = ceil($total_registro / $por_pagina);
            $result = mysqli_query($conexion, "SELECT * FROM usuario ORDER BY nombre ASC LIMIT $por_pagina OFFSET $desde");
            */
            $result = mysqli_query($conexion, "SELECT * FROM `usuario` WHERE id != $myid");
            mysqli_close($conexion);
            while($row = mysqli_fetch_array($result)){?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['matricula']; ?></td>
                    <td>
                        <a href="chat.php?id=<?php echo $row['id'] ?>">Enviar Mensaje</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </body>
</html>