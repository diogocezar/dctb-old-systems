
CREATE TABLE Comentarios (
       pg                   VARCHAR(120) NOT NULL,
       nome                 VARCHAR(120) NOT NULL,
       email                VARCHAR(120) NOT NULL,
       url                  VARCHAR(120) NOT NULL,
       comentario           TEXT NOT NULL,
       timestamp            TIMESTAMP NOT NULL
);


CREATE TABLE Avaliacao (
       pg                   VARCHAR(120) NOT NULL,
       total                INTEGER NOT NULL,
       votantes             INTEGER NOT NULL
);


CREATE TABLE NoticiasRSS (
       idCategoria          INTEGER NOT NULL,
       idPai                INTEGER NULL,
       ordemMenu            VARCHAR(20) NOT NULL,
       nomeMenu             VARCHAR(30) NOT NULL,
       linkRSS              VARCHAR(100) NOT NULL,
       PRIMARY KEY (idCategoria, idPai), 
       FOREIGN KEY (idCategoria, idPai)
                             REFERENCES NoticiasRSS
);


CREATE TABLE Admin (
       idAdmin              INTEGER NOT NULL,
       nomeAdmin            VARCHAR(50) NOT NULL,
       loginAdmin           VARCHAR(20) NOT NULL,
       senhaAdmin           VARCHAR(20) NOT NULL,
       emailAdmin           VARCHAR(100) NOT NULL,
       PRIMARY KEY (idAdmin)
);



