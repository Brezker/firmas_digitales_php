<?php
function conectar(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "firmas_dig";
    $db =new mysqli($servername, $username, $password, $dbname);
    $db->set_charset("utf8");
    if($db->connect_error){
    die("Conexión fallida: ".$db->connect_error);
    }
        return $db;
    }
?>