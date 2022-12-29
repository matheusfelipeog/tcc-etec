-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           5.7.24 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para mamaezona
CREATE DATABASE IF NOT EXISTS `mamaezona` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `mamaezona`;

-- Copiando estrutura para tabela mamaezona.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(45) COLLATE utf8_bin NOT NULL,
  `situacao` varchar(9) COLLATE utf8_bin NOT NULL DEFAULT 'P' COMMENT 'Diz se o cliente tem dividas ativas.',
  `descricao` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `data_cliente` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data do cadastro do cliente',
  `status_cliente` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT 'Ativo' COMMENT 'Diz se o cliente está ativo ou desativo',
  `tipo_cliente` varchar(6) COLLATE utf8_bin NOT NULL DEFAULT 'Comum' COMMENT 'se o cliente é mensal ou comum',
  `credito` decimal(6,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Salva os clientes.\\\\nstatus representa se o cliente está ativo ou desativo.';

-- Copiando dados para a tabela mamaezona.cliente: ~21 rows (aproximadamente)
DELETE FROM `cliente`;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` (`id_cliente`, `nome_cliente`, `situacao`, `descricao`, `data_cliente`, `status_cliente`, `tipo_cliente`, `credito`) VALUES
	(2, 'Patrick', 'Em dia', 'Rua de Trás', '2019-11-15 00:48:56', 'Desativo', 'Comum', 0.00),
	(3, 'Ex Matheus', 'Em dia', 'Rua de trás, que mora na rua de cima', '2019-11-15 00:48:56', 'Desativo', 'Mensal', 0.00),
	(4, 'Barth', 'Em dia', 'Mudei para o nakamura', '2019-11-15 00:48:56', 'Desativo', 'Mensal', 0.00),
	(5, 'Nanatsu', 'Em dia', 'Nunca nem vi esse', '2019-11-16 15:28:57', 'Desativo', 'Comum', 0.00),
	(6, 'Absolver', 'Em dia', 'Rua de Trás', '2019-11-16 15:29:29', 'Ativo', 'Mensal', 22.50),
	(7, 'Naruto Ukumaki', 'Em dia', 'Sou um ninja', '2019-11-16 18:32:51', 'Ativo', 'Comum', 0.00),
	(8, 'Sakura', 'Em dia', 'Cade o sasuke', '2019-11-16 18:36:28', 'Ativo', 'Comum', 0.00),
	(9, 'Kakashi', 'Em dia', 'Ninja dos mil jutsus', '2019-11-16 18:54:59', 'Desativo', 'Comum', 0.00),
	(10, 'Garra', 'Em dia', 'Mizukake', '2019-11-16 18:56:31', 'Desativo', 'Mensal', 0.00),
	(11, 'Ben Dez', 'Em dia', 'SOu o bennn', '2019-11-16 18:57:44', 'Ativo', 'Mensal', 0.00),
	(12, 'Escanor do sol nascente', 'Em dia', 'Quem decide sou eu!', '2019-11-16 19:00:08', 'Ativo', 'Comum', 0.00),
	(13, 'Manus', 'Em dia', 'No fundo do abismo', '2019-11-16 19:26:50', 'Desativo', 'Comum', 0.00),
	(14, 'Tony Stark', 'Em dia', 'I am Iron Man', '2019-11-16 19:32:32', 'Desativo', 'Mensal', 0.00),
	(15, 'Justiceiro', 'Em dia', 'EU mato todo mundo mesmo', '2019-11-16 19:35:45', 'Desativo', 'Comum', 0.00),
	(16, 'Demolidor', 'Em dia', 'A vida me cegou', '2019-11-16 19:36:26', 'Desativo', 'Mensal', 0.00),
	(17, 'John Deep', 'Em dia', 'Piratas do caribe é nois', '2019-11-16 19:37:06', 'Desativo', 'Mensal', 0.00),
	(18, 'Steve Rogers', 'Em dia', 'meu escudo', '2019-11-16 20:19:33', 'Desativo', 'Comum', 0.00),
	(19, 'Shikamaru', 'Em dia', 'Só observo', '2019-11-17 22:28:50', 'Ativo', 'Mensal', 0.00),
	(20, 'Kamado Tanjiro', 'Em dia', 'Caçador de Onis', '2019-11-24 01:40:07', 'Ativo', 'Comum', 0.00),
	(21, 'Kamado Nezuko', 'Em dia', 'Irmã oni do matador de Onis', '2019-11-24 01:53:42', 'Ativo', 'Comum', 0.00),
	(22, 'Haruo', 'Em dia', 'joga bem com o Guile no SFII', '2019-11-24 02:00:04', 'Ativo', 'Comum', 0.00);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;

-- Copiando estrutura para tabela mamaezona.cozinha
CREATE TABLE IF NOT EXISTS `cozinha` (
  `cozinha_id_pedido` int(11) NOT NULL,
  `cozinha_id_produto` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Preparo',
  `id_cozinha` int(11) NOT NULL AUTO_INCREMENT,
  `quantia` int(11) NOT NULL,
  PRIMARY KEY (`id_cozinha`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela mamaezona.cozinha: ~9 rows (aproximadamente)
DELETE FROM `cozinha`;
/*!40000 ALTER TABLE `cozinha` DISABLE KEYS */;
INSERT INTO `cozinha` (`cozinha_id_pedido`, `cozinha_id_produto`, `status`, `id_cozinha`, `quantia`) VALUES
	(57, 3, 'Preparo', 80, 2),
	(57, 14, 'Preparo', 81, 10),
	(58, 1, 'Preparo', 82, 5),
	(58, 2, 'Preparo', 83, 5),
	(58, 14, 'Pronto', 84, 20),
	(59, 1, 'Pronto', 85, 15),
	(59, 2, 'Preparo', 86, 20),
	(59, 3, 'Preparo', 87, 10),
	(59, 14, 'Pronto', 88, 35);
/*!40000 ALTER TABLE `cozinha` ENABLE KEYS */;


-- Copiando estrutura para tabela mamaezona.funcionarios
CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id_funcionarios` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE utf8_bin NOT NULL,
  `login` varchar(20) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `perfil` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '../../img/funcionario/default.img',
  `senha` varchar(150) COLLATE utf8_bin NOT NULL,
  `chave` varchar(50) COLLATE utf8_bin NOT NULL,
  `acesso` char(2) COLLATE utf8_bin NOT NULL,
  `admitido` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dispensa` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_funcionarios`),
  UNIQUE KEY `email` (`email`,`login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Copiando dados para a tabela mamaezona.funcionarios: ~0 rows (aproximadamente)
DELETE FROM `funcionarios`;
/*!40000 ALTER TABLE `funcionarios` DISABLE KEYS */;
INSERT INTO `funcionarios` (`id_funcionarios`, `nome`, `login`, `email`, `perfil`, `senha`, `chave`, `acesso`, `admitido`, `dispensa`, `status`) VALUES
	(1, 'admin', 'admin', 'adm@email.com', '../../img/funcionario/default.img', '$argon2i$v=19$m=1024,t=2,p=2$bTYuZ29yZkUzdEpjRTAvYQ$rlJRocmE8TWDlEEpRKcp+xXvs13Uqf0OkyDH89kPayQ', '7adf0d749f2dc51f72d0639b81ed4d06', 'US', '2019-12-01 23:48:50', NULL, 1);
/*!40000 ALTER TABLE `funcionarios` ENABLE KEYS */;


-- Copiando estrutura para tabela mamaezona.pedido
CREATE TABLE IF NOT EXISTS `pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valor` decimal(6,2) NOT NULL,
  `tipo` varchar(10) NOT NULL COMMENT 'salva se a venda foi a dinheiro, credito ou debito.',
  `desconto` decimal(6,2) DEFAULT NULL,
  `acrescimo` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`id_pedido`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela mamaezona.pedido: ~61 rows (aproximadamente)
DELETE FROM `pedido`;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` (`id_pedido`, `data`, `valor`, `tipo`, `desconto`, `acrescimo`) VALUES
	(1, '2022-11-30 02:51:46', 4.50, 'Dinheiro', 0.00, 0.00),
	(2, '2022-11-30 02:55:47', 4.50, 'Dinheiro', 0.00, 0.00),
	(3, '2022-11-30 03:01:13', 4.50, 'Débito', 0.00, 0.00),
	(4, '2022-11-30 03:03:51', 4.50, 'Débito', 0.00, 0.00),
	(5, '2022-11-30 03:08:05', 4.50, 'Dinheiro', 0.00, 0.00),
	(6, '2022-11-30 03:11:51', 4.50, 'Crédito', 0.00, 0.00),
	(7, '2022-11-30 03:21:49', 4.50, 'Dinheiro', 0.00, 0.00),
	(8, '2022-11-30 03:25:42', 4.50, 'Crédito', 0.00, 0.00),
	(9, '2022-11-30 03:28:19', 228.44, 'Crédito', 0.00, 0.00),
	(10, '2022-11-30 03:41:52', 4.50, 'Dinheiro', 0.00, 0.00),
	(11, '2022-11-30 03:46:31', 4.50, 'Dinheiro', 0.00, 0.00),
	(12, '2022-10-30 03:49:13', 113.00, 'Interno', 0.00, 0.00),
	(13, '2022-12-01 16:01:39', 85.50, 'Interno', 0.00, 0.00),
	(14, '2022-12-01 16:02:47', 9.00, 'Interno', 0.00, 0.00),
	(15, '2022-12-01 16:08:41', 5.00, 'Fiado', 0.00, 0.00),
	(16, '2022-12-02 02:05:14', 13.50, 'Dinheiro', 0.00, 0.00),
	(17, '2022-12-02 02:08:19', 22.50, 'Dinheiro', 0.00, 0.00),
	(18, '2022-12-02 02:09:56', 180.00, 'Fiado', 0.00, 0.00),
	(19, '2022-12-02 02:14:40', 180.00, 'Débito', 0.00, 0.00),
	(20, '2022-12-02 02:26:32', 50.00, 'Interno', 0.00, 0.00),
	(21, '2022-12-08 21:47:04', 318.90, 'Dinheiro', 0.00, 0.00),
	(22, '2022-12-08 21:57:22', 264.40, 'Dinheiro', 0.00, 0.00),
	(23, '2022-12-08 22:00:30', 50.00, 'Dinheiro', 0.00, 0.00),
	(24, '2022-12-08 22:07:23', 268.90, 'Dinheiro', 0.00, 0.00),
	(25, '2022-12-08 22:19:14', 268.90, 'Dinheiro', 0.00, 0.00),
	(26, '2022-12-08 23:48:28', 533.30, 'Dinheiro', 0.00, 0.00),
	(27, '2022-12-08 23:51:29', 50.00, 'Debito', 0.00, 0.00),
	(28, '2022-12-08 23:54:21', 195.00, 'Credito', 0.00, 0.00),
	(29, '2022-12-09 00:00:19', 110.00, 'Credito', 0.00, 0.00),
	(30, '2022-12-09 00:00:43', 50.00, 'Credito', 0.00, 0.00),
	(31, '2022-12-09 00:02:03', 30.00, 'Credito', 0.00, 0.00),
	(32, '2022-12-09 00:04:00', 129.95, 'Credito', 0.00, 0.00),
	(33, '2022-12-09 00:15:02', 129.95, 'Dinheiro', 0.00, 0.00),
	(34, '2022-12-09 00:15:28', 110.00, 'Dinheiro', 0.00, 0.00),
	(35, '2022-12-09 00:23:10', 125.00, 'Dinheiro', 0.00, 0.00),
	(36, '2022-12-09 00:23:44', 90.00, 'Credito', 0.00, 0.00),
	(37, '2022-12-09 00:25:04', 84.00, 'Debito', 0.00, 0.00),
	(38, '2022-12-09 00:30:20', 70.00, 'Debito', 0.00, 0.00),
	(39, '2022-12-09 00:31:16', 326.98, 'Debito', 0.00, 0.00),
	(40, '2022-12-09 00:40:07', 77.97, 'Dinheiro', 0.00, 0.00),
	(41, '2022-12-09 00:40:33', 126.98, 'Dinheiro', 0.00, 0.00),
	(42, '2022-12-09 00:41:24', 43.50, 'Dinheiro', 0.00, 0.00),
	(43, '2022-12-09 00:43:09', 50.00, 'Credito', 0.00, 0.00),
	(44, '2022-12-09 00:43:54', 144.00, 'Credito', 0.00, 0.00),
	(45, '2022-12-09 00:45:06', 165.00, 'Dinheiro', 0.00, 0.00),
	(46, '2022-12-09 00:48:30', 125.00, 'Debito', 0.00, 0.00),
	(47, '2022-12-09 00:48:57', 51.98, 'Credito', 0.00, 0.00),
	(48, '2022-12-09 00:49:50', 50.00, 'Dinheiro', 0.00, 0.00),
	(49, '2022-12-09 00:50:19', 60.00, 'Debito', 0.00, 0.00),
	(50, '2022-12-09 00:54:31', 179.95, 'Debito', 0.00, 0.00),
	(51, '2022-12-09 01:07:33', 50.00, 'Dinheiro', 0.00, 0.00),
	(52, '2022-12-09 01:08:12', 155.00, 'Dinheiro', 0.00, 0.00),
	(53, '2022-12-09 01:11:48', 25.00, 'Debito', 0.00, 0.00),
	(54, '2022-12-09 01:13:10', 200.00, 'Dinheiro', 0.00, 0.00),
	(55, '2022-12-09 01:15:49', 544.90, 'Credito', 0.00, 0.00),
	(56, '2022-12-09 01:21:26', 50.00, 'Dinheiro', 0.00, 0.00),
	(57, '2022-12-09 01:22:17', 333.40, 'Debito', 0.00, 0.00),
	(58, '2022-12-09 01:24:43', 779.80, 'Credito', 0.00, 0.00),
	(59, '2022-12-09 01:29:01', 2177.15, 'Credito', 0.00, 0.00),
	(60, '2022-12-09 02:20:21', 67.50, 'Dinheiro', 0.00, 0.00),
	(61, '2022-12-09 02:20:56', 140.00, 'Dinheiro', 0.00, 0.00);
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;


-- Copiando estrutura para tabela mamaezona.produto
CREATE TABLE IF NOT EXISTS `produto` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `imagem` varchar(255) NOT NULL DEFAULT '../../img/produto/default.png',
  `preco` decimal(6,2) DEFAULT NULL,
  `custo` decimal(6,2) NOT NULL,
  `quantia` int(11) DEFAULT NULL,
  `quantia_minima` int(11) DEFAULT NULL,
  `tipo` varchar(10) NOT NULL DEFAULT 'Comum',
  `status` varchar(8) NOT NULL DEFAULT 'Ativo',
  PRIMARY KEY (`id_produto`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela mamaezona.produto: ~26 rows (aproximadamente)
DELETE FROM `produto`;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` (`id_produto`, `nome`, `marca`, `imagem`, `preco`, `custo`, `quantia`, `quantia_minima`, `tipo`, `status`) VALUES
	(1, 'Feijoada P', 'Nenhuma', '../../img/produto/default.png', 25.00, 15.00, 1, 0, 'Preparo', 'Ativo'),
	(2, 'Feijoada M', 'Nenhuma', '../../img/produto/default.png', 25.00, 15.00, 1, 0, 'Preparo', 'Ativo'),
	(3, 'Feijoada G', 'Nenhuma', '../../img/produto/default.png', 30.00, 20.00, 1, 0, 'Preparo', 'Ativo'),
	(4, 'Dolly 2l Guarana', 'Dolly', '../../img/produto/default.png', 4.50, 2.30, 0, 5, 'Comum', 'Ativo'),
	(5, 'Dolly Laranja', 'Dolly', '../../img/produto/default.png', 4.50, 2.30, 0, 5, 'Comum', 'Ativo'),
	(6, 'Dolly Cola', 'Dolly', '../../img/produto/default.png', 5.00, 2.70, 1, 7, 'Comum', 'Ativo'),
	(7, 'Feijão', 'Nenhuma', '../../img/produto/default.png', 0.00, 7.70, 28, 5, 'Interno', 'Ativo'),
	(8, 'Arroz 5kg', 'Nenhuma', '../../img/produto/default.png', 0.00, 9.50, 2, 2, 'Interno', 'Ativo'),
	(9, 'Lasanha', 'Vigor', '../../img/produto/default.png', 15.00, 10.00, 1, 0, 'Preparo', 'Ativo'),
	(10, 'coca', 'fini', '../../img/produto/default.png', 5.00, 5.00, 0, 4, 'Comum', 'Desativo'),
	(11, 'bala', '12', '.../../img/produto/default.png', 87.00, 76.00, 54, 65, 'Interno', 'Ativo'),
	(14, 'Sushi', 'China InBox', '../../img/produto/default.png', 25.99, 10.50, 1, 10, 'Preparo', 'Desativo'),
	(15, 'Caranguejo Cozinho', 'Baude de Lixo', '../../img/produto/default.png', 150.00, 50.00, 1, 15, 'Preparo', 'Desativo'),
	(16, 'Estrela do mar', 'Pedra d\\\'gua', '../../img/produto/default.png', 74.99, 49.99, 1, 20, 'Preparo', 'Ativo'),
	(17, 'Cavalo Marinho', 'Pedra d\\\'gua', '../../img/produto/default.png', 20.00, 50.00, 1, 5, 'Preparo', 'Desativo'),
	(18, 'Filé à Milanesa', 'D\\\'Agua doce', '../../img/produto/default.png', 17.00, 12.00, 57, 34, 'Comum', 'Desativo'),
	(19, 'Polvo', 'A\'m Polvo', '../../img/produto/default.png', 50.00, 10.00, 40, 25, 'Comum', 'Desativo'),
	(20, 'Lasanha De Outra COisa', 'Vigor 2', '../../img/produto/default.png', 35.00, 20.00, 1, 0, 'Preparo', 'Desativo'),
	(21, 'Balde de frango', 'Chickens', '../../img/produto/default.png', 30.50, 25.00, 1, 1, 'Preparo', 'Ativo'),
	(22, 'Suco Ades', 'Ades', '.../../img/produto/default.png', 5.40, 4.50, 70, 5, 'Comum', 'Ativo'),
	(23, 'Frango', 'Marca Z', '../../img/produto/default.png', 15.99, 9.99, 1, 0, 'Preparo', 'Ativo'),
	(24, 'Salada', 'Marca E', '../../img/produto/default.png', 15.00, 7.50, 1, 0, 'Preparo', 'Ativo'),
	(25, 'Farinha', 'Marca Qualquer', '../../img/produto/default.png', 0.00, 5.00, 50, 15, 'Interno', 'Ativo'),
	(26, 'Pimentão', 'Qualquer um', '../../img/produto/default.png', 0.00, 3.99, 20, 5, 'Interno', 'Ativo'),
	(27, 'Paçoca Pequena', 'nenhuma', '../../img/produto/default.png', 0.50, 0.30, 100, 20, 'Comum', 'Ativo'),
	(28, 'Fanta 2l Laranja', 'Coca-Cola', '../../img/produto/default.png', 7.00, 4.00, 40, 15, 'Comum', 'Ativo'),
	(29, 'Fanta 2l Uva', 'Coca-Cola', '../../img/produto/default.png', 7.50, 4.00, 80, 20, 'Comum', 'Ativo'),
	(30, 'Farinha 1kg', NULL, '../../img/produto/default.png', NULL, 3.50, 20, 2, 'Interno', 'Ativo'),
	(31, 'Lobits Cebola', 'Lobits', '../../img/produto/default.png', 1.50, 0.70, 70, 15, 'Comum', 'Ativo');
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;

-- Copiando estrutura para tabela mamaezona.consumo_interno
CREATE TABLE IF NOT EXISTS `consumo_interno` (
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `funcionarios_id_funcionarios` int(11) NOT NULL,
  `pedido_id_pedido` int(11) NOT NULL,
  KEY `fk_consumo_interno_funcionarios` (`funcionarios_id_funcionarios`),
  KEY `fk_consumo_interno_pedido` (`pedido_id_pedido`),
  CONSTRAINT `fk_consumo_interno_funcionarios` FOREIGN KEY (`funcionarios_id_funcionarios`) REFERENCES `funcionarios` (`id_funcionarios`),
  CONSTRAINT `fk_consumo_interno_pedido` FOREIGN KEY (`pedido_id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='vendas que vão para a conta do estabelecimento.';

-- Copiando dados para a tabela mamaezona.consumo_interno: ~2 rows (aproximadamente)
DELETE FROM `consumo_interno`;
/*!40000 ALTER TABLE `consumo_interno` DISABLE KEYS */;
INSERT INTO `consumo_interno` (`data`, `funcionarios_id_funcionarios`, `pedido_id_pedido`) VALUES
	('2019-12-02 02:14:41', 1, 19),
	('2019-12-02 02:26:33', 1, 20);
/*!40000 ALTER TABLE `consumo_interno` ENABLE KEYS */;


-- Copiando estrutura para tabela mamaezona.contas
CREATE TABLE IF NOT EXISTS `contas` (
  `cliente_id_cliente` int(11) NOT NULL,
  `data_mensal` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `pedido_id_pedido` int(11) NOT NULL,
  KEY `fk_contas_cliente` (`cliente_id_cliente`),
  KEY `fk_contas_pedido` (`pedido_id_pedido`),
  CONSTRAINT `fk_contas_cliente` FOREIGN KEY (`cliente_id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `fk_contas_pedido` FOREIGN KEY (`pedido_id_pedido`) REFERENCES `pedido` (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='salva somente clientes que estão devendo.';

-- Copiando dados para a tabela mamaezona.contas: ~1 rows (aproximadamente)
DELETE FROM `contas`;
/*!40000 ALTER TABLE `contas` DISABLE KEYS */;
INSERT INTO `contas` (`cliente_id_cliente`, `data_mensal`, `pedido_id_pedido`) VALUES
	(6, '2019-12-02 02:08:19', 17);
/*!40000 ALTER TABLE `contas` ENABLE KEYS */;


-- Copiando estrutura para tabela mamaezona.itens_entrada
CREATE TABLE IF NOT EXISTS `itens_entrada` (
  `quantia` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `produto_id_produto` int(11) NOT NULL,
  KEY `fk_itens_entrada` (`produto_id_produto`),
  CONSTRAINT `fk_itens_entrada` FOREIGN KEY (`produto_id_produto`) REFERENCES `produto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela mamaezona.itens_entrada: ~16 rows (aproximadamente)
DELETE FROM `itens_entrada`;
/*!40000 ALTER TABLE `itens_entrada` DISABLE KEYS */;
INSERT INTO `itens_entrada` (`quantia`, `data`, `produto_id_produto`) VALUES
	(25, '2019-11-18 00:16:20', 1),
	(25, '2019-11-18 00:16:42', 1),
	(25, '2019-11-18 00:17:06', 1),
	(25, '2019-11-18 00:28:47', 1),
	(25, '2019-11-18 00:29:13', 1),
	(25, '2019-11-18 00:29:40', 1),
	(25, '2019-11-18 00:31:23', 1),
	(50, '2019-11-18 00:33:35', 1),
	(50, '2019-11-18 00:39:19', 6),
	(25, '2019-11-18 00:39:57', 5),
	(2, '2019-11-18 01:48:24', 6),
	(25, '2019-11-18 01:50:42', 4),
	(45, '2019-11-19 01:55:26', 22),
	(5, '2019-11-23 22:08:54', 22),
	(5, '2019-11-23 23:17:16', 26),
	(5, '2019-11-24 02:11:02', 10),
	(5, '2019-11-24 02:13:56', 4);
/*!40000 ALTER TABLE `itens_entrada` ENABLE KEYS */;

-- Copiando estrutura para tabela mamaezona.itens_vendidos
CREATE TABLE IF NOT EXISTS `itens_vendidos` (
  `quantia` int(11) NOT NULL,
  `pedido_id_pedido` int(11) NOT NULL,
  `produto_id_produto` int(11) NOT NULL,
  KEY `fk_historico_pedido` (`pedido_id_pedido`),
  KEY `fk_historico_produto` (`produto_id_produto`),
  CONSTRAINT `fk_historico_pedido` FOREIGN KEY (`pedido_id_pedido`) REFERENCES `pedido` (`id_pedido`),
  CONSTRAINT `fk_historico_produto` FOREIGN KEY (`produto_id_produto`) REFERENCES `produto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='salva os produtos que foram vendidos agrupando-os por venda.';

-- Copiando dados para a tabela mamaezona.itens_vendidos: ~91 rows (aproximadamente)
DELETE FROM `itens_vendidos`;
/*!40000 ALTER TABLE `itens_vendidos` DISABLE KEYS */;
INSERT INTO `itens_vendidos` (`quantia`, `pedido_id_pedido`, `produto_id_produto`) VALUES
	(15, 1, 1),
	(1, 8, 4),
	(2, 9, 2),
	(5, 9, 4),
	(6, 9, 14),
	(1, 11, 4),
	(1, 12, 1),
	(4, 12, 4),
	(10, 12, 28),
	(19, 13, 4),
	(2, 14, 5),
	(1, 15, 10),
	(3, 16, 5),
	(5, 17, 5),
	(40, 18, 5),
	(40, 19, 5),
	(10, 20, 6),
	(1, 22, 4),
	(10, 22, 14),
	(2, 23, 2),
	(2, 24, 4),
	(10, 24, 14),
	(2, 25, 4),
	(10, 25, 14),
	(3, 26, 4),
	(20, 26, 14),
	(2, 27, 1),
	(5, 28, 2),
	(2, 28, 3),
	(2, 28, 6),
	(2, 29, 2),
	(2, 29, 3),
	(2, 30, 1),
	(1, 31, 3),
	(5, 32, 14),
	(5, 33, 14),
	(2, 34, 2),
	(2, 34, 3),
	(5, 35, 2),
	(3, 36, 3),
	(3, 37, 1),
	(2, 37, 4),
	(2, 38, 3),
	(2, 38, 6),
	(7, 39, 1),
	(4, 39, 2),
	(2, 39, 14),
	(3, 40, 14),
	(3, 41, 2),
	(2, 41, 14),
	(1, 42, 3),
	(3, 42, 4),
	(2, 43, 1),
	(5, 44, 1),
	(2, 44, 4),
	(2, 44, 10),
	(1, 45, 1),
	(2, 45, 2),
	(3, 45, 3),
	(5, 46, 1),
	(2, 47, 14),
	(2, 48, 2),
	(2, 49, 3),
	(2, 50, 1),
	(5, 50, 14),
	(2, 51, 1),
	(5, 52, 2),
	(1, 52, 3),
	(1, 53, 2),
	(2, 54, 1),
	(5, 54, 3),
	(4, 55, 1),
	(7, 55, 2),
	(2, 55, 6),
	(10, 55, 14),
	(2, 56, 2),
	(2, 57, 3),
	(3, 57, 4),
	(10, 57, 14),
	(5, 58, 1),
	(5, 58, 2),
	(2, 58, 10),
	(20, 58, 14),
	(15, 59, 1),
	(20, 59, 2),
	(10, 59, 3),
	(15, 59, 4),
	(5, 59, 6),
	(35, 59, 14),
	(15, 60, 4),
	(28, 61, 6);
/*!40000 ALTER TABLE `itens_vendidos` ENABLE KEYS */;

-- Copiando estrutura para procedure mamaezona.pagamento
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `pagamento`(
	IN `ID_cliente_param` INT
)
BEGIN

	DECLARE valor_pedido DECIMAL(6,2) DEFAULT 0;
	DECLARE credito DECIMAL(6,2) DEFAULT 0;
	
	DECLARE id_cli INT DEFAULT 0;
	DECLARE id_ped INT DEFAULT 0;
	
	DECLARE fim BOOL DEFAULT FALSE;
	
  	DECLARE dividas_cliente CURSOR FOR SELECT pedido.id_pedido
	   FROM pedido
	  INNER JOIN contas ON pedido.id_pedido = contas.pedido_id_pedido
	  INNER JOIN cliente ON cliente.id_cliente = contas.cliente_id_cliente
	  INNER JOIN devedores ON devedores.id_cliente = cliente.id_cliente
	  WHERE pedido.valor <= cliente.credito AND cliente.id_cliente = ID_cliente_param; 

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET fim = TRUE;
	
	OPEN dividas_cliente;
	
	pagar: LOOP
		FETCH dividas_cliente INTO id_ped;
		IF fim THEN
			LEAVE pagar;
		END IF;
		SELECT pedido.valor FROM pedido WHERE pedido.id_pedido = id_ped INTO valor_pedido;
		SELECT cliente.credito FROM cliente WHERE cliente.id_cliente = ID_cliente_param INTO credito; 
		IF credito >= valor_pedido THEN
			UPDATE cliente SET credito = credito - valor_pedido WHERE id_cliente = ID_cliente_param;
			DELETE FROM contas WHERE contas.pedido_id_pedido = id_ped;
		END IF;
	END LOOP;
	
	CLOSE dividas_cliente;
	
END//
DELIMITER ;

-- Copiando estrutura para procedure mamaezona.Up_devedores_pagamento
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `Up_devedores_pagamento`()
BEGIN


	DECLARE id_cli INT DEFAULT 0;
	DECLARE fim BOOL DEFAULT FALSE;
	DECLARE clientes_id CURSOR FOR SELECT devedores.id_cliente
	                                 FROM devedores
									WHERE devedores.divida > 0;
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET fim = TRUE;
  
	OPEN clientes_id;
	
	cliente_pagar:LOOP
		FETCH clientes_id INTO id_cli;
  		IF fim THEN
  			LEAVE cliente_pagar;
  		END IF;
  		CALL pagamento(id_cli);
	END LOOP;
	CLOSE clientes_id;

END//
DELIMITER ;

-- Copiando estrutura para evento mamaezona.Atualizar_devedores_pagamento
DELIMITER //
CREATE DEFINER=`root`@`localhost` EVENT `Atualizar_devedores_pagamento` ON SCHEDULE EVERY 10 SECOND STARTS '2019-12-07 12:31:30' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN

	DECLARE id_cli INT DEFAULT 0;
	DECLARE fim BOOL DEFAULT FALSE;
	DECLARE clientes_id CURSOR FOR SELECT devedores.id_cliente
	                                 FROM devedores
									WHERE devedores.divida > 0;
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET fim = TRUE;
  
	OPEN clientes_id;
	
	cliente_pagar:LOOP
		FETCH clientes_id INTO id_cli;
  		IF fim THEN
  			LEAVE cliente_pagar;
  		END IF;
  		CALL Up_devedores_pagamento();
	END LOOP;
	CLOSE clientes_id;
END//
DELIMITER ;

-- Copiando estrutura para evento mamaezona.Up_Cliente_Situacao
DELIMITER //
CREATE DEFINER=`root`@`localhost` EVENT `Up_Cliente_Situacao` ON SCHEDULE EVERY 10 SECOND STARTS '2019-12-02 13:53:58' ON COMPLETION PRESERVE ENABLE COMMENT 'Troca a situação do cliente caso devedor' DO BEGIN

#------------------------------------------------
 UPDATE cliente SET situacao = "Em aberto" 
  WHERE cliente.id_cliente in (
        SELECT contas.cliente_id_cliente
          FROM pedido
 		 INNER JOIN contas ON pedido.id_pedido = contas.pedido_id_pedido 
 		 WHERE CURRENT_TIMESTAMP()
               BETWEEN pedido.`data` 
           		   AND DATE_ADD(pedido.`data`,INTERVAL 1 MONTH)
	 );
	 
# ------------------------------------------------
 UPDATE cliente SET situacao = "Em débito" 
  WHERE cliente.id_cliente in (
		SELECT contas.cliente_id_cliente
 		  FROM pedido
 		 INNER JOIN contas ON pedido.id_pedido = contas.pedido_id_pedido 
 		 WHERE CURRENT_TIMESTAMP() > DATE_ADD(pedido.`data`,INTERVAL 1 MONTH)
	 );

# ------------------------------------------------
 UPDATE cliente SET situacao = "Em dia" 
  WHERE cliente.id_cliente in (
        SELECT devedores.id_cliente 
		  FROM devedores
		 WHERE devedores.divida = 0
	 );
END//
DELIMITER ;

-- Copiando estrutura para trigger mamaezona.Contas_After_Insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `Contas_After_Insert` AFTER INSERT ON `contas` FOR EACH ROW BEGIN
	CALL Up_devedores_pagamento();
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Copiando estrutura para trigger mamaezona.cozinha_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `cozinha_insert` AFTER INSERT ON `itens_vendidos` FOR EACH ROW BEGIN

	DECLARE tipo_prod VARCHAR(10);
	SELECT produto.tipo FROM produto WHERE produto.id_produto = NEW.produto_id_produto INTO tipo_prod;
	IF tipo_prod = 'Preparo' THEN
		INSERT INTO cozinha (cozinha_id_pedido, cozinha_id_produto, quantia) 
			   VALUES (NEW.pedido_id_pedido, NEW.produto_id_produto, NEW.quantia); 
	END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Copiando estrutura para view mamaezona.devedores
-- Removendo tabela temporária e criando a estrutura VIEW final
DROP TABLE IF EXISTS `devedores`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `devedores` AS SELECT * FROM (SELECT cliente.id_cliente,
					  cliente.nome_cliente,
					  cliente.situacao,
					  cliente.descricao,
					  cliente.data_cliente,
					  cliente.status_cliente,
					  cliente.tipo_cliente,
	    			  IFNULL(SUM(pedido.valor) - cliente.credito, 0) AS divida
  				 FROM cliente 
 				 LEFT JOIN contas ON cliente.id_cliente = contas.cliente_id_cliente
 				 LEFT JOIN pedido ON contas.pedido_id_pedido = pedido.id_pedido
 				GROUP BY cliente.id_cliente) AS clientes_dev ;

-- Copiando estrutura para view mamaezona.pratos_cozinha
-- Removendo tabela temporária e criando a estrutura VIEW final
DROP TABLE IF EXISTS `pratos_cozinha`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pratos_cozinha` AS SELECT cozinha.id_cozinha,
	   cozinha.`status`,
	   produto.nome,
	   produto.imagem AS path_img_produto,
	   cozinha.cozinha_id_pedido AS pedido_id,
	   cozinha.quantia
  FROM cozinha
  INNER JOIN produto ON produto.id_produto = cozinha.cozinha_id_produto ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;