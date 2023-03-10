<?php 
    include_once('config.php');
    include_once('Consult.php');
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
    if(!empty($conect))
    {
        ?>
        <div>
            <h2>Tabelas</h2>
            <?php 
            $consult = new Consult();
            $nameTables = $consult->tablesAll($conect);
            foreach($nameTables as $name)
            {
                ?>
                <p><?=$name ?></p>
                <?php 
            }
            ?>
        </div>
        
        <select name="" id="">
            <option value="">Nome</option>
            <option value="">Endereco</option>
        </select>

        <div>
            <?php
            if(!empty($_POST['nomeTabela']))
            {
                var_dump($conect);
                $dataTable = $consult->bringDataTable($conect,$_POST['nomeTabela']);
            } 
            ?>

            <h2>Conectar Tabela</h2>

            <form action="" method="POST">
                <input type="text" name="nomeTabela" placeholder="nome da tabela">
                <button>Verificar Dados</button>
            </form>
            <?php
            if(!empty($dataTable))
            {
                foreach($dataTable as $data)
                {
                   var_dump($data);
                }
            }
        }
        else{
            echo 'error';
        }
            ?>
        </div>
</body>
</html>
