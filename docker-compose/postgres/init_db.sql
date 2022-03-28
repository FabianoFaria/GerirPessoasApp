CREATE TABLE users (
    id serial PRIMARY KEY,
    name VARCHAR ( 255 ) UNIQUE NOT NULL,
    email VARCHAR ( 255 ) UNIQUE NOT NULL,
    password VARCHAR ( 255 ) NOT NULL,
    data_criacao TIMESTAMP, 
    data_atualizacao TIMESTAMP
);

INSERT INTO users(name, email, password, data_criacao, data_atualizacao)
VALUES ('admin', 'admin@bar.com', '$2a$12$nTkA6erfkX8VhJ/NGk87s.BCm5Bh.gag6hXVBlJqAORy73PcvN.gm', (SELECT NOW()), (SELECT NOW()));
INSERT INTO users(name, email, password, data_criacao, data_atualizacao)
VALUES ('Ademir', 'ademir@bar.com', '$2a$12$nTkA6erfkX8VhJ/NGk87s.BCm5Bh.gag6hXVBlJqAORy73PcvN.gm', (SELECT NOW()), (SELECT NOW()));

CREATE TABLE pessoas (
    id serial PRIMARY KEY,
    pessoa_nome VARCHAR ( 255 ) UNIQUE NOT NULL,
    status VARCHAR ( 1 ) NOT NULL,
    data_criacao TIMESTAMP, 
    data_atualizacao TIMESTAMP
);

SET TIMEZONE TO 'America/Sao_Paulo';

INSERT INTO pessoas(pessoa_nome, status, data_criacao, data_atualizacao)
VALUES ('Pessoa B', 'A', (SELECT NOW()), (SELECT NOW()));
INSERT INTO pessoas(pessoa_nome, status, data_criacao, data_atualizacao)
VALUES ('Pessoa A', 'A', (SELECT NOW()), (SELECT NOW()));
INSERT INTO pessoas(pessoa_nome, status, data_criacao, data_atualizacao)
VALUES ('Pessoa C', 'A', (SELECT NOW()), (SELECT NOW()));