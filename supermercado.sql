-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 05-Jun-2015 às 19:26
-- Versão do servidor: 5.5.43-0ubuntu0.14.04.1
-- versão do PHP: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `supermercado`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho`
--

CREATE TABLE IF NOT EXISTS `carrinho` (
  `id_carrinho` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(5,2) NOT NULL,
  `quantidade` int(11) unsigned NOT NULL,
  `subtotal` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id_carrinho`),
  KEY `id_produto` (`id_produto`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

--
-- RELATIONS FOR TABLE `carrinho`:
--   `id_produto`
--       `produtos` -> `id_produto`
--   `id_cliente`
--       `clientes` -> `id_cliente`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `carrinho_groupby`
--
CREATE TABLE IF NOT EXISTS `carrinho_groupby` (
`id_carrinho` int(11)
,`id_cliente` int(11)
,`id_produto` int(11)
,`nome` varchar(100)
,`preco` decimal(5,2)
,`quantidade` int(11) unsigned
,`subtotal` decimal(6,2)
);
-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `login` varchar(100) NOT NULL,
  `senha` char(32) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(5,2) NOT NULL,
  `imagem` varchar(150) NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome`, `preco`, `imagem`) VALUES
(28, 'Biscoito', 2.00, '/supermercado/Imagens/Fotos/02.png'),
(29, 'Bolo', 18.00, '/supermercado/Imagens/Fotos/05.png'),
(30, 'Laranja', 4.50, '/supermercado/Imagens/Fotos/03.png'),
(31, 'Pizza', 14.00, '/supermercado/Imagens/Fotos/01.png'),
(32, 'Leite', 2.80, '/supermercado/Imagens/Fotos/04.png'),
(33, 'Chá', 2.50, '/supermercado/Imagens/Fotos/06.png'),
(34, 'Café', 4.00, '/supermercado/Imagens/Fotos/08.png'),
(35, 'Carne', 27.00, '/supermercado/Imagens/Fotos/09.png'),
(36, 'Cebola', 3.00, '/supermercado/Imagens/Fotos/10.png'),
(37, 'Ovo', 3.70, '/supermercado/Imagens/Fotos/11.png'),
(38, 'Salsicha', 8.30, '/supermercado/Imagens/Fotos/12.png'),
(39, 'Melancia', 8.00, '/supermercado/Imagens/Fotos/13.png'),
(40, 'Salame', 7.00, '/supermercado/Imagens/Fotos/14.png'),
(41, 'Abacaxi', 6.70, '/supermercado/Imagens/Fotos/15.png'),
(42, 'Sanduíche', 5.70, '/supermercado/Imagens/Fotos/16.png'),
(43, 'Peixe', 12.00, '/supermercado/Imagens/Fotos/17.png'),
(44, 'Sorvete', 9.70, '/supermercado/Imagens/Fotos/18.png'),
(45, 'Pão de forma', 4.50, '/supermercado/Imagens/Fotos/19.png'),
(46, 'Tomate', 2.90, '/supermercado/Imagens/Fotos/20.png'),
(47, 'Queijo', 8.50, '/supermercado/Imagens/Fotos/07.png'),
(48, 'Chocolate', 4.70, '/supermercado/Imagens/Fotos/21.png'),
(49, 'Baguete', 1.50, '/supermercado/Imagens/Fotos/22.png'),
(50, 'Linguiça', 16.00, '/supermercado/Imagens/Fotos/23.png'),
(51, 'Batata', 3.10, '/supermercado/Imagens/Fotos/24.png'),
(52, 'Bisnaguinha', 2.00, '/supermercado/Imagens/Fotos/25.png'),
(53, 'Mortadela', 7.00, '/supermercado/Imagens/Fotos/26.png'),
(54, 'Alface', 2.40, '/supermercado/Imagens/Fotos/27.png ');

-- --------------------------------------------------------

--
-- Structure for view `carrinho_groupby`
--
DROP TABLE IF EXISTS `carrinho_groupby`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `carrinho_groupby` AS select `carrinho`.`id_carrinho` AS `id_carrinho`,`carrinho`.`id_cliente` AS `id_cliente`,`carrinho`.`id_produto` AS `id_produto`,`carrinho`.`nome` AS `nome`,`carrinho`.`preco` AS `preco`,`carrinho`.`quantidade` AS `quantidade`,`carrinho`.`subtotal` AS `subtotal` from `carrinho` where (`carrinho`.`id_cliente` = `carrinho`.`id_cliente`) group by `carrinho`.`id_produto`;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`),
  ADD CONSTRAINT `carrinho_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
