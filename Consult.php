<?php 
class Consult
{  
    private function validateTable($table)
    {
        if(empty($table))
        {
            return "tabela não encontrada!
            verifique o nome e tente novamente.";
        }
        else
        {
            return $table;
        }
    }

    private function type($attributes)
    {
        $typeAttributes = gettype($attributes);
        return $typeAttributes;
    }
    
    private function bringTable($conect,$nameTable)
    {
        if(empty($conect))
        {
            return 'dados de acesso incorretos, verifique os
            parâmetros de consultas';
        }
        else{
            $dataTable = mysqli_query($conect,"SELECT * FROM {$nameTable}");
            $dataTable = $this->validateTable($dataTable);
            
            return $dataTable;
        }
    }
    
    private function fetchIndex($table)
    {
        $indexName = array_keys($table);
        return $indexName;
    }
    
    private function addData($vars)
    {
        $data = [];
        foreach($vars as $var)
        {
            array_push($data,$var);
        }
    
        return $data;
    }

    public function conectDatabase($host,$user,$password,$database)
    {
        $conect = new mysqli(
            $host,$user,$password,$database
        );
        
        if($conect -> connect_errno)
        {
            return NULL;
        }
        else
        {
            return $conect;
        }
    }
    
    public function debug($attributes)
    {
        var_dump($attributes);
        exit;
    }
    
    public function bringDataTable($conect,$nameTable)
    {   
        $data = [];
        $dataTable = $this->bringTable($conect,$nameTable);

        if($this->type($dataTable) != 'object')
        {
            return $dataTable;
        }
        else
        {
            foreach($dataTable as $dataTab)
            {
                array_push($data,$dataTab);
            }
            return $data;
        }
    }

    public function tablesAll($conect)
    {
        if(empty($conect))
        {
            return "erro ao conectar com o banco de dados";
        }
        else
        {
            $OBJtablesAll = mysqli_query($conect,"SHOW TABLES");
            // foreach($OBJtablesAll as $obj)
            // {
            //     var_dump($obj['Tables_in_sucos_vendas']);
            // }
            // exit;

            $tablesAll = $this->addData($OBJtablesAll);
            return $tablesAll;
        }
    }

    public function nameColumns($conect,$nameTable)
    {
        $tablesAll = $this->tablesAll($conect);

        if($this->type($tablesAll) != 'array')
        {
            return $tablesAll;
        }
        else
        {
            foreach($tablesAll as $table)
            {   
                $indexName = $this->fetchIndex($table);
    
                if($nameTable == $table[$indexName[0]])
                {   
                    $nameTable = $this->bringTable($conect,$nameTable);

                    if($this->type($nameTable) != 'object')
                    {
                        return $nameTable;
                    }
                    
                    $firstResult = $nameTable->fetch_array(MYSQLI_ASSOC);
                    $columns = $this->fetchIndex($firstResult);
                    return $columns;
                }
            }

            return "tabela não encontrada!";
        }
    }

    public function selectFrom($conect,$nameTable,$column,$data)
    {   
        if(!empty($conect))
        {
            $dataFound = mysqli_query($conect,"SELECT 
            * FROM {$nameTable} WHERE {$column} = {$data}");
            $dataFound = $this->validateTable($dataFound);
            
            if($this->type($dataFound) != 'object')
            {
                return $dataFound;
            }
            
            $selectedData = $this->addData($dataFound);
            return $selectedData;
        }
        else
        {
            return 'Erros ao conectar com banco de dados!
             verifique os atributos de consult';
        }
    }

    public function selectColumn($conect,$nameTable,$nameColumn)
    {
        if($this->type($conect) != 'object')
        {
            return "Erro ao conectar ao banco de dados";
        }

        $dataColumn = mysqli_query($conect,
        "SELECT {$nameColumn} from {$nameTable}");
        
        if($this->type($dataColumn) != 'object')
        {
            return "Dados não encontrada!
            Verifique o nome da tabela ou da coluna";
        }
        
        $data = $this->addData($dataColumn);
        return $data;
    }

    public function selectCondition($conect,$nameTable,$condition01)
    {
        if($this->type($conect) != 'object')
        {
            return "Erro ao conectar ao banco de dados";
        }

        $command = "SELECT * FROM {$nameTable}
        where $condition01";

        $dataTable = mysqli_query($conect,$command);

        if($this->type($dataTable) != 'object')
        {
            return "Dados não encontrada!
            Verifique o nome da tabela ou da coluna";
        }

        $data = $this->addData($dataTable);
        return $data;
    }

    public function queryAny($conect,$nameTable,$column,$var)
    {
        if($this->type($conect) != 'object')
        {
            return "Erro ao conectar ao banco de dados";
        }

        $dataTable = mysqli_query($conect,
        "SELECT * FROM {$nameTable} WHERE {$column} LIKE '%{$var}%'");

        if($this->type($dataTable) != 'object')
        {
            return "Dados não encontrada!
            Verifique o nome da tabela ou da coluna";
        }

        $data = $this->addData($dataTable);
        return $data;
    }
}
?>