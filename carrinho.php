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
    <title>Carrinho</title>
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
    
    <p><a href="listar.php">voltar</a>
    
    <table id="t01" border="1">
      <?php
        require 'conexao.php';
        extract($_GET);
        extract($_POST, EXTR_SKIP);

        $id_carrinho = isset($_GET["id_carrinho"])    ? $_GET["id_carrinho"]    : "";
        $id_produto  = isset($_POST["id_produto"])    ? $_POST["id_produto"]    : "";
        $id_cliente  = isset($_SESSION["id_cliente"]) ? $_SESSION["id_cliente"] : "";
        $nome        = isset($_POST["nome"])          ? $_POST["nome"]          : "";
        $preco       = isset($_POST["preco"])         ? $_POST["preco"]         : "";
        $quantidade  = isset($_POST["quantidade"])    ? $_POST["quantidade"]    : "";
        $subtotal    = isset($_POST["subtotal"])      ? $_POST["subtotal"]      : "";

        if ($id_produto) {
          if ($conexao) {
            $sql_cria  = "INSERT INTO carrinho
                          VALUES (NULL, {$id_cliente},
                                        {$id_produto},
                                       '{$nome}',
                                        {$preco},
                                        {$quantidade},
                                        {$preco}*{$quantidade})";
          }
          else {
            exit("<p>Falha na conexão: " . mysqli_connect_error());
          }

          if (mysqli_query($conexao, $sql_cria)) {
            echo "<p>Linha inserida com sucesso!";
          } 
          else {
            echo "<p>Erro ao inserir:<br>" .
            $sql_cria . "<br>" . mysqli_error($conexao);
          }
        }

        $adicionar = isset($_GET["adicionar"]) ? $_GET["adicionar"] : "";

        if ($adicionar==true) {
          $sql_adiciona_quantidade  = "UPDATE carrinho
                                       SET quantidade = quantidade + 1
                                       WHERE id_carrinho = {$id_carrinho}";
          if (mysqli_query($conexao, $sql_adiciona_quantidade)) {echo "<p><br>";}
          else {
            echo "<p>Erro ao aumentar quantidade:<br>" .
            $sql_adiciona_quantidade. "<br>" . mysqli_error($conexao);
          }
        }

        $reduzir = isset($_GET["reduzir"]) ? $_GET["reduzir"] : "";

        if ($reduzir==true) {
          $sql_reduz_quantidade  = "UPDATE carrinho
                                    SET quantidade = quantidade - 1
                                    WHERE id_carrinho = {$id_carrinho}";
          if (mysqli_query($conexao, $sql_reduz_quantidade)) {echo "<p><br>";}
          else {
            echo "<p>Erro ao reduzir quantidade:<br>" .
            $sql_reduz_quantidade. "<br>" . mysqli_error($conexao);
          }
        }

        $excluir = isset($_GET["excluir"]) ? $_GET["excluir"] : "";

        if ($excluir==true) {
          $sql_deleta  = "DELETE FROM carrinho 
                          WHERE id_carrinho = {$id_carrinho} 
                          LIMIT 1";
          if (mysqli_query($conexao, $sql_deleta) &&
              mysqli_affected_rows($conexao) == 1) {
            echo "<p>Registro deletado com successo!";
          }
          else {
            echo "<p>Erro ao deletar:<br>" .
            $sql_deleta. "<br>" . mysqli_error($conexao);
          }
        }

        $limpar = isset($_GET["limpar"]) ? $_GET["limpar"] : "";

        if ($limpar==true) {
          $sql_limpa  = "DELETE
                         FROM carrinho
                         WHERE id_cliente = {$id_cliente}";
          if (mysqli_query($conexao, $sql_limpa)) {
            echo "<p>Carrinho vazio!";
          }
          else {
            echo "<p>Erro ao limpar carrinho:<br>" .
            $sql_limpa. "<br>" . mysqli_error($conexao);
          }
        }

        if ($adicionar==true || $reduzir==true) {
          $sql_calcula_subtotal = "UPDATE carrinho
                                   SET subtotal = preco * quantidade
                                   WHERE id_carrinho = {$id_carrinho}";
          if (mysqli_query($conexao, $sql_calcula_subtotal)) {}
          else {
            echo "<p>Erro ao calcular subtotal:<br>" .
            $sql_calcula_subtotal. "<br>" . mysqli_error($conexao);
          }
        }

        $sql_leitura  = "SELECT * FROM carrinho
                         WHERE id_cliente = {$id_cliente}
                         GROUP BY id_produto
                         ORDER BY id_carrinho ASC";

        $produtos = mysqli_query($conexao, $sql_leitura);
        
        $sql_calcula_total = "SELECT SUM(subtotal)
                              AS total
                              FROM carrinho_groupby
                              WHERE id_cliente = {$id_cliente}";

        $total = mysqli_fetch_assoc(mysqli_query($conexao, $sql_calcula_total));

      ?>
      <tr><p>
        <th>id</th>
        <th>id_produto</th>
        <th>nome</th>
        <th>preço</th>
        <th>quantidade</th>
        <th>subtotal</th>
        <th colspan="3">ações</th>
      </tr>
      
      <?php
        $linha = 0;
        while($produto = mysqli_fetch_assoc($produtos)):
      ?>
          <tr>
            <td><?= $produto["id_carrinho"]?></td>
            <td><?= $produto["id_produto"] ?></td>
            <td><?= $produto["nome"]       ?></td>
            <td><?= $produto["preco"]      ?></td>
            <td><?= $produto["quantidade"] ?></td>
            <td><?= $produto["subtotal"]   ?></td>
            <td>
              <form accept-charset="utf-8" method=GET action='carrinho.php'>
                <input type="hidden" name="adicionar"   value=true>
                <input type="hidden" name="id_carrinho" value=<?= $produto["id_carrinho"]?>>
                <input type="submit" value="+">
              </form>
            </td>
            <td>
              <form accept-charset="utf-8" method=GET action='carrinho.php'>
                <input type="hidden" name="reduzir"     value=true>
                <input type="hidden" name="id_carrinho" value=<?= $produto["id_carrinho"]?>>
                <input type="submit" value="-">
              </form>
            </td>
            <td>
              <form accept-charset="utf-8" method=GET action='carrinho.php'>
                <input type="hidden" name="excluir"     value=true>
                <input type="hidden" name="id_carrinho" value=<?= $produto["id_carrinho"]?>>
                <input type="submit" value="deletar">
              </form>
            </td>
          </tr>
      <?php
          $linha++;
        endwhile;
      ?>
      <p>
      <tr>
        <th colspan="5">TOTAL</th>
        <th><?= "R$ ".$total["total"] ?></th>
      </tr>
    </table>
    <p>
    <form accept-charset="utf-8" method=GET action='carrinho.php'>
        <input type="hidden" name="limpar"      value=true>
        <input type="hidden" name="id_cliente"  value=<?= $produto["id_cliente"]?>>
        <input type="submit" value="limpar carrinho">
    </form>
      <?php
        mysqli_close($conexao);
      ?>
  </body>
</html>
