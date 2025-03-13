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
  `capacidade_maxima` int DEFAULT '50',
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `administrador` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cpf` char(14) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `reset_token_hash` varchar(255) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
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
  `reset_token_hash` varchar(255) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `status` enum('ativo','inativo') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`)
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

CREATE TABLE IF NOT EXISTS `assinatura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` enum('ativo','inativo') NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `metodo_pagamento` enum('Cartão de Crédito','Cartão de Débito','Boleto','Pix') NOT NULL,
  `data_pagamento` date DEFAULT NULL,
  `valor_pago` decimal(10,2) NOT NULL,
  `Planos_id` int NOT NULL,
  `Aluno_id` int NOT NULL,
  `numero_cartao` varchar(20) DEFAULT NULL,
  `nome_titular` varchar(100) DEFAULT NULL,
  `validade_cartao` date DEFAULT NULL,
  `codigo_seguranca` varchar(4) DEFAULT NULL,
  `cpf_titular` varchar(11) DEFAULT NULL,
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


CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cpf` varchar(14) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,  -- Exclusivo para gerente
  `cargo` varchar(50) DEFAULT NULL,     -- Exclusivo para funcionário
  `data_contrat` date DEFAULT NULL,     -- Exclusivo para funcionário
  `genero` enum('masculino','feminino','outro') DEFAULT NULL, -- Exclusivo para funcionário
  `tipo` enum('gerente', 'funcionario') NOT NULL,
  `Academia_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `fk_Funcionarios_Academia_idx` (`Academia_id`),
  CONSTRAINT `fk_Funcionarios_Academia`
      FOREIGN KEY (`Academia_id`)
      REFERENCES `academia` (`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE
);

INSERT INTO `administrador`(`id`, `cpf`, `nome`, `email`, `senha`, `reset_token_hash`, `reset_token_expires_at`) VALUES ('','[value-cpf]','[value-nome]','[value-email]','123456','','');