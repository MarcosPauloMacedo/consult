<?php
require_once('Consult/Consult.php');

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'sucos_vendas';

$conect = new mysqli($host,$user,$password,$database);

if($conect -> connect_errno)
{
    echo 'error';
}
else
{
    echo 'funcionando';
}

$consult = new Consult();

$tablesAll = $consult->tablesAll($conect);
$bringDataTable = $consult->bringDataTable($conect,'tabela_de_vendedores');
$nameColumn = $consult->nameColumns($conect,'tabela_de_vendedores');
$methods = $consult->allMethods();

// var_dump($methods);
