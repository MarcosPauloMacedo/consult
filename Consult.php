<?php 
class Consult
{  
    private function type($attributes)
    {
        $typeAttributes = gettype($attributes);
        return $typeAttributes;
    }

    private function validateData($conect)
    {
        $validateConect = $this->type($conect) == 'object';
        return $validateConect;
    }
    
    private function error($string)
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

    private function validateTable($table)
    {
        if($this->validateData($table))
        {
            return $table;
        }

        return $this->error('table');
    }
    
    private function bringTable($conect,$nameTable)
    {
        if($this->validateData($conect))
        {
            $dataTable = mysqli_query($conect,"SELECT * FROM {$nameTable}");
            $dataTable = $this->validateTable($dataTable);
            
            return $dataTable;
        }

        return $this->error('database');
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
    
    public function debug($attributes)
    {
        var_dump($attributes);
        exit;
    }
    
    public function bringDataTable($conect,$nameTable)
    {   
        $data = [];
        $dataTable = $this->bringTable($conect,$nameTable);

        if($this->validateData($dataTable))
        {
            $data = $this->addData($dataTable);
            return $data;
        }

        return $dataTable;
    }

    public function tablesAll($conect)
    {
        if($this->validateData($conect))
        {
            $OBJtablesAll = mysqli_query($conect,"SHOW TABLES");
    
            $tablesNoFormat = $this->addData($OBJtablesAll);
            $tablesAll = [];

            foreach($tablesNoFormat as $tables)
            {
                $index = $this->fetchIndex($tables);
                 array_push($tablesAll,$tables[$index[0]]);
            }

            return $tablesAll;
        }

        return $this->error('dataBase');
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

                    if(!$this->validateData($nameTable))
                    {
                        return $nameTable;
                    }
                    
                    $firstResult = $nameTable->fetch_array(MYSQLI_ASSOC);
                    $columns = $this->fetchIndex($firstResult);
                    return $columns;
                }
            }

            return $this->error('table');
        }
    }

    public function selectFrom($conect,$nameTable,$column,$data)
    {   
        if($this->validateData($conect))
        {
            $dataFound = mysqli_query($conect,"SELECT 
            * FROM {$nameTable} WHERE {$column} = {$data}");
            $dataFound = $this->validateTable($dataFound);
            
            if(!$this->validateData($dataFound))
            {
                return $dataFound;
            }
            
            $selectedData = $this->addData($dataFound);
            return $selectedData;
        }
        
        return $this->error('dataBase');
    }

    public function selectColumn($conect,$nameTable,$nameColumn)
    {
        if($this->validateData($conect))
        {
            $dataColumn = mysqli_query($conect,
            "SELECT {$nameColumn} from {$nameTable}");

            if(!$this->validateData($dataColumn))
            {
                return $this->error('table');
            }
            
            $data = $this->addData($dataColumn);
            return $data;
        }

        return $this->error('dataBase');
    }

    public function selectCondition($conect,$nameTable,$condition)
    {
        if($this->validateData($conect))
        {
            $command = "SELECT * FROM {$nameTable}
            where $condition";
    
            $dataTable = mysqli_query($conect,$command);
    
            if(!$this->validateData($dataTable))
            {
                return $this->error('table');
            }

            $data = $this->addData($dataTable);
            return $data;
        }

        return $this->error('dataBase');
    }

    public function queryAny($conect,$nameTable,$column,$var)
    {
        if($this->validateData($conect))
        {
            $dataTable = mysqli_query($conect,
            "SELECT * FROM {$nameTable} WHERE {$column} LIKE '%{$var}%'");
    
            if(!$this->validateData($dataTable))
            {
                return $this->error('table');
            }
    
            $data = $this->addData($dataTable);
            return $data;
        }
        
        return $this->error('dataBase');
    }

    public function createTable($conect,$nameTable,$parameters)
    {
        if($this->validateData($conect))
        {
            $newTable = mysqli_query($conect,"CREATE TABLE {$nameTable} 
            ($parameters);");

            $sms = $newTable ? 'Tabela criado com sucesso!' : 'Erro ao criar a tabela';
            return $sms;
        }
    }

    public function dropTable($conect,$nameTable)
    {
        $tablesAll = $this->tablesAll($conect);

        foreach($tablesAll as $tables)
        {
            if($tables == $nameTable)
            {
                $drop = mysqli_query($conect,"DROP TABLE {$nameTable}");
                var_dump($drop);

                $drop = $drop ? 'tabela apagado com sucesso!' : 'tabela não foi apagada';
                return $drop;
            }
        }
    }
}
?>