    
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