<?php

interface Sql {
    
    // traz todos os métodos da classe
    public function allMethods(); 

    //busca por requisições Post
    public function checkPostRequest($name);

    //busca todos os dados da tabela
    public function bringDataTable($nameTable);

    //todas as tabelas do banco
    public function tablesAll();

    // nome das colunas da tabela
    public function nameColumns($nameTable); 

    // busca dados com uma condição
    public function selectFrom($nameTable,$column,$data);

    // busca dados de uma tabela
    public function selectColumn($nameTable,$nameColumn);

    //busca dados de uma condição específica
    public function selectCondition($nameTable,$condition);

    //Consulta atravez do like 
    public function queryAny($nameTable,$column,$var);

    // criar uma tabela
    public function createTable($nameTable,$parameters);

    // apagar uma tabela
    public function dropTable($nameTable);

    //consultar com algum tipo de ordenação
    public function orderBy($table,$data,$order);
}