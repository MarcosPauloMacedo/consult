<?php 
class ConsultProtected
{
    protected function type($attributes)
    {
        $typeAttributes = gettype($attributes);
        return $typeAttributes;
    }

    protected function validateData($conect)
    {
        $validateConect = $this->type($conect) == 'object';
        return $validateConect;
    }
    
    protected function error($string)
    {
        $errorTable = "Dados não encontrada!
        Verifique o nome da tabela ou da coluna";

        $errorDataBase = "Erro ao conectar ao banco de dados";

        switch($string)
        {
            case $string == 'table' : return $errorTable;
            break;
            
            case $string == 'dataBase' : return $errorDataBase;
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
    
    protected function bringTable($conect,$nameTable)
    {
        if($this->validateData($conect))
        {
            $dataTable = mysqli_query($conect,"SELECT * FROM {$nameTable}");
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