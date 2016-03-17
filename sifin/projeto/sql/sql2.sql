
CREATE TABLE pessoaFisica (
       idPessoaFisica       INTEGER NOT NULL,
       cpf                  VARCHAR(11) NOT NULL,
       rg                   VARCHAR(15) NULL,
       nome                 VARCHAR(200) NULL,
       sobrenome            VARCHAR(200) NULL,
       PRIMARY KEY (idPessoaFisica)
);


CREATE TABLE pessoaJuridica (
       idPessoaJuridica     INTEGER NOT NULL,
       cnpj                 VARCHAR(14) NOT NULL,
       inscricaoEstadual    VARCHAR(15) NULL,
       inscricaoMunicipal   VARCHAR(15) NULL,
       razaoSocial          VARCHAR(200) NOT NULL,
       nomeFantasia         VARCHAR(200) NOT NULL,
       PRIMARY KEY (idPessoaJuridica)
);


CREATE TABLE pessoa (
       idPessoa             INTEGER NOT NULL,
       idPessoaJuridica     INTEGER NULL,
       idPessoaFisica       INTEGER NULL,
       endereco             VARCHAR(200) NOT NULL,
       bairro               VARCHAR(200) NOT NULL,
       cidade               VARCHAR(100) NULL,
       uf                   CHAR(2) NULL,
       cep                  VARCHAR(10) NOT NULL,
       fone                 VARCHAR(15) NOT NULL,
       fax                  VARCHAR(15) NULL,
       site                 VARCHAR(200) NULL,
       obs                  TEXT NULL,
       compraMinima         FLOAT NULL,
       situacao             BOOLEAN NULL,
       dataBaixa            DATE NULL,
       PRIMARY KEY (idPessoa), 
       FOREIGN KEY (idPessoaFisica)
                             REFERENCES pessoaFisica, 
       FOREIGN KEY (idPessoaJuridica)
                             REFERENCES pessoaJuridica
);


CREATE TABLE contato (
       idContato            INTEGER NOT NULL,
       idPessoa             INTEGER NOT NULL,
       nome                 VARCHAR(100) NOT NULL,
       email                VARCHAR(100) NULL,
       msn                  VARCHAR(100) NULL,
       skype                VARCHAR(100) NULL,
       fone                 CHAR(10) NOT NULL,
       fax                  CHAR(10) NULL,
       celular              CHAR(10) NULL,
       ramal                CHAR(10) NULL,
       departamento         VARCHAR(100) NULL,
       situacao             BOOLEAN NOT NULL,
       dataBaixa            DATE NULL,
       PRIMARY KEY (idContato), 
       FOREIGN KEY (idPessoa)
                             REFERENCES pessoa
);


CREATE TABLE periodicidade (
       idPeriodicidade      INTEGER NOT NULL,
       descricao            VARCHAR(50) NOT NULL,
       qtdDias              INTEGER NOT NULL,
       situacao             BOOLEAN NOT NULL,
       dataBaixa            DATE NULL,
       PRIMARY KEY (idPeriodicidade)
);


CREATE TABLE banco (
       idBanco              INTEGER NOT NULL,
       descricao            VARCHAR(50) NOT NULL,
       situacao             BOOLEAN NOT NULL,
       dataBaixa            DATE NULL,
       PRIMARY KEY (idBanco)
);


CREATE TABLE tipoDocumento (
       idTipoDocumento      INTEGER NOT NULL,
       descricao            VARCHAR(50) NOT NULL,
       situacao             BOOLEAN NOT NULL,
       dataBaixa            DATE NULL,
       PRIMARY KEY (idTipoDocumento)
);


CREATE TABLE nivel (
       idNivel              INTEGER NOT NULL,
       descricao            VARCHAR(100) NOT NULL,
       situacao             BOOLEAN NOT NULL,
       dataBaixa            DATE NULL,
       PRIMARY KEY (idNivel)
);


CREATE TABLE usuario (
       idUsuario            INTEGER NOT NULL,
       idNivel              INTEGER NOT NULL,
       nome                 VARCHAR(100) NOT NULL,
       login                VARCHAR(50) NOT NULL,
       senha                VARCHAR(30) NOT NULL,
       situacao             BOOLEAN NOT NULL,
       dataBaixa            DATE NULL,
       PRIMARY KEY (idUsuario), 
       FOREIGN KEY (idNivel)
                             REFERENCES nivel
);


CREATE TABLE conta (
       idConta              INTEGER NOT NULL,
       idUsuario            INTEGER NOT NULL,
       idUsuarioBaixa       INTEGER NULL,
       idTipoDocumento      INTEGER NOT NULL,
       idPeriodicidade      INTEGER NOT NULL,
       idBanco              INTEGER NULL,
       idPessoa             INTEGER NULL,
       documento            VARCHAR(50) NOT NULL,
       dataCadastro         DATE NOT NULL,
       descricao            VARCHAR(100) NULL,
       numParcelas          INTEGER NULL,
       valorTotal           FLOAT NULL,
       tipoConta            VARCHAR(20) NOT NULL,
       situacao             BOOLEAN NULL,
       PRIMARY KEY (idConta), 
       FOREIGN KEY (idPessoa)
                             REFERENCES pessoa, 
       FOREIGN KEY (idBanco)
                             REFERENCES banco, 
       FOREIGN KEY (idBanco)
                             REFERENCES periodicidade, 
       FOREIGN KEY (idTipoDocumento)
                             REFERENCES tipoDocumento, 
       FOREIGN KEY (idBanco)
                             REFERENCES usuario
);


CREATE TABLE parcela (
       idParcela            INTEGER NOT NULL,
       idConta              INTEGER NULL,
       valor                FLOAT NOT NULL,
       dataVencimento       DATE NULL,
       dataPagamento        DATE NULL,
       situacao             BOOLEAN NOT NULL,
       PRIMARY KEY (idParcela), 
       FOREIGN KEY (idConta)
                             REFERENCES conta
);



