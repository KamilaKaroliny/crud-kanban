CREATE DATABASE tarefas_db;
USE tarefas_db;

CREATE TABLE usuarios (
	id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    cep VARCHAR(9) NOT NULL,
    endereco VARCHAR(150) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado VARCHAR(2)
);

CREATE TABLE tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(100) NOT NULL,
    setor VARCHAR(100) NOT NULL,
    prioridade ENUM('Baixa', 'Média', 'Alta') NOT NULL,
    data_cadastro DATE NOT NULL,
    status_tarefa ENUM('Fazer', 'Fazendo', 'Pronto') NOT NULL,
    usuario_responsavel INT NOT NULL,
    FOREIGN KEY (usuario_responsavel) REFERENCES usuarios(id)
);

INSERT INTO usuarios (nome, email, senha) VALUES
('kamila karoliny', 'kamila@karoliny', 'kams123');

INSERT INTO tarefas (descricao, setor, prioridade, data_cadastro, status_tarefa, usuario_responsavel) VALUES
('Guardar os salgadinhos', 'Salgadinho', 'Média', '2025-09-10', 'Fazer', 1);