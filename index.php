<?php 
    include_once('Config/config.php');
    include_once('Consult/Consult.php');
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MYSQL</title>
</head>
<body>
    <h1>MYSQL</h1>
    <?php 
    if(!empty($conect)){
        ?>
        <div>
            <h2>Tabelas</h2>
            <?php 
                $consult = new Consult($conect);
                $nameTables = $consult->tablesAll();
                $methodsAll = $consult->allMethods();
                var_dump($methodsAll);
                
                foreach($nameTables as $name):
                    ?>
                <p><?=$name?></p>
                <?php 
                endforeach;
                ?>
        </div>
        
        <?php var_dump($consult->conect()); ?>
        <h2>Funções</h2>
        <select name="" id="">
            <?php 
                $methodsAll = $consult->allMethods();
                foreach($methodsAll as $methods)
                {
                    ?>

                    <option value=""><?=$methods?></option>

                    <?php
                }
            ?>
        </select>

        <div>
            <h2>Conectar Tabela</h2>

            <form action="" method="POST">
                <input type="text" name="nomeTabela" placeholder="nome da tabela">
                <button>Verificar Dados</button>
            </form>
            <?php
            if($consult->checkGet('nomeTabela')):
                $nameTable = $_POST['nomeTabela'];

                $dataTable = $consult->bringDataTable($nameTable);
                
                if(gettype($dataTable) == 'array'):
                    $columns = $consult->nameColumns($conect,$nameTable);
                    ?>
                        <table>
                            <thead>
                                <?php
                                foreach($columns as $column):
                                ?>
                                    <th><?=$column?></th>
                                <?php
                                endforeach;
                                ?>

                            </thead>
                            <?php
                                foreach($dataTable as $data):
                            ?>
                                <tbody>
                                    <?php
                                    foreach($data as $dat)
                                    {
                                    ?>
                                        <td><?=$dat?></td>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <?php
                                endforeach;
                                ?>
                        </table>
                    <?php
                endif;
            endif;
            
            ?>
        </div>
    <?php
    }else
    {
        echo 'error';
    }
    ?>
</body>
</html>
