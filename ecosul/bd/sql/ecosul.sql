
CREATE TABLE Cidades (
       idCidade             INTEGER NOT NULL,
       nomeCidade           VARCHAR(200) NOT NULL,
       descricaoCidade      TEXT NOT NULL,
       localizacaoCidade    TEXT NOT NULL,
       acessoCidade         TEXT NOT NULL,
       fotosCidade          VARCHAR(100) NOT NULL,
       PRIMARY KEY (idCidade)
);


CREATE TABLE tipoAtividade (
       idTipoAtividade      INTEGER NOT NULL,
       nomeTipoAtividade    VARCHAR(100) NULL,
       PRIMARY KEY (idTipoAtividade)
);


CREATE TABLE Atividades (
       idAtividades         INTEGER NOT NULL,
       nomeAtividade        VARCHAR(200) NULL,
       descricaoAtividade   TEXT NULL,
       localizacaoAtividade TEXT NULL,
       acessoAtividade      TEXT NULL,
       fotosAtividade       VARCHAR(100) NULL,
       idTipoAtividade      INTEGER NULL,
       PRIMARY KEY (idAtividades), 
       FOREIGN KEY (idTipoAtividade)
                             REFERENCES tipoAtividade
);


CREATE TABLE atividadesCidades (
       idAtividades         INTEGER NOT NULL,
       idCidade             INTEGER NOT NULL,
       PRIMARY KEY (idAtividades, idCidade), 
       FOREIGN KEY (idCidade)
                             REFERENCES Cidades, 
       FOREIGN KEY (idAtividades)
                             REFERENCES Atividades
);


CREATE TABLE tipoEcoturismo (
       idTipoEcoturismo     INTEGER NOT NULL,
       nomeTipoEcoturismo   VARCHAR(100) NULL,
       PRIMARY KEY (idTipoEcoturismo)
);


CREATE TABLE Ecoturismo (
       idEcoturismo         INTEGER NOT NULL,
       nomeEcoturismo       VARCHAR(200) NULL,
       localizacaoEcoturismo TEXT NULL,
       acessoEcoturismo     TEXT NULL,
       fotosEcoturismo      VARCHAR(100) NULL,
       idTipoEcoturismo     INTEGER NULL,
       PRIMARY KEY (idEcoturismo), 
       FOREIGN KEY (idTipoEcoturismo)
                             REFERENCES tipoEcoturismo
);


CREATE TABLE cidadesEcoturismo (
       idCidade             INTEGER NOT NULL,
       idEcoturismo         INTEGER NOT NULL,
       PRIMARY KEY (idCidade, idEcoturismo), 
       FOREIGN KEY (idEcoturismo)
                             REFERENCES Ecoturismo, 
       FOREIGN KEY (idCidade)
                             REFERENCES Cidades
);



