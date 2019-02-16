<?php
    
require("laBDD.php");
require("Parametres.php");

$laBase=new laBDD($hote, $user, $pass, $base);
$laBase->connexion();

$nickname = $_GET['nickname'];
$sql = " DELETE FROM start WHERE nickname='$nickname';";
$sql .= " DELETE FROM end WHERE nickname='$nickname';";
$sql .= " DELETE FROM `user` WHERE `user`.`nickname` ='$nickname';";

$result = $laBase->requete($sql);
header("Location:index.php");

?>