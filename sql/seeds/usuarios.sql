CREATE DATABASE distribuidora;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);


CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE doces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    descricao TEXT,
    categoria_id INT,
    imagem VARCHAR(255),
    estoque INT NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);


-- ATENÇÃO: O sistema usa password_hash() (bcrypt) para senhas.
-- NÃO use SHA2() aqui, pois é incompatível com password_verify() no login.php.
-- Para criar usuários administradores, acesse: cadastrar_usuario.php
