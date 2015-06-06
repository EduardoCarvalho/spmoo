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
    <title>Busca</title>
    <link rel="stylesheet" type="text/css" href="tema.css">
  </head>
  <body>
    <center>
      
      <nav id="navigation" class="clearfix">
        <ul>
          <li><a href="index.php"   >Home    </a></li>
          <li><a href="listar.php"  >Listar  </a></li>
          <li><a href="busca.php"   >Buscar  </a></li>
          <li><a href="carrinho.php">Carrinho</a></li>
        </ul>
      </nav>
      
      <div align="right">
        <a href="ler_cadastro.php"><?php echo $_SESSION["login"]. ","; ?></a>
        <a href="logout.php"> sair</a>
      </div>

      <form method=POST action="busca.php">
        <input type="text"   name="termo" size="20">
        <input type="submit" name="busca" value="Buscar" >
      </form>
      
      <table width="70%">
        <?php
          require 'conexao.php';
          extract($_POST, EXTR_SKIP);
          
          $termo = isset($_POST["termo"]) ? $_POST["termo"] : "";

          if ($conexao) {
            $sql_busca = "SELECT * FROM produtos WHERE nome LIKE '%$termo%'";
          }
          else {
            exit("Falha na conexão: " . mysqli_connect_error());
          }

          $resultado = mysqli_query($conexao, $sql_busca);

          $linha = 0;
          while($produto = mysqli_fetch_assoc($resultado)):
            if ($linha%3==0)
              echo "<tr>";
        ?>
            <p><th>
              <form accept-charset="utf-8" method=POST action="carrinho.php">
                <input type="hidden"
                       name="id_produto"
                       value="<?= $produto["id_produto"]?>">
                <input type="hidden"
                       name="nome"
                       value="<?= $produto["nome"]?>">
                <label for="nome"><?= $produto["nome"]?></label>
                <input type="image"
                       src="/supermercado/Imagens/Add.png"
                       width=12
                       height=12>
                <input type="hidden"
                       name="preco"
                       value="<?php echo $produto["preco"];?>">
                <input type="hidden"
                       name="quantidade"
                       value=1><br>
                <label for="preco"><?= "R$ ".$produto["preco"]?></label>
              </form>
              <img src="<?= $produto["imagem"]?>" width=180 height=180>
            </th>
        <?php
            $linha++;
            if ($linha%3==0)
              echo "</tr>";
          endwhile;
          mysqli_close($conexao);
        ?>
      </table>
    </center>
  </body>
</html>