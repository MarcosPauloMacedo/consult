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

// $conect = new DateTime();

$consult = new Consult($conect);
$dados = $consult->tablesAll();

var_dump($dados);
