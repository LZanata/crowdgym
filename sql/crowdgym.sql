CREATE DATABASE IF NOT EXISTS `crowdgym`;

USE `crowdgym`;

CREATE TABLE IF NOT EXISTS `academia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `dia_semana` enum('Segunda a Sexta','Segunda a Sábado','Todos os dias') DEFAULT NULL,
  `abertura` time DEFAULT NULL,
  `fechamento` time DEFAULT NULL,
  `rua` varchar(100) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `estado` char(2) NOT NULL,
  `cep` char(9) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `administrador` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cpf` char(14) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`)
);

CREATE TABLE IF NOT EXISTS `aluno` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cpf` char(14) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `genero` enum('masculino','feminino','outro') NOT NULL,
  `data_nascimento` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`)
);

CREATE TABLE IF NOT EXISTS `assinatura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` enum('ativo','inativo') NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `metodo_pagamento` enum('Cartão de Crédito','Cartão de Débito','Boleto','Pix') NOT NULL,
  `data_pagamento` date NOT NULL,
  `valor_pago` decimal(10,2) NOT NULL,
  `Planos_id` int NOT NULL,
  `Aluno_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Assinatura_Planos1_idx` (`Planos_id`),
  KEY `fk_Assinatura_Aluno1_idx` (`Aluno_id`)
);

CREATE TABLE IF NOT EXISTS `entrada_saida` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_entrada` datetime NOT NULL,
  `data_saida` datetime NOT NULL,
  `Academia_id` int NOT NULL,
  `Aluno_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Entrada_Saida_Academia1_idx` (`Academia_id`),
  KEY `fk_Entrada_Saida_Aluno1_idx` (`Aluno_id`)
);

DROP TABLE IF EXISTS `fluxo`;
CREATE TABLE IF NOT EXISTS `fluxo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alunos` int NOT NULL,
  `data` date NOT NULL,
  `Academia_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Fluxo_Academia1_idx` (`Academia_id`)
);

CREATE TABLE IF NOT EXISTS `funcionario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cpf` varchar(14) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `data_contrat` date NOT NULL,
  `genero` enum('masculino','feminino','outro') NOT NULL,
  `Gerente_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `fk_Funcionario_Gerente1_idx` (`Gerente_id`)
);

CREATE TABLE IF NOT EXISTS `gerente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cpf` char(14) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `Academia_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `fk_Funcionario_Academia_idx` (`Academia_id`)
);

CREATE TABLE IF NOT EXISTS `planos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `duracao` int NOT NULL,
  `tipo` enum('Principal','Adicional') NOT NULL,
  `Academia_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Plano_Academia1_idx` (`Academia_id`)
);