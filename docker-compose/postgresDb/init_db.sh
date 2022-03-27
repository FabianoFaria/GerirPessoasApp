#!/bin/bash
set -e
export PGPASSWORD=$POSTGRES_PASSWORD;
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
  CREATE USER $APP_DB_USER WITH PASSWORD '$APP_DB_PASS';
  CREATE DATABASE $APP_DB_NAME;
  GRANT ALL PRIVILEGES ON DATABASE $APP_DB_NAME TO $APP_DB_USER;
  \connect $APP_DB_NAME $APP_DB_USER
  BEGIN;
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
  COMMIT;
EOSQL