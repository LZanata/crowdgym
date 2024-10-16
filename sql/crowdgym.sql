-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 16, 2024 at 12:29 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crowdgym`
--

-- --------------------------------------------------------

--
-- Table structure for table `academia`
--

DROP TABLE IF EXISTS `academia`;
CREATE TABLE IF NOT EXISTS `academia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `dia_semana` enum('Segunda a Sexta','Segunda a Sábado','Todos os dias') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `abertura` time DEFAULT NULL,
  `fechamento` time DEFAULT NULL,
  `rua` varchar(100) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `complemento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bairro` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `estado` char(2) NOT NULL,
  `cep` char(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `academia`
--

INSERT INTO `academia` (`id`, `nome`, `telefone`, `dia_semana`, `abertura`, `fechamento`, `rua`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`) VALUES
(7, 'Gumer Gym', '(11) 95970-9881', 'Segunda a Sábado', '05:00:00', '22:00:00', 'Sena', '1066', 'casa 1', 'Parque das Nações', 'Barueri', 'SP', '06437-240'),
(12, 'Roblox Gym', '(11) 95211-5452', 'Todos os dias', '06:00:00', '13:00:00', 'Nova Aurora', '3242', '', 'Jardim Mutinga', 'Ponta Grossa', 'PR', '06437-240');

-- --------------------------------------------------------

--
-- Table structure for table `aluno`
--

DROP TABLE IF EXISTS `aluno`;
CREATE TABLE IF NOT EXISTS `aluno` (
  `cpf` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `genero` enum('masculino','feminino','outro') NOT NULL,
  `data_nascimento` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cpf`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assinatura`
--

DROP TABLE IF EXISTS `assinatura`;
CREATE TABLE IF NOT EXISTS `assinatura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` enum('ativo','inativo') NOT NULL,
  `valor_pago` decimal(10,2) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `Plano_id` int NOT NULL,
  `Aluno_cpf` char(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Assinatura_Plano1_idx` (`Plano_id`),
  KEY `fk_Assinatura_Aluno1_idx` (`Aluno_cpf`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entrada_saida`
--

DROP TABLE IF EXISTS `entrada_saida`;
CREATE TABLE IF NOT EXISTS `entrada_saida` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_entrada` datetime NOT NULL,
  `data_saida` datetime NOT NULL,
  `Academia_id` int NOT NULL,
  `Aluno_cpf` char(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Entrada_Saida_Academia1_idx` (`Academia_id`),
  KEY `fk_Entrada_Saida_Aluno1_idx` (`Aluno_cpf`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fluxo`
--

DROP TABLE IF EXISTS `fluxo`;
CREATE TABLE IF NOT EXISTS `fluxo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alunos` int NOT NULL,
  `data` date NOT NULL,
  `Academia_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Fluxo_Academia1_idx` (`Academia_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE IF NOT EXISTS `funcionario` (
  `cpf` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `data_contrat` date NOT NULL,
  `genero` enum('masculino','feminino','outro') NOT NULL,
  `Gerente_cpf` char(11) NOT NULL,
  PRIMARY KEY (`cpf`),
  KEY `fk_Funcionario_Gerente1_idx` (`Gerente_cpf`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gerente`
--

DROP TABLE IF EXISTS `gerente`;
CREATE TABLE IF NOT EXISTS `gerente` (
  `cpf` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `senha` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Academia_id` int NOT NULL,
  PRIMARY KEY (`cpf`),
  KEY `fk_Funcionario_Academia_idx` (`Academia_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gerente`
--

INSERT INTO `gerente` (`cpf`, `nome`, `email`, `telefone`, `senha`, `Academia_id`) VALUES
('666.777.148-69', 'dark_gumer171', 'darkgumer@gmail.com', '(11) 9700-7757', '$2y$10$6MIkhthPOyzZ4C9pmu.S6OM.bGpuECyuS7Pvx2', 7);

-- --------------------------------------------------------

--
-- Table structure for table `pagamento`
--

DROP TABLE IF EXISTS `pagamento`;
CREATE TABLE IF NOT EXISTS `pagamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `valor_pago` decimal(10,2) NOT NULL,
  `metodo_pagamento` enum('Cartão de Crédito','Cartão de Débito','Boleto','Pix') NOT NULL,
  `data_pagamento` date NOT NULL,
  `Assinatura_id` int NOT NULL,
  `Aluno_cpf` char(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Pagamento_Assinatura1_idx` (`Assinatura_id`),
  KEY `fk_Pagamento_Aluno1_idx` (`Aluno_cpf`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plano`
--

DROP TABLE IF EXISTS `plano`;
CREATE TABLE IF NOT EXISTS `plano` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `duracao` int NOT NULL,
  `Academia_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Plano_Academia1_idx` (`Academia_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
