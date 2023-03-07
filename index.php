<?php 
require_once('Consult.php');

$consult = new Consult();
$dataBase = $consult->conectDatabase('localhost','root','','sucos_vendas');
$dadosTabelaClientes = $consult->bringDataTable($dataBase,'tabela_de_clientes');
$colunas = $consult->nameColumns($dataBase,'tabela_de_clientes');
$tabela = $consult->selectFrom($dataBase,'tabela_de_clientes','CPF','1471156710');
$selectColumn = $consult->selectColumn($dataBase,'itens_notas_fiscais','quantidade');

$condition01 = 'numero > 100 and quantidade > 60';

$selectAnd = $consult->selectCondition($dataBase,'itens_notas_fiscais',$condition01);

var_dump($selectAnd);

