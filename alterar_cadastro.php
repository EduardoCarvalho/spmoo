<?php
  extract($_REQUEST);
  session_start();
  if (isset($_SESSION["login"]) == false) {
      header("Location: index.php");
      return;
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" type="text/css" href="tema.css">
  </head>
  <body>
    <nav id="navigation" class="clearfix">
      <ul>
        <li><a href="index.php"   >Home    </a></li>
        <li><a href="listar.php"  >Listar  </a></li>
        <li><a href="busca.php"   >Buscar  </a></li>
        <li><a href="carrinho.php">Carrinho</a></li>
      </ul>
    </nav>
    <div align="right">
        <a href="ler_cadastro.php"><?= $_SESSION["login"]. ","?></a>
        <a href="logout.php"> sair</a>
    </div>
    
    <form>
      <b>Nome:     <br><input  type="text"     name="nome"  value="<?= $nome  ?>"><p>
         E-mail:   <br><input  type="text"     name="email" value="<?= $email ?>"><p>
         Login:    <br><input  type="text"     name="login" value="<?= $login ?>"><p>
         Senha:</b><br><input  type="password" name="senha" value=""             ><p>
                       <button type="button" disabled>Alterar</button>
    </form>
    
    <?php
      require 'conexao.php';
      extract($_POST, EXTR_SKIP);

      $id_cliente = isset($_SESSION["id_cliente"]) ?     $_SESSION["id_cliente"] : "";
      $nome       = isset($_POST["nome"])          ?     $_POST["nome"]          : "";
      $email      = isset($_POST["email"])         ?     $_POST["email"]         : "";
      $login      = isset($_POST["login"])         ?     $_POST["login"]         : "";
      $senha      = isset($_POST["senha"])         ? md5($_POST["senha"])        : "";

      if ($conexao) {
        $sql_altera  = "UPDATE clientes
                        SET nome='{$nome}',
                            email='{$email}',
                            login='{$login}',
                            senha='{$senha}'
                        WHERE id_cliente = {$id_cliente}";
      }
      else {
        exit("<p>Falha na conexão: " . mysqli_connect_error());
      }

      if (mysqli_query($conexao, $sql_altera)) {
        echo "Registro alterado com sucesso!";
      }
      else {
        echo "Erro ao alterar registro: " . mysqli_error($conexao);
      }
      
      mysqli_close($conexao);
    ?>
  </body>
</html>