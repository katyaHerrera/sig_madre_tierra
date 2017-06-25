<?php

error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);
$servername='localhost';//localhost
$dbusername='root';//root
$dbpassword=null;//tupass
$dbname='sigmadretierra';//tuclave
connecttodb($servername,$dbname,$dbusername,$dbpassword);
function connecttodb($servername,$dbname,$dbusername,$dbpassword)
{
    $link=mysqli_connect ($servername,$dbusername,$dbpassword);
    if(!$link)
    {
        die('No puedo Conectarme al Administrador MySQL');
    }
    mysqli_select_db($link,$dbname)
    or die ('No puedo seleccionar la base de datos');
}
?>