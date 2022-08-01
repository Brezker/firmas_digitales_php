<?php
    session_start();
    $id_chat = $_GET['id'];
    $myid = $_SESSION['id'];
    $mynom = $_SESSION['nombre'];
    //echo $id_chat;
    //echo $myid;
    $nom_dir1 = $id_chat."-".$myid;
    $nom_dir2 = $myid."-".$id_chat;
    if (is_dir($nom_dir1) || is_dir($nom_dir2)){
        //echo "ya existe dir";
        if (is_dir($nom_dir1)){
            $txt_file = fopen("$nom_dir1/chat.txt",'r');
            while ($line = fgets($txt_file)) {
            echo(" ".$line)."<br>";
            }
            fclose($txt_file);
        } else {
            $txt_file = fopen("$nom_dir2/chat.txt",'r');
            while ($line = fgets($txt_file)) {
            echo(" ".$line)."<br>";
            }
            fclose($txt_file);
        }

    } else {
        mkdir($nom_dir1);
        //echo 'se creo un dir';

        //Creacion de las llaves para el chat
        $parametros = array(
            "config"=>"C:/xampp/php/extras/openssl/openssl.cnf",
            "private_key_bits"=>2048,
            "default_md"=>"sha256",
        );
        $generar=openssl_pkey_new($parametros);
        openssl_pkey_export($generar,$keypriv,NULL,$parametros);
        $keypub=openssl_pkey_get_details($generar);

        file_put_contents($nom_dir1.'/private.key',$keypriv);
        file_put_contents($nom_dir1.'/public.key',$keypub['key']);

        //Creacion del archivo de chat
        $file= fopen("$nom_dir1/chat.txt","a+") or die("Error al crear archivo");
        fclose($file);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <br>
        <input type="text" name="mensaje_txt" required>
        <input type="submit" value="Mandar Mensaje" name="b1">
    </form>
</body>
</html>

<?php
    if (isset($_POST["b1"])) {
        $mensaje=($_POST['mensaje_txt']);

        if (is_dir($nom_dir1)){
            file_put_contents("$nom_dir1/chat.txt", "$mynom - $mensaje\n",  FILE_APPEND | LOCK_EX);
            header("Refresh:1");
        } else {
            file_put_contents("$nom_dir2/chat.txt", "$mynom - $mensaje\n",  FILE_APPEND | LOCK_EX);
            header("Refresh:1");
        }
    }
?>