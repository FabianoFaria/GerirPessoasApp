    
CREATE TABLE pessoas (
    pessoa_id serial PRIMARY KEY,
    pessoa_nome VARCHAR ( 255 ) UNIQUE NOT NULL,
    status VARCHAR ( 1 ) NOT NULL
);

INSERT INTO pessoas(pessoa_nome, status)
VALUES ('Pessoa B', 'A');
INSERT INTO pessoas(pessoa_nome, status)
VALUES ('Pessoa A', 'A');
INSERT INTO pessoas(pessoa_nome, status)
VALUES ('Pessoa C', 'A');