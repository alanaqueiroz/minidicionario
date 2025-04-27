CREATE DATABASE IF NOT EXISTS minidicionario;

USE minidicionario;

CREATE TABLE IF NOT EXISTS palavras (
    id INT PRIMARY KEY AUTO_INCREMENT,
    palavra VARCHAR(50) NOT NULL,
    disciplina VARCHAR(50) NOT NULL,
    conceito VARCHAR(1000) NOT NULL
);