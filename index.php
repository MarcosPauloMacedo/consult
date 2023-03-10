<?php 
require_once('Consult.php');

$consult = new Consult();
$dataBase = $consult->conectDatabase('localhost','root','','sucos_vendas');

$test = $consult->bringDataTable($dataBase,'tabela_de_vendedores');

var_dump($test);
?>