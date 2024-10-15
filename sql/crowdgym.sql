CREATE TABLE `Academia` (
`id` INT NOT NULL AUTO_INCREMENT,
`nome` VARCHAR(100) NOT NULL,
`telefone` VARCHAR(15) NOT NULL,
`dia_semana` ENUM('Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo') NULL,
`abertura` TIME NULL,
`fechamento` TIME NULL,
`rua` VARCHAR(100) NOT NULL,
`numero` VARCHAR(10) NOT NULL,
`bairro` VARCHAR(50) NOT NULL,
`cidade` VARCHAR(50) NOT NULL,
`estado` CHAR(2) NOT NULL,
`cep` CHAR(8) NOT NULL,
PRIMARY KEY (`id`));

CREATE TABLE `Gerente` (
`cpf` CHAR(11) NOT NULL,
`nome` VARCHAR(100) NOT NULL,
`email` VARCHAR(255) NOT NULL,
`telefone` VARCHAR(15) NOT NULL,
`senha` VARCHAR(45) NOT NULL,
`Academia_id` INT NOT NULL,
PRIMARY KEY (`cpf`),
INDEX `fk_Funcionario_Academia_idx` (`Academia_id` ASC) VISIBLE,
CONSTRAINT `fk_Funcionario_Academia`
FOREIGN KEY (`Academia_id`)
REFERENCES `Academia` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION);

CREATE TABLE `Aluno` (
`cpf` CHAR(11) NOT NULL,
`nome` VARCHAR(100) NOT NULL,
`email` VARCHAR(255) NOT NULL,
`senha` VARCHAR(45) NOT NULL,
`genero` ENUM('masculino', 'feminino', 'outro') NOT NULL,
`data_nascimento` DATE NOT NULL,
`foto` VARCHAR(255) NULL,
PRIMARY KEY (`cpf`));

CREATE TABLE `Plano` (
`id` INT NOT NULL AUTO_INCREMENT,
`nome` VARCHAR(100) NOT NULL,
`descricao` VARCHAR(255) NOT NULL,
`valor` DECIMAL(10,2) NOT NULL,
`duracao` INT NOT NULL,
`Academia_id` INT NOT NULL,
PRIMARY KEY (`id`),
INDEX `fk_Plano_Academia1_idx` (`Academia_id` ASC) VISIBLE,
CONSTRAINT `fk_Plano_Academia1`
FOREIGN KEY (`Academia_id`)
REFERENCES `Academia` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION);

CREATE TABLE `Assinatura` (
`id` INT NOT NULL AUTO_INCREMENT,
`status` ENUM('ativo', 'inativo') NOT NULL,
`valor_pago` DECIMAL(10,2) NOT NULL,
`data_inicio` DATE NOT NULL,
`data_fim` DATE NOT NULL,
`Plano_id` INT NOT NULL,
`Aluno_cpf` CHAR(11) NOT NULL,
PRIMARY KEY (`id`),
INDEX `fk_Assinatura_Plano1_idx` (`Plano_id` ASC) VISIBLE,
INDEX `fk_Assinatura_Aluno1_idx` (`Aluno_cpf` ASC) VISIBLE,
CONSTRAINT `fk_Assinatura_Plano1`
FOREIGN KEY (`Plano_id`)
REFERENCES `Plano` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `fk_Assinatura_Aluno1`
FOREIGN KEY (`Aluno_cpf`)
REFERENCES `Aluno` (`cpf`)
ON DELETE NO ACTION
ON UPDATE NO ACTION);

CREATE TABLE `Pagamento` (
`id` INT NOT NULL AUTO_INCREMENT,
`valor_pago` DECIMAL(10,2) NOT NULL,
`metodo_pagamento` ENUM('Cartão de Crédito', 'Cartão de Débito', 'Boleto', 'Pix') NOT NULL,
`data_pagamento` DATE NOT NULL,
`Assinatura_id` INT NOT NULL,
`Aluno_cpf` CHAR(11) NOT NULL,
PRIMARY KEY (`id`),
INDEX `fk_Pagamento_Assinatura1_idx` (`Assinatura_id` ASC) VISIBLE,
INDEX `fk_Pagamento_Aluno1_idx` (`Aluno_cpf` ASC) VISIBLE,
CONSTRAINT `fk_Pagamento_Assinatura1`
FOREIGN KEY (`Assinatura_id`)
REFERENCES `Assinatura` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `fk_Pagamento_Aluno1`
FOREIGN KEY (`Aluno_cpf`)
REFERENCES `Aluno` (`cpf`)
ON DELETE NO ACTION
ON UPDATE NO ACTION);

CREATE TABLE `Entrada_Saida` (
`id` INT NOT NULL AUTO_INCREMENT,
`data_entrada` DATETIME NOT NULL,
`data_saida` DATETIME NOT NULL,
`Academia_id` INT NOT NULL,
`Aluno_cpf` CHAR(11) NOT NULL,
PRIMARY KEY (`id`),
INDEX `fk_Entrada_Saida_Academia1_idx` (`Academia_id` ASC) VISIBLE,
INDEX `fk_Entrada_Saida_Aluno1_idx` (`Aluno_cpf` ASC) VISIBLE,
CONSTRAINT `fk_Entrada_Saida_Academia1`
FOREIGN KEY (`Academia_id`)
REFERENCES `Academia` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `fk_Entrada_Saida_Aluno1`
FOREIGN KEY (`Aluno_cpf`)
REFERENCES `Aluno` (`cpf`)
ON DELETE NO ACTION
ON UPDATE NO ACTION);

CREATE TABLE `Fluxo` (
`id` INT NOT NULL AUTO_INCREMENT,
`alunos` INT NOT NULL,
`data` DATE NOT NULL,
`Academia_id` INT NOT NULL,
PRIMARY KEY (`id`),
INDEX `fk_Fluxo_Academia1_idx` (`Academia_id` ASC) VISIBLE,
CONSTRAINT `fk_Fluxo_Academia1`
FOREIGN KEY (`Academia_id`)
REFERENCES `Academia` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION);

CREATE TABLE `Funcionario` (
`cpf` CHAR(11) NOT NULL,
`nome` VARCHAR(100) NOT NULL,
`email` VARCHAR(255) NOT NULL,
`senha` VARCHAR(45) NOT NULL,
`cargo` VARCHAR(50) NOT NULL,
`data_contrat` DATE NOT NULL,
`genero` ENUM('masculino', 'feminino', 'outro') NOT NULL,
`Gerente_cpf` CHAR(11) NOT NULL,
PRIMARY KEY (`cpf`),
INDEX `fk_Funcionario_Gerente1_idx` (`Gerente_cpf` ASC) VISIBLE,
CONSTRAINT `fk_Funcionario_Gerente1`
FOREIGN KEY (`Gerente_cpf`)
REFERENCES `Gerente` (`cpf`)
ON DELETE NO ACTION
ON UPDATE NO ACTION);