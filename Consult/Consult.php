<?php 
require_once('ConsultProtected.php');

class Consult extends ConsultProtected
{  
    public function __construct($conect)
    {
        parent::__construct($conect);
    }
    
    public function debug($attributes)
    {
        var_dump($attributes);
        exit;
    }

    public function allMethods()
    {
        try{
            if($this->databaseConected())
            {
                $mysqli = new mysqli();
                $consultMethods = get_class_methods(new Consult($mysqli));
                $protectedMethods =  get_class_methods(new ConsultProtected($mysqli));
        
                $sizeM = count($consultMethods);
                $sizeP = count($protectedMethods);
                $methodsConsultPublic = [];
        
                for($i=0; $i < ($sizeM - $sizeP); $i++)
                {
                    array_push($methodsConsultPublic,$consultMethods[$i]);
                }
        
                return $methodsConsultPublic;
            }

            throw new Exception($this->error('database'));
            
        }
        catch(Exception $exec)
        {
            $this->debug($exec->getMessage());
        }
    }

    public function checkGet($name)
    {
        return !empty($_POST[$name]);
    }
    
    public function bringDataTable($nameTable)
    {   
        $data = [];
        $dataTable = $this->bringTable($this->conect,$nameTable);

        if($this->validateData($dataTable))
        {
            $data = $this->addData($dataTable);
            return $data;
        }

        return $dataTable;
    }

    public function tablesAll()
    {   
        try
        {
            if($this->databaseConected())
            {
                $OBJtablesAll = mysqli_query($this->conect,"SHOW TABLES");
        
                $tablesNoFormat = $this->addData($OBJtablesAll);
                $tablesAll = [];
    
                foreach($tablesNoFormat as $tables)
                {
                    $index = $this->fetchIndex($tables);
                     array_push($tablesAll,$tables[$index[0]]);
                }
    
                return $tablesAll;
            }
    
            throw new Exception($this->error('database'));
        }
        catch(Exception $exec)
        {
            $this->debug($exec->getMessage());
        }
    }

    public function nameColumns($nameTable)
    {
        $tablesAll = $this->tablesAll($this->conect);
        
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
                    $nameTable = $this->bringTable($this->conect,$nameTable);

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

    public function selectFrom($nameTable,$column,$data)
    {   
        if($this->databaseConected())
        {
            $dataFound = mysqli_query($this->conect,"SELECT 
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

    public function selectColumn($nameTable,$nameColumn)
    {
        if($this->databaseConected())
        {
            $dataColumn = mysqli_query($this->conect,
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

    public function selectCondition($nameTable,$condition)
    {
        if($this->databaseConected())
        {
            $command = "SELECT * FROM {$nameTable}
            where $condition";
    
            $dataTable = mysqli_query($this->conect,$command);
    
            if(!$this->validateData($dataTable))
            {
                return $this->error('table');
            }

            $data = $this->addData($dataTable);
            return $data;
        }

        return $this->error('dataBase');
    }

    public function queryAny($nameTable,$column,$var)
    {
        if($this->databaseConected())
        {
            $dataTable = mysqli_query($this->conect,
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

    public function createTable($nameTable,$parameters)
    {
        if($this->databaseConected())
        {
            $newTable = mysqli_query($this->conect,"CREATE TABLE {$nameTable} 
            ($parameters);");

            $sms = $newTable ? 'Tabela criado com sucesso!' : 'Erro ao criar a tabela';
            return $sms;
        }
    }

    public function dropTable($nameTable)
    {
        $tablesAll = $this->tablesAll($this->conect);

        foreach($tablesAll as $tables)
        {
            if($tables == $nameTable)
            {
                $drop = mysqli_query($this->conect,"DROP TABLE {$nameTable}");
                var_dump($drop);

                $drop = $drop ? 'tabela apagado com sucesso!' : 'tabela não foi apagada';
                return $drop;
            }
        }
    }
}
?>