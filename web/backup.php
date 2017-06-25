<?php
include("conexion.php");
$fechaDeLaCopia = "-ALV".date("d-l-F-Y");
$ficheroDeLaCopia =$dbname.$fechaDeLaCopia.".sql";
$sistema="show variables where variable_name= 'basedir'";
$restore=mysqli_query($sistema);
$DirBase="C:/xampp/mysql/bin/mysqldump";



$executa="$DirBase --host=$servername --user=$dbusername --password=$dbpassword -R -c  --add-drop-table $dbname > $ficheroDeLaCopia";
system($executa);

header( "Content-Disposition: attachment; filename=".$ficheroDeLaCopia."");
header("Content-type: application/force-download");
@readfile($ficheroDeLaCopia);

unlink($ficheroDeLaCopia);

?>