CREATE DATABASE IF NOT EXISTS `crowdgym`;
USE `crowdgym`;

CREATE TABLE IF NOT EXISTS `academia` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `telefone` VARCHAR(15) NOT NULL,
  `dia_semana` ENUM('Segunda a Sexta','Segunda a Sábado','Todos os dias') DEFAULT NULL,
  `abertura` TIME DEFAULT NULL,
  `fechamento` TIME DEFAULT NULL,
  `rua` VARCHAR(100) NOT NULL,
  `numero` VARCHAR(10) NOT NULL,
  `complemento` VARCHAR(255) DEFAULT NULL,
  `bairro` VARCHAR(100) NOT NULL,
  `cidade` VARCHAR(50) NOT NULL,
  `estado` CHAR(2) NOT NULL,
  `cep` CHAR(8) NOT NULL,
  `capacidade_maxima` INT DEFAULT 50,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `administrador` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cpf` CHAR(11) NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `reset_token_hash` VARCHAR(255) DEFAULT NULL,
  `reset_token_expires_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`)
);

CREATE TABLE IF NOT EXISTS `aluno` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cpf` CHAR(11) NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `genero` ENUM('masculino','feminino','outro') NOT NULL,
  `data_nascimento` DATE NOT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `reset_token_hash` VARCHAR(255) DEFAULT NULL,
  `reset_token_expires_at` DATETIME DEFAULT NULL,
  `status` ENUM('ativo','inativo') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`)
);

CREATE TABLE IF NOT EXISTS `planos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `descricao` VARCHAR(255) NOT NULL,
  `valor` DECIMAL(10,2) NOT NULL,
  `duracao` INT NOT NULL,
  `tipo` ENUM('Principal','Adicional') NOT NULL,
  `Academia_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Plano_Academia1_idx` (`Academia_id`),
  CONSTRAINT `fk_Plano_Academia`
    FOREIGN KEY (`Academia_id`)
    REFERENCES `academia` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `assinatura` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `status` ENUM('ativo','inativo') NOT NULL,
  `data_inicio` DATE NOT NULL,
  `data_fim` DATE NOT NULL,
  `metodo_pagamento` ENUM('Cartão de Crédito','Cartão de Débito','Boleto','Pix') NOT NULL,
  `data_pagamento` DATE DEFAULT NULL,
  `valor_pago` DECIMAL(10,2) NOT NULL,
  `Planos_id` INT NOT NULL,
  `Aluno_id` INT NOT NULL,
  `numero_cartao` VARCHAR(20) DEFAULT NULL,
  `nome_titular` VARCHAR(100) DEFAULT NULL,
  `validade_cartao` DATE DEFAULT NULL,
  `codigo_seguranca` VARCHAR(4) DEFAULT NULL,
  `cpf_titular` CHAR(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Assinatura_Planos1_idx` (`Planos_id`),
  KEY `fk_Assinatura_Aluno1_idx` (`Aluno_id`),
  CONSTRAINT `fk_Assinatura_Planos`
    FOREIGN KEY (`Planos_id`)
    REFERENCES `planos` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Assinatura_Aluno`
    FOREIGN KEY (`Aluno_id`)
    REFERENCES `aluno` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `entrada_saida` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `data_entrada` DATETIME NOT NULL,
  `data_saida` DATETIME DEFAULT NULL,
  `Academia_id` INT NOT NULL,
  `Aluno_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Entrada_Saida_Academia1_idx` (`Academia_id`),
  KEY `fk_Entrada_Saida_Aluno1_idx` (`Aluno_id`),
  CONSTRAINT `fk_Entrada_Saida_Academia`
    FOREIGN KEY (`Academia_id`)
    REFERENCES `academia` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Entrada_Saida_Aluno`
    FOREIGN KEY (`Aluno_id`)
    REFERENCES `aluno` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cpf` CHAR(11) NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `telefone` VARCHAR(15) DEFAULT NULL,
  `cargo` VARCHAR(50) DEFAULT NULL,
  `data_contrat` DATE DEFAULT NULL,
  `genero` ENUM('masculino','feminino','outro') DEFAULT NULL,
  `tipo` ENUM('gerente', 'funcionario') NOT NULL,
  `Academia_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `fk_Funcionarios_Academia_idx` (`Academia_id`),
  CONSTRAINT `fk_Funcionarios_Academia`
    FOREIGN KEY (`Academia_id`)
    REFERENCES `academia` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- Inserção exemplo (omitindo ID, que é AUTO_INCREMENT)
INSERT INTO `administrador`(`cpf`, `nome`, `email`, `senha`)
VALUES ('12345678900', 'Admin Exemplo', 'admin@crowdgym.com', '123456');  -- Senha deve ser criptografada em produção
