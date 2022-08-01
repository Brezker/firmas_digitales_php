<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="#">
        Datos a Cifrar <input type="text" name="t1"><br>
        <input type="submit" value="Cifrar" name="b1"><br>
    </form>
</body>
</html>

<?php 
    if(isset($_REQUEST['b1'])){
        $datos=$_REQUEST["t1"];

        $publickey=openssl_pkey_get_public(file_get_contents('public.key'));
        openssl_public_encrypt($datos,$datos_cifrados,$publickey);
        echo "Cifrado con llave publica <br>".$datos_cifrados."<br>";

        $privatekey=openssl_pkey_get_private(file_get_contents('private.key'));
        openssl_private_decrypt($datos_cifrados,$datos_decifrados,$privatekey);
        echo "Decifrado con llave privada <br>".$datos_decifrados."<br>";

        $privatekey=openssl_pkey_get_private(file_get_contents('private.key'));
        openssl_private_encrypt($datos,$datos_cifrados,$privatekey);
        echo "Cifrado con llave privada <br>".$datos_cifrados."<br>";

        $signature=openssl_sign($datos,$sign,$privatekey,OPENSSL_ALGO_SHA256) ? base64_encode($sign) : null;
        echo "Firma Digital <br>".$signature."<br>";

        $publickey=openssl_pkey_get_public(file_get_contents('public.key'));
        openssl_public_decrypt($datos_cifrados,$datos_decifrados,$publickey);
        echo "Decifrado con llave publica <br>".$datos_decifrados."<br>";

        $rs=openssl_verify($datos_decifrados,base64_decode($signature),$publickey,OPENSSL_ALGO_SHA256);

        if($rs)
            echo "Firma digital Correcta";
        else
            echo "Firma digital Incorrecta";
    }
?>