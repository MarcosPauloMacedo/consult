<?php 
require_once('Consult.php');

$consult = new Consult();
$dataBase = $consult->conectDatabase('localhost','root','','sucos_vendas');
$dadosTabelaClientes = $consult->bringDataTable($dataBase,'tabela_de_clientes');
$colunas = $consult->nameColumns($dataBase,'tabela_de_clientes');
$tabela = $consult->selectFrom($dataBase,'tabela_de_clientes','CPF','1471156710');

var_dump($tabela);

