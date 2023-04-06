<?php 
class ConsultProtected
{  
    protected object $conect;
    
    protected function __construct($conect)
    {   
        try{
            if(!is_object($conect))
            {
                throw new Exception('Não é um objeto!');
            }

            if(!($conect instanceof mysqli))
            {
                throw new Exception('Objeto inválido!');
            }

            $this->conect = $conect;

        }
        catch(Exception $exec)
        {
            var_dump($exec->getMessage());
        }
    }

    public function databaseConected()
    {
        return !empty($this->conect);
    }

    protected function type($attributes)
    {
        $typeAttributes = gettype($attributes);
        return $typeAttributes;
    }
    
    protected function validateData($type)
    {
        $validateConect = $this->type($type) == 'object';
        return $validateConect;
    }

    protected function error($typeError)
    {
        $errorTable = "Dados não encontrados!
        Verifique o nome da tabela ou da coluna";

        $errorDataBase = "Erro ao conectar ao banco de dados!";

        switch($typeError)
        {
            case $typeError == 'table' : return $errorTable;
            break;
            
            case $typeError == 'database' : return $errorDataBase;
            break;
        }
    }

    protected function validateTable($table)
    {
        if($this->validateData($table))
        {
            return $table;
        }

        return $this->error('table');
    }
    
    protected function bringTable($nameTable)
    {
        if($this->databaseConected())
        {   
            $dataTable = mysqli_query($this->conect,"SELECT * FROM {$nameTable}");
            $dataTable = $this->validateTable($dataTable);
            
            return $dataTable;
        }

        return $this->error('database');
    }
    
    protected function fetchIndex($table)
    {
        $indexName = array_keys($table);
        return $indexName;
    }
    
    protected function addData($vars)
    {
        $data = [];
        foreach($vars as $var)
        {
            array_push($data,$var);
        }
        
        return $data;
    }
}