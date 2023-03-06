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

    private function validateDataBase($conect)
    {
        $validate = $conect != null;
        return $validate;
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
            $tablesAll = [];
            $OBJtablesAll = mysqli_query($conect,"SHOW TABLES");
    
            foreach($OBJtablesAll as $OBJTables)
            {
                array_push($tablesAll,$OBJTables);
            }
    
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
                    $confirmedOBJ = $this->type($nameTable) == 'object';
    
                    if($confirmedOBJ)
                    {
                        $firstResult = $nameTable->fetch_array(MYSQLI_ASSOC);
                        $columns = $this->fetchIndex($firstResult);
    
                        return $columns;
                    }
                    else
                    {
                        return $nameTable;
                    }
                }
            }

            return "tabela não encontrada!";
        }
    }

    public function selectFrom($conect,$nameTable,$column,$data)
    {   
        if(!empty($conect))
        {
            $selectedData = [];
            $dataFound = mysqli_query($conect,"SELECT 
            * FROM {$nameTable} WHERE {$column} = {$data}");
            $dataFound = $this->validateTable($dataFound);

            if($this->type($dataFound) == 'object')
            {
                foreach($dataFound as $data)
                {
                    array_push($selectedData,$data);
                }
    
                return $selectedData;
            }
            else
            {
                return $dataFound;
            }
        }
        else
        {
            return 'Erros ao conectar com banco de dados!
             verifique os atributos de consult';
        }
    }
}
?>