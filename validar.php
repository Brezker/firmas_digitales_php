<?php 
session_start();
include("conect.php");
$conexion = conectar();
$matricula= mysqli_real_escape_string($conexion, $_POST['matricula_txt']);
$contraseña=md5(mysqli_real_escape_string($conexion, $_POST['pass_txt']));
$sql=mysqli_query($conexion,"SELECT * FROM usuario WHERE matricula='$matricula'");
if($f=mysqli_fetch_assoc($sql)){
    
    if($f['pass_hash']==NULL){
        $update_pass=mysqli_query($conexion,"UPDATE `usuario` SET `pass_hash` = '$contraseña' WHERE `usuario`.`matricula` = '$matricula'");
        //$update_public_key=mysqli_query($conexion,"UPDATE `usuario` SET `llave_publica` = '$contraseña' WHERE `usuario`.`matricula` = '$matricula'");
        
        echo "<script>location.href='lista_us.php'</script>";
    }
    else {
    
        if($contraseña==$f['pass_hash']){
            $_SESSION['active'] = true;
            $_SESSION['id']=$f['id'];
            $nombre = $_SESSION['nombre']=$f['nombre'];
            mysqli_close($conexion);
            
            //echo '<script>alert("BIENVENIDO A PALMERTEC '.$nombre.'")</script>';

            echo "<script>location.href='lista_us.php'</script>";

        }else{
            echo '<script>alert("CONTRASEÑA INCORRECTA")</script>';
            echo "<script>location.href='index.php'</script>";
        }
    }
}else{

	echo '<script>alert("MATRICULA NO REGISTRADA")</script> ';

	echo "<script>location.href='index.php'</script>";	

}

?>
