CREATE TABLE Motivo (
       idMotivo             INTEGER NOT NULL,
       descricao            CHAR(18) NULL,
       dataCadastro         CHAR(18) NULL,
       dataBaixa            CHAR(18) NULL,
       situacao             CHAR(18) NULL,
       PRIMARY KEY (idMotivo)
);


CREATE TABLE Status (
       idStatus             INTEGER NOT NULL,
       nome                 VARCHAR(100) NOT NULL,
       dataCadastro         DATE NOT NULL,
       dataBaixa            CHAR(18) NULL,
       situacao             BOOLEAN NOT NULL,
       PRIMARY KEY (idStatus)
);


CREATE TABLE Nivel (
       idNivel              INTEGER NOT NULL,
       descricao            VARCHAR(100) NOT NULL,
       dataCadastro         DATE NOT NULL,
       databaixa            DATE NULL,
       situacao             BOOLEAN NOT NULL,
       PRIMARY KEY (idNivel)
);


CREATE TABLE Usuario (
       idUsuario            INTEGER NOT NULL,
       idNivel              INTEGER NOT NULL,
       nome                 VARCHAR(100) NOT NULL,
       login                VARCHAR(50) NOT NULL,
       senha                VARCHAR(50) NOT NULL,
       dataCadastro         DATE NOT NULL,
       dataBaixa            DATE NULL,
       situacao             BOOLEAN NOT NULL,
       PRIMARY KEY (idUsuario), 
       FOREIGN KEY (idNivel)
                             REFERENCES Nivel
);


CREATE TABLE Categoria (
       idCategoria          INTEGER NOT NULL,
       descricao            VARCHAR(50) NOT NULL,
       dataCadastro         DATE NOT NULL,
       dataBaixa            DATE NULL,
       situacao             BOOLEAN NOT NULL,
       PRIMARY KEY (idCategoria)
);


CREATE TABLE Pessoa (
       idPessoa             INTEGER NOT NULL,
       nome                 VARCHAR(100) NOT NULL,
       rua                  VARCHAR(100) NULL,
       numero               INTEGER NULL,
       complemento          VARCHAR(50) NULL,
       bairro               VARCHAR(50) NULL,
       cep                  CHAR(10) NULL,
       cidade               VARCHAR(50) NULL,
       estado               CHAR(2) NULL,
       telefone             CHAR(14) NOT NULL,
       fax                  CHAR(14) NULL,
       email                VARCHAR(100) NULL,
       dataCadastro         DATE NOT NULL,
       dataBaixa            DATE NULL,
       situacao             BOOLEAN NOT NULL,
       PRIMARY KEY (idPessoa)
);


CREATE TABLE Agregado (
       idAgregado           INTEGER NOT NULL,
       idPessoa             INTEGER NOT NULL,
       cnpjCpf              VARCHAR(18) NULL,
       inscEstadualRg       VARCHAR(20) NULL,
       PRIMARY KEY (idAgregado), 
       FOREIGN KEY (idPessoa)
                             REFERENCES Pessoa
);


CREATE TABLE Veiculo (
       idVeiculo            INTEGER NOT NULL,
       idCategoria          INTEGER NOT NULL,
       idAgregado           INTEGER NOT NULL,
       placa                CHAR(8) NULL,
       marca                VARCHAR(50) NULL,
       modelo               VARCHAR(50) NULL,
       prefixo              VARCHAR(20) NOT NULL,
       dataCadastro         DATE NOT NULL,
       dataBaixa            DATE NULL,
       situacao             BOOLEAN NOT NULL,
       PRIMARY KEY (idVeiculo), 
       FOREIGN KEY (idCategoria)
                             REFERENCES Categoria, 
       FOREIGN KEY (idAgregado)
                             REFERENCES Agregado
);


CREATE TABLE Fornecedor (
       idFornecedor         INTEGER NOT NULL,
       idPessoa             INTEGER NOT NULL,
       inscEstadual         VARCHAR(20) NOT NULL,
       cnpj                 CHAR(18) NOT NULL,
       razaoSocial          VARCHAR(100) NOT NULL,
       PRIMARY KEY (idFornecedor), 
       FOREIGN KEY (idPessoa)
                             REFERENCES Pessoa
);


CREATE TABLE Contato (
       idContato            INTEGER NOT NULL,
       idPessoa             INTEGER NOT NULL,
       nome                 VARCHAR(100) NOT NULL,
       funcao               VARCHAR(50) NULL,
       telefone             CHAR(14) NOT NULL,
       celular              CHAR(14) NULL,
       ramal                VARCHAR(5) NULL,
       email                VARCHAR(100) NULL,
       dataCadastro         DATE NOT NULL,
       dataBaixa            DATE NULL,
       situacao             BOOLEAN NOT NULL,
       PRIMARY KEY (idContato), 
       FOREIGN KEY (idPessoa)
                             REFERENCES Pessoa
);


CREATE TABLE FrequenciaColeta (
       idFrequenciaColeta   INTEGER NOT NULL,
       descricao            VARCHAR(100) NOT NULL,
       dataCadastro         DATE NOT NULL,
       dataBaixa            DATE NULL,
       situacao             BOOLEAN NOT NULL,
       PRIMARY KEY (idFrequenciaColeta)
);


CREATE TABLE Cliente (
       idCliente            INTEGER NOT NULL,
       idPessoa             INTEGER NOT NULL,
       idFrequenciaColeta   INTEGER NULL,
       cnpjCpf              VARCHAR(18) NOT NULL,
       inscEstadualRg       VARCHAR(20) NULL,
       PRIMARY KEY (idCliente), 
       FOREIGN KEY (idFrequenciaColeta)
                             REFERENCES FrequenciaColeta, 
       FOREIGN KEY (idPessoa)
                             REFERENCES Pessoa
);


CREATE TABLE Coleta (
       idColeta             INTEGER NOT NULL,
       versao               INTEGER NOT NULL,
       idCliente            INTEGER NULL,
       idContato            INTEGER NULL,
       idVeiculo            INTEGER NULL,
       idFornecedor         INTEGER NULL,
       idUsuario            INTEGER NULL,
       idStatus             INTEGER NULL,
       idMotivo             INTEGER NULL,
       horário              TIME NULL,
       data                 DATE NOT NULL,
       qtdadeNotaFiscal     INTEGER NULL,
       valorNotaFiscal      FLOAT NULL,
       qtdadeVolumes        INTEGER NULL,
       peso                 FLOAT NULL,
       dataCadastro         TIMESTAMP NOT NULL,
       dataBaixa            TIMESTAMP NULL,
       situacao             BOOLEAN NULL,
       PRIMARY KEY (idColeta, versao), 
       FOREIGN KEY (idMotivo)
                             REFERENCES Motivo, 
       FOREIGN KEY (idStatus)
                             REFERENCES Status, 
       FOREIGN KEY (idUsuario)
                             REFERENCES Usuario, 
       FOREIGN KEY (idVeiculo)
                             REFERENCES Veiculo, 
       FOREIGN KEY (idFornecedor)
                             REFERENCES Fornecedor, 
       FOREIGN KEY (idContato)
                             REFERENCES Contato, 
       FOREIGN KEY (idCliente)
                             REFERENCES Cliente
);