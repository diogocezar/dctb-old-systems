
CREATE TABLE Cursos (
       cur_cod              INTEGER NOT NULL,
       cur_nome             VARCHAR(100) NOT NULL,
       cur_apresentacao     LONGTEXT NOT NULL,
       cur_objetivos        LONGTEXT NOT NULL,
       cur_certificado      LONGTEXT NOT NULL,
       cur_inicio           DATE NOT NULL,
       cur_termino          DATE NOT NULL,
       cur_periodo_inscricao VARCHAR(100) NOT NULL,
       cur_periodo_matricula VARCHAR(100) NOT NULL,
       cur_turno_funcionamento VARCHAR(100) NOT NULL,
       cur_vagas            INTEGER NOT NULL,
       cur_complementar     LONGTEXT NULL,
       cur_tx_inscricao     VARCHAR(15) NOT NULL,
       cur_matricula        VARCHAR(250) NOT NULL,
       cur_mensalidades     VARCHAR(250) NOT NULL,
       cur_resumo           LONGTEXT NOT NULL,
       PRIMARY KEY (cur_cod)
);


CREATE TABLE Administradores (
       adm_cod              INTEGER NOT NULL,
       cur_cod              INTEGER NULL,
       adm_nome             VARCHAR(50) NOT NULL,
       adm_login            VARCHAR(15) NOT NULL,
       adm_senha            VARCHAR(15) NOT NULL,
       adm_email            VARCHAR(50) NOT NULL,
       PRIMARY KEY (adm_cod), 
       FOREIGN KEY (cur_cod)
                             REFERENCES Cursos
);


CREATE TABLE Noticias (
       not_cod              INTEGER NOT NULL,
       cur_cod              INTEGER NOT NULL,
       not_titulo           VARCHAR(250) NOT NULL,
       not_conteudo         LONGTEXT NOT NULL,
       not_quando           TIMESTAMP NOT NULL,
       adm_cod              INTEGER NOT NULL,
       PRIMARY KEY (not_cod), 
       FOREIGN KEY (adm_cod)
                             REFERENCES Administradores, 
       FOREIGN KEY (cur_cod)
                             REFERENCES Cursos
);


CREATE TABLE Inscricoes (
       ins_cod              INTEGER NOT NULL,
       cur_cod              INTEGER NOT NULL,
       ins_nome             VARCHAR(50) NOT NULL,
       ins_cpf              VARCHAR(18) NOT NULL,
       ins_rg               VARCHAR(30) NOT NULL,
       ins_orgao_emissor    VARCHAR(100) NOT NULL,
       ins_data_nascimento  DATE NOT NULL,
       ins_estado_civil     VARCHAR(15) NOT NULL,
       ins_rua              VARCHAR(100) NOT NULL,
       ins_numero           INTEGER NULL,
       ins_complemento      VARCHAR(100) NULL,
       ins_bairro           VARCHAR(100) NOT NULL,
       ins_cidade           VARCHAR(100) NOT NULL,
       ins_estado           VARCHAR(2) NOT NULL,
       ins_cep              VARCHAR(10) NOT NULL,
       ins_telefone         VARCHAR(15) NOT NULL,
       ins_celular          VARCHAR(15) NULL,
       ins_email            VARCHAR(50) NOT NULL,
       ins_quando           TIMESTAMP NOT NULL,
       PRIMARY KEY (ins_cod), 
       FOREIGN KEY (cur_cod)
                             REFERENCES Cursos
);


CREATE TABLE Professores (
       pro_cod              INTEGER NOT NULL,
       pro_nome             VARCHAR(50) NOT NULL,
       pro_atuacao          LONGTEXT NULL,
       pro_titulacao        LONGTEXT NULL,
       pro_formacao         LONGTEXT NULL,
       pro_email            VARCHAR(50) NOT NULL,
       pro_pag_pessoal      VARCHAR(200) NULL,
       PRIMARY KEY (pro_cod)
);


CREATE TABLE Disciplinas (
       dic_cod              INTEGER NOT NULL,
       cur_cod              INTEGER NULL,
       pro_cod              INTEGER NULL,
       dic_nome             VARCHAR(200) NULL,
       dic_carga_horaria    INTEGER NULL,
       dic_descricao        LONGTEXT NULL,
       PRIMARY KEY (dic_cod), 
       FOREIGN KEY (pro_cod)
                             REFERENCES Professores, 
       FOREIGN KEY (cur_cod)
                             REFERENCES Cursos
);


CREATE TABLE Contato (
       con_cod              INTEGER NOT NULL,
       cur_cod              INTEGER NOT NULL,
       con_nome             VARCHAR(50) NOT NULL,
       con_telefone         VARCHAR(15) NULL,
       con_celular          VARCHAR(15) NULL,
       con_cidade           VARCHAR(50) NULL,
       con_estado           VARCHAR(2) NULL,
       con_email            VARCHAR(50) NOT NULL,
       con_quando           TIMESTAMP NOT NULL,
       PRIMARY KEY (con_cod), 
       FOREIGN KEY (cur_cod)
                             REFERENCES Cursos
);



