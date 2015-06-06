<?php
    extract($_POST, EXTR_PREFIX_ALL);
    session_start();

    $login =     $_POST["login"];
    $senha = md5($_POST["senha"]);

    require 'conexao.php';

    if ($conexao) {
        $sql_verifica_usuario  = "SELECT * FROM clientes 
                                  WHERE login='{$login}' 
                                  AND senha='{$senha}'";
    }
    else {
        exit("Falha na conexão: " . mysqli_connect_error());
    }

    $resultado = mysqli_query($conexao, $sql_verifica_usuario);
    $linha = mysqli_num_rows($resultado);

    if ($linha == 1):
        header("Location: listar.php");
        $_SESSION["login"]      = $login;
        $_SESSION["id_cliente"] = mysqli_fetch_assoc($resultado)["id_cliente"];
    else:
        header("Location: index.php?erro=true");
    endif;

    mysqli_close($conexao);
?>