
CREATE TABLE Noticias (
       id                   INTEGER NOT NULL,
       titulo               VARCHAR(200) NOT NULL,
       descricao            TEXT NOT NULL,
       autor                VARCHAR(200) NOT NULL,
       PRIMARY KEY (id)
);


CREATE TABLE Trabalhos (
       id                   INTEGER NOT NULL,
       titulo               VARCHAR(200) NOT NULL,
       foto                 VARCHAR(200) NOT NULL,
       descricao            TEXT NOT NULL,
       PRIMARY KEY (id)
);


CREATE TABLE Servicos (
       id                   INTEGER NOT NULL,
       titulo               VARCHAR(200) NULL,
       descricao            TEXT NULL,
       PRIMARY KEY (id)
);


CREATE TABLE Dicas (
       id                   INTEGER NOT NULL,
       titulo               VARCHAR(200) NOT NULL,
       descricao            TEXT NOT NULL,
       PRIMARY KEY (id)
);


CREATE TABLE Links (
       id                   INTEGER NOT NULL,
       titulo               VARCHAR(200) NOT NULL,
       link                 VARCHAR(200) NOT NULL,
       descricao            TEXT NOT NULL,
       PRIMARY KEY (id)
);


CREATE TABLE Equipe (
       id                   INTEGER NOT NULL,
       nome                 VARCHAR(200) NOT NULL,
       email                VARCHAR(200) NOT NULL,
       apresentacao         TEXT NOT NULL,
       PRIMARY KEY (id)
);


CREATE TABLE Informacoes (
       historico            TEXT NOT NULL,
       equipe               TEXT NOT NULL,
       servicos             TEXT NOT NULL,
       links                TEXT NOT NULL,
       dicas                TEXT NOT NULL,
       trabalhos            TEXT NOT NULL
);



