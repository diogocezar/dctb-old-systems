
CREATE TABLE Grupo (
       id                   INTEGER NOT NULL,
       cont                 INTEGER NOT NULL,
       nome                 VARCHAR(50) NOT NULL,
       PRIMARY KEY (id)
);


CREATE TABLE Pagina (
       id                   INTEGER NOT NULL,
       ultimo_acesso        TIMESTAMP NOT NULL,
       url                  VARCHAR(250) NOT NULL,
       cont                 INTEGER NOT NULL,
       PRIMARY KEY (id)
);


CREATE TABLE Feromonio (
       id                   INTEGER NOT NULL,
       id_origem            FLOAT NOT NULL,
       id_destino           FLOAT NOT NULL,
       id_grupo             CHAR(18) NOT NULL,
       qtd_feromonio        FLOAT NOT NULL,
       PRIMARY KEY (id), 
       FOREIGN KEY (id_grupo)
                             REFERENCES Grupo, 
       FOREIGN KEY (id_destino)
                             REFERENCES Pagina, 
       FOREIGN KEY (id_origem)
                             REFERENCES Pagina
);


CREATE TABLE ParametrosAdm (
       id                   INTEGER NOT NULL,
       login                VARCHAR(15) NOT NULL,
       senha                VARCHAR(15) NOT NULL,
       acrescimo_feromonio  FLOAT NOT NULL,
       tx_evaporacao        FLOAT NOT NULL,
       div_diferenca        FLOAT NOT NULL,
       PRIMARY KEY (id)
);



