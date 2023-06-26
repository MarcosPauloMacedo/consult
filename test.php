<?php
require_once('Consult/Consult.php');

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'sucos_vendas';

$conect = new mysqli($host,$user,$password,$database);
$cone = null;

if($conect -> connect_errno)
{
    echo 'error';
}
else
{
    echo 'funcionando';
}

$consult = new Consult('$conect');
$dados = $consult->tablesAll();
$test = $consult->nameColumns('notas_fiscais');

var_dump($test);
