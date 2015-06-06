<?php
    header('Content-type: text/html; charset=UTF-8');
    
    $conexao = mysqli_connect("localhost",
                              "root",
                              "senharoot",
                              "supermercado");

    mysqli_set_charset($conexao, 'utf8');
?>