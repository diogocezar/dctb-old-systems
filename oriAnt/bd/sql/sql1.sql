
CREATE TABLE Grupo (
       idGrupo              INTEGER NOT NULL,
       contGrupo            INTEGER NOT NULL,
       nomeGrupo            VARCHAR(50) NOT NULL,
       PRIMARY KEY (idGrupo)
);


CREATE TABLE Pagina (
       idPagina             INTEGER NOT NULL,
       ultimoAcesso         TIMESTAMP NOT NULL,
       urlPagina            VARCHAR(250) NOT NULL,
       contPagina           INTEGER NOT NULL,
       PRIMARY KEY (idPagina)
);


CREATE TABLE ParametrosAdm (
       paLogin              VARCHAR(15) NOT NULL,
       paSenha              VARCHAR(15) NOT NULL,
       kAcrecimoFeromonio   INTEGER NOT NULL,
       patchSite            VARCHAR(250) NOT NULL
);


CREATE TABLE Feromonio (
       idFeromonio          INTEGER NOT NULL,
       idPaginaOrigem       FLOAT NOT NULL,
       idPaginaDestino      FLOAT NOT NULL,
       idGrupo              CHAR(18) NOT NULL,
       qtdFeromonio         FLOAT NOT NULL,
       PRIMARY KEY (idFeromonio), 
       FOREIGN KEY (idGrupo)
                             REFERENCES Grupo, 
       FOREIGN KEY (idPaginaDestino)
                             REFERENCES Pagina, 
       FOREIGN KEY (idPaginaOrigem)
                             REFERENCES Pagina
);


CREATE TABLE CorLink (
       corHexadecimal       VARCHAR(7) NOT NULL,
       qtdMinFeromonio      FLOAT NOT NULL,
       qtdMaxFeromonio      FLOAT NOT NULL
);



