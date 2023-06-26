<?php 
require_once('ConsultProtected.php');
require_once('Sql.php');

class Consult extends ConsultProtected implements Sql
{  
    public function __construct($conect)
    {
        parent::__construct($conect);
    }
    
    public function allMethods()
    {
        try{

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

            throw new Exception($this->error('database'));
            
        }
        catch(Exception $exec)
        {
            $this->debug($exec->getMessage());
        }
    }

    public function checkPostRequest($name)
    {
        return !empty($_POST[$name]);
    }
    
    public function bringDataTable($nameTable)
    {   
        return $this->validateTable(mysqli_query($this->conect,"SELECT * FROM {$nameTable}"));
    }

    public function tablesAll()
    {   
        try
        {
            $tablesNames = [];

            foreach(mysqli_fetch_all(
            mysqli_query($this->conect,'SHOW TABLES'),MYSQLI_NUM) as $table)
            {   
                array_push($tablesNames, array_shift($table));                
            };
            
            return $tablesNames;

        }
        catch(Exception $exec)
        {
            $this->debug($exec->getMessage());
        }
    }

    public function nameColumns($nameTable)
    {
        try
        {
            $columns = [];
            foreach (mysqli_fetch_all(mysqli_query($this->conect, 'SHOW TABLES')) as $tables) 
            {   
                while($nameTable == array_shift($tables))
                {
                    $columns = mysqli_fetch_all(mysqli_query($this->conect, 
                    "SHOW COLUMNS FROM notas_fiscais"),MYSQLI_ASSOC);
                }
            }

            return empty($columns) ? $this->error('table') : $columns;

        } 
        catch(Exception $exec)
        {
            $this->debug($exec->getMessage());
        }
    }

    public function selectFrom($nameTable,$column,$data)
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

    public function selectColumn($nameTable,$nameColumn)
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

    public function selectCondition($nameTable,$condition)
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

    public function queryAny($nameTable,$column,$var)
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

    public function createTable($nameTable,$parameters)
    {
        $newTable = mysqli_query($this->conect,"CREATE TABLE {$nameTable} 
        ($parameters);");

        $sms = $newTable ? 'Tabela criado com sucesso!' : 'Erro ao criar a tabela';
        return $sms;
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

    public function orderBy($table,$data, $order)
    {
        try{
            $dataOrderBy = mysqli_query($this->conect,"SELECT * FROM $table
            ORDER BY $data $order");

            $dataOrderByArray = mysqli_fetch_all($dataOrderBy, MYSQLI_ASSOC);
            return $dataOrderByArray;

        } catch(Exception $exec)
        {
            $this->debug($exec->getMessage());
        }
    }
}
?>