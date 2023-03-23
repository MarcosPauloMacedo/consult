<?php 
require_once('ConsultProtected.php');

class Consult extends ConsultProtected
{  
    public function allMethods()
    {
        $consultMethods = get_class_methods(new Consult);
        $protectedMethods =  get_class_methods(new ConsultProtected);
        
        $key = array_search($consultMethods,$protectedMethods,true);
        // if($kei !== )

        // foreach($consultMethods as $consult)
        // {
        //     foreach($protectedMethods as $protected)
        //     {
        //         if($consult == $protected)
        //         {
                    
        //         }
        //     }
        // }
    }

    public function checkGet($name)
    {
        return !empty($_POST[$name]);
    }

    public function numberFunctions($obj)
    {
        array_push($functionsAll,$obj);
        
        $functionsAll = [];
        return $functionsAll;
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
                if($nameTable == $table)
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