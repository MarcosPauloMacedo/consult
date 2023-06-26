<?php 
class ConsultProtected
{  
    protected object $conect;
    
    protected function __construct($conect)
    {   
        $this->databaseConected($conect);
    }

    protected function databaseConected($conect)
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
            $this->debug($exec->getMessage());
        }
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
        switch($typeError)
        {
            case $typeError == 'table' : return "Dados não encontrados!
            Verifique o nome da tabela ou da coluna";
            break;
            
            case $typeError == 'database' : return "Erro ao conectar ao banco de dados!";
            break;
        }
    }

    protected function validateTable($table)
    {
        return $table instanceof mysqli_result ? mysqli_fetch_all($table,MYSQLI_ASSOC) :
        $this->error('table');
    }

    public function debug($attributes)
    {
        var_dump($attributes);
        exit;
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

    protected function returnArrayOfElements($query,$assoc)
    {
        return  mysqli_fetch_all(mysqli_query($this->conect,$query),$assoc);
    }

    protected function executeQuery($query)
    {
        return mysqli_query($this->conect,$query);
    }
}