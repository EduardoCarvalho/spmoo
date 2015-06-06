<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
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
            <p>
            <?php 
              extract($_GET);

              $erro = isset($_GET["erro"]) ? $_GET["erro"] : "";
              
              if ($erro==true) {
                echo "Senha incorreta ou usuário não cadastrado.";
              }
            ?>
            <form action="validacao.php" method=POST>
            Login: <input type="text"     name="login"><p>
            Senha: <input type="password" name="senha"><p>
                   <input type="submit"   value="Entrar">
                   <input formaction="cadastro.php"
                          formmethod=POST
                          type="submit"
                          value="Cadastrar">
            </form>
            <img src="/supermercado/Imagens/home1.png"
                 alt="carrinho"
                 width=220
                 height=180>
        </center>
    </body>
</html>