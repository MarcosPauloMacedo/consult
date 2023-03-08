<?php 
require_once('Consult.php');

$consult = new Consult();
$dataBase = $consult->conectDatabase('localhost','root','','sucos_vendas');
$dadosTabelaClientes = $consult->bringDataTable($dataBase,'tabela_de_clientes');
$colunas = $consult->nameColumns($dataBase,'tabela_de_clientes');
$tabela = $consult->selectFrom($dataBase,'tabela_de_clientes','CPF','1471156710');
$selectColumn = $consult->selectColumn($dataBase,'itens_notas_fiscais','quantidade');

// $condition01 = 'numero > 100 and quantidade > 60';
$condition01 = 'idade = 18';

$selectAnd = $consult->selectCondition($dataBase,'tabela_de_clientes',$condition01);
$queryAny = $consult->queryAny($dataBase,'tabela_de_clientes','cidade','Rio de janeiro');


$tableAll = $consult->tablesAll($dataBase);
var_dump($tableAll);

?>