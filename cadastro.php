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
    <p><a href="index.php">sair</a>
    <form accept-charset="utf-8" method=POST action="cadastro.php">
      <b>Nome:     <br><input type="text"     name="nome"   ><p>
         E-mail:   <br><input type="text"     name="email"  ><p>
         Login:    <br><input type="text"     name="login"  ><p>
         Senha:</b><br><input type="password" name="senha"  ><p>
                       <input type="submit"   value="Gravar">
    </form>
    <?php
      require 'conexao.php';
      extract($_POST, EXTR_SKIP);

      $nome  = isset($_POST["nome"])  ?     $_POST["nome"]   : "";
      $email = isset($_POST["email"]) ?     $_POST["email"]  : "";
      $login = isset($_POST["login"]) ?     $_POST["login"]  : "";
      $senha = isset($_POST["senha"]) ? md5($_POST["senha"]) : "";

      if ($nome && $email && $login && $senha) {
        if ($conexao) {
          $sql_cria  = "INSERT INTO clientes 
                        VALUES (NULL, '{$nome}', '{$email}', '{$login}', '{$senha}')";
        }
        else {
          exit("<p>Falha na conexão: " . mysqli_connect_error());
        }

        if (mysqli_query($conexao, $sql_cria)) {
          echo "<p>Cadastrado(a) com sucesso!";
        } 
        else {
          echo "<p>Erro ao inserir:<br>" .
          $sql_cria . "<br>" . mysqli_error($conexao);
        }
      }
      mysqli_close($conexao);
    ?>
  </body>
</html>