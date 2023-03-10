<?php

    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dataBase = 'sucos_vendas';

    $conect = new mysqli($host,$user,$password,$dataBase);

    if($conect -> connect_errno)
    {
        echo 'error';
    }
    else
    {
        echo 'Banco de dados conectado com sucesso!';
    }


