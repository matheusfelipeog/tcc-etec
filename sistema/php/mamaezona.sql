-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 12-Nov-2019 às 20:18
-- Versão do servidor: 5.7.24
-- versão do PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mamaezona`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_bin NOT NULL,
  `situacao` varchar(255) COLLATE utf8_bin NOT NULL,
  `divida` decimal(6,2) NOT NULL,
  `tipo` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` varchar(255) COLLATE utf8_bin NOT NULL,
  `data_cadastro` date DEFAULT NULL,
  `descricao` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id`, `nome`, `situacao`, `divida`, `tipo`, `status`, `data_cadastro`, `descricao`) VALUES
(2, 'brenda', 'Em aberto', 1000.00, 'Mensal', 'Ativo', '2010-10-20', 'Outra descrição qualquer aqui'),
(3, 'Escanor do sol nascente', 'Em dia', 0.00,'Comum', 'Ativo', '2005-04-12', 'Mais uma descrição qualquer aqui'),
(4, 'Sasuke uchiha', 'Em débito', 240.00, 'Mensal', 'Desativo', '2009-12-12', 'Uma descrição qualquer aqui'),
(7, 'Escanor do sol nascente', 'Em dia', 0.00,'Comum', 'Ativo', '2005-04-12', 'Mais uma descrição qualquer aqui'),
(8, 'Sasuke uchiha', 'Em débito', 50.00,'Mensal', 'Desativo', '2009-12-12', 'Uma descrição qualquer aqui'),
(9, 'matheus', 'Em dia', 0.00,'Mensal', 'Ativo', '2011-12-20', 'Uma descrição qualquer aqui'),
(10, 'brenda', 'Em aberto', 25.00,'Mensal', 'Ativo', '2010-10-20', 'Outra descrição qualquer aqui'),
(11, 'Escanor do sol nascente', 'Em dia', 0.00,'Comum', 'Ativo', '2005-04-12', 'Mais uma descrição qualquer aqui'),
(12, 'Sasuke uchiha', 'Em débito', 100.00,'Mensal', 'Desativo', '2009-12-12', 'Uma descrição qualquer aqui'),
(13, 'matheus', 'Em dia', 0.00,'Mensal', 'Ativo', '2011-12-20', 'Uma descrição qualquer aqui'),
(14, 'brenda', 'Em aberto', 20.00,'Mensal', 'Ativo', '2010-10-20', 'Outra descrição qualquer aqui');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

DROP TABLE IF EXISTS `estoque`;
CREATE TABLE IF NOT EXISTS `estoque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_bin NOT NULL,
  `marca` varchar(255) COLLATE utf8_bin NOT NULL,
  `tipo` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` varchar(255) COLLATE utf8_bin NOT NULL,
  `quantidade` int(11) NOT NULL,
  `quantidade_minima` int(11) NOT NULL,
  `custo` decimal(6,2) NOT NULL,
  `preco` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `estoque`
--

INSERT INTO `estoque` (`id`, `nome`, `marca`, `tipo`, `status`, `quantidade`, `quantidade_minima`, `custo`, `preco`) VALUES
(64, 'Bala', 'fini', 'Comum', 'Ativo', 30, 10, 0.50, 1.0),
(56, 'Bolacha', 'Negresco', 'Comum', 'Ativo', 30, 15, 2.00, 3.00),
(66, 'Boca', 'coca-cola', 'Comum', 'Ativo', 50, 10, 4.50, 6.00),
(59, 'Macarrão', 'marca Y', 'Preparo', 'Desativo', 60, 60, 2.00, 3.00),
(60, 'Bala', 'Big', 'Comum', 'Ativo', 30, 10, 0.50, 1.00),
(61, 'arroz', 'prato fino', 'Interno', 'Desativo', 20, 15, 4.50, 6.00),
(54, 'Coca-Cola', 'Coca-Cola', 'Comum', 'Ativo', 50, 20, 4.50, 6.00),
(65, 'Feijão', 'Prato Fino', 'Interno', 'Desativo', 20, 10, 4.50, 6.00),
(67, 'Macarrão', 'marca X', 'Preparo', 'Desativo', 60, 60, 2.00, 3.00),
(68, 'Biscoito', 'Marca X', 'Comum', 'Ativo', 30, 15, 0.50, 1.00),
(69, 'Feijoada', 'prato fino', 'Preparo', 'Desativo', 20, 10, 4.50, 6.00),
(70, 'Dolly', 'Dolly', 'Comum', 'Ativo', 50, 10, 4.50, 6.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_bin NOT NULL,
  `marca` varchar(255) COLLATE utf8_bin NOT NULL,
  `tipo` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` varchar(255) COLLATE utf8_bin NOT NULL,
  `quantidade` int(11) NOT NULL,
  `quantidade_minima` int(11) NOT NULL,
  `custo` decimal(6,2) NOT NULL,
  `preco` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `nome`, `marca`, `tipo`, `status`, `quantidade`, `quantidade_minima`, `custo`, `preco`) VALUES
(64, 'Bala', 'fini', 'Comum', 'Ativo', 30, 10, 0.50, 1.0),
(56, 'Bolacha', 'Negresco', 'Comum', 'Ativo', 30, 15, 2.00, 3.00),
(66, 'Boca', 'coca-cola', 'Comum', 'Ativo', 50, 10, 4.50, 6.00),
(59, 'Macarrão', 'marca Y', 'Preparo', 'Desativo', 60, 60, 2.00, 3.00),
(60, 'Bala', 'Big', 'Comum', 'Ativo', 30, 10, 0.50, 1.00),
(61, 'arroz', 'prato fino', 'Interno', 'Desativo', 20, 15, 4.50, 6.00),
(54, 'Coca-Cola', 'Coca-Cola', 'Comum', 'Ativo', 50, 20, 4.50, 6.00),
(65, 'Feijão', 'Prato Fino', 'Interno', 'Desativo', 20, 10, 4.50, 6.00),
(67, 'Macarrão', 'marca X', 'Preparo', 'Desativo', 60, 60, 2.00, 3.00),
(68, 'Biscoito', 'Marca X', 'Comum', 'Ativo', 30, 15, 0.50, 1.00),
(69, 'Feijoada', 'prato fino', 'Preparo', 'Desativo', 20, 10, 4.50, 6.00),
(70, 'Dolly', 'Dolly', 'Comum', 'Ativo', 50, 10, 4.50, 6.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cozinha`
--

DROP TABLE IF EXISTS `cozinha`;
CREATE TABLE IF NOT EXISTS `cozinha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_pedido` varchar(255) COLLATE utf8_bin NOT NULL,
  `status_pedido` varchar(255) COLLATE utf8_bin NOT NULL,
  `path_img_pedido` varchar(255) COLLATE utf8_bin NOT NULL,
  `quantia_pedido` INT(11) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `cozinha` (`id`, `nome_pedido`, `quantia_pedido`, `status_pedido`, `path_img_pedido`) VALUES
(59, 'Macarrão', 2, 'Preparo', '../../img/produto/macarrao.jpg'),
(67, 'Lasanha', 1, 'Preparo', '../../img/produto/lasanha.jpg'),
(69, 'Feijoada P', 2, 'Preparo', '../../img/produts/feijoada.jpg'),
(70, 'Feijoada M', 1, 'Preparo', '../../img/produto/feijoada.jpg'),
(71, 'Feijoada G', 2, 'Preparo', '../../img/produto/feijoada.jpg'),
(72, 'Arroz e Feijão', 3, 'Preparo', '../../img/produto/feijao_com_arroz.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
