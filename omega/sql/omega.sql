
CREATE TABLE email (
       ema_id               INTEGER NOT NULL,
       ema_email            VARCHAR(100) NOT NULL,
       PRIMARY KEY (ema_id)
);


CREATE TABLE tipo_user (
       tip_id_user          INTEGER NOT NULL,
       tip_tipo             VARCHAR(50) NOT NULL,
       tip_nivel            INTEGER NOT NULL,
       PRIMARY KEY (tip_id_user)
);


CREATE TABLE usuario (
       usu_cod              INTEGER NOT NULL,
       ema_id               CHAR(18) NOT NULL,
       usu_nome             VARCHAR(50) NOT NULL,
       usu_sobrenome        VARCHAR(50) NOT NULL,
       usu_login            VARCHAR(15) NOT NULL,
       usu_senha            VARCHAR(15) NOT NULL,
       tip_id_user          CHAR(18) NOT NULL,
       PRIMARY KEY (usu_cod), 
       FOREIGN KEY (ema_id)
                             REFERENCES email, 
       FOREIGN KEY (tip_id_user)
                             REFERENCES tipo_user
);


CREATE TABLE enquete (
       enq_id               INTEGER NOT NULL,
       usu_cod              INTEGER NOT NULL,
       enq_pergunta         VARCHAR(250) NOT NULL,
       enq_exibir           INTEGER NOT NULL,
       PRIMARY KEY (enq_id), 
       FOREIGN KEY (usu_cod)
                             REFERENCES usuario
);


CREATE TABLE respostas (
       res_id               INTEGER NOT NULL,
       enq_id               INTEGER NOT NULL,
       res_resposta         VARCHAR(250) NOT NULL,
       res_votos            INTEGER NOT NULL,
       PRIMARY KEY (res_id), 
       FOREIGN KEY (enq_id)
                             REFERENCES enquete
);


CREATE TABLE novidade (
       nov_id               INTEGER NOT NULL,
       usu_cod              INTEGER NOT NULL,
       nov_titulo           VARCHAR(250) NOT NULL,
       nov_conteudo         TEXT NOT NULL,
       nov_quando           TIMESTAMP NOT NULL,
       PRIMARY KEY (nov_id), 
       FOREIGN KEY (usu_cod)
                             REFERENCES usuario
);


CREATE TABLE categoria (
       cat_cod              INTEGER NOT NULL,
       cat_nome             VARCHAR(100) NOT NULL,
       cat_descricao        LONGTEXT NOT NULL,
       cat_temp_loc         INTEGER NOT NULL,
       cat_preco            FLOAT NOT NULL,
       PRIMARY KEY (cat_cod)
);


CREATE TABLE genero (
       gen_cod              INTEGER NOT NULL,
       gen_nome             VARCHAR(50) NOT NULL,
       gen_descricao        LONGTEXT NOT NULL,
       PRIMARY KEY (gen_cod)
);


CREATE TABLE classificacao (
       cla_cod              INTEGER NOT NULL,
       cla_classificacao    VARCHAR(250) NOT NULL,
       cla_idade_recomendada VARCHAR(250) NOT NULL,
       PRIMARY KEY (cla_cod)
);


CREATE TABLE filme (
       fil_cod              INTEGER NOT NULL,
       cat_cod              INTEGER NOT NULL,
       cla_cod              INTEGER NOT NULL,
       fil_titulo           VARCHAR(250) NOT NULL,
       fil_titulo_original  VARCHAR(250) NULL,
       fil_ano              INTEGER NOT NULL,
       fil_duracao          VARCHAR(50) NOT NULL,
       fil_sinopse          LONGTEXT NOT NULL,
       fil_foto             VARCHAR(200) NULL,
       fil_destaque         INTEGER NOT NULL,
       PRIMARY KEY (fil_cod), 
       FOREIGN KEY (cla_cod)
                             REFERENCES classificacao, 
       FOREIGN KEY (cat_cod)
                             REFERENCES categoria
);


CREATE TABLE midia (
       mid_cod              INTEGER NOT NULL,
       fil_cod              INTEGER NOT NULL,
       mid_tipo             VARCHAR(50) NOT NULL,
       mid_audio            VARCHAR(250) NOT NULL,
       mid_legenda          VARCHAR(250) NOT NULL,
       PRIMARY KEY (mid_cod), 
       FOREIGN KEY (fil_cod)
                             REFERENCES filme
);


CREATE TABLE taxa_entrega (
       txe_cod              INTEGER NOT NULL,
       txe_localizacao      VARCHAR(100) NULL,
       txe_valor            FLOAT NULL,
       PRIMARY KEY (txe_cod)
);


CREATE TABLE cliente (
       cli_cpf              INTEGER NOT NULL,
       usu_cod              CHAR(18) NOT NULL,
       cli_rg               VARCHAR(30) NOT NULL,
       cli_rua              VARCHAR(100) NOT NULL,
       cli_numero           INTEGER NOT NULL,
       cli_bairro           VARCHAR(100) NOT NULL,
       cli_telefone         VARCHAR(15) NOT NULL,
       cli_tel_comercial    VARCHAR(15) NULL,
       cli_celular          VARCHAR(15) NULL,
       cli_data_nascimento  DATE NOT NULL,
       PRIMARY KEY (cli_cpf), 
       FOREIGN KEY (usu_cod)
                             REFERENCES usuario
);


CREATE TABLE locacao (
       loc_cod              INTEGER NOT NULL,
       cli_cpf              INTEGER NOT NULL,
       txe_cod              INTEGER NOT NULL,
       loc_quando           DATE NULL,
       loc_data_entrega     DATE NULL,
       loc_hora_entraga     VARCHAR(5) NULL,
       loc_data_busca       DATE NULL,
       loc_hora_busca       VARCHAR(5) NULL,
       loc_valor            FLOAT NULL,
       loc_multa            FLOAT NULL,
       loc_situacao         VARCHAR(30) NULL,
       PRIMARY KEY (loc_cod), 
       FOREIGN KEY (txe_cod)
                             REFERENCES taxa_entrega, 
       FOREIGN KEY (cli_cpf)
                             REFERENCES cliente
);


CREATE TABLE midia_locacao (
       mid_cod              INTEGER NOT NULL,
       loc_cod              INTEGER NOT NULL,
       cod_midia_loc        CHAR(18) NOT NULL,
       PRIMARY KEY (mid_cod, loc_cod, cod_midia_loc), 
       FOREIGN KEY (loc_cod)
                             REFERENCES locacao, 
       FOREIGN KEY (mid_cod)
                             REFERENCES midia
);


CREATE TABLE produtos (
       pro_cod              INTEGER NOT NULL,
       pro_nome             VARCHAR(100) NOT NULL,
       pro_qtd              INTEGER NOT NULL,
       pro_preco            FLOAT NOT NULL,
       PRIMARY KEY (pro_cod)
);


CREATE TABLE diretor (
       dir_cod              INTEGER NOT NULL,
       dir_nome             VARCHAR(50) NOT NULL,
       PRIMARY KEY (dir_cod)
);


CREATE TABLE ator (
       ato_cod              INTEGER NOT NULL,
       ato_nome             VARCHAR(50) NOT NULL,
       ato_nome_nascimento  VARCHAR(50) NULL,
       ato_profissao        VARCHAR(250) NULL,
       ato_data_nascimento  DATE NULL,
       ato_pais_natal       VARCHAR(50) NULL,
       ato_cidade_natal     VARCHAR(50) NULL,
       ato_biografia        LONGTEXT NULL,
       ato_foto             VARCHAR(200) NULL,
       PRIMARY KEY (ato_cod)
);


CREATE TABLE genero_filme (
       gen_cod              INTEGER NOT NULL,
       fil_cod              INTEGER NOT NULL,
       PRIMARY KEY (gen_cod, fil_cod), 
       FOREIGN KEY (fil_cod)
                             REFERENCES filme, 
       FOREIGN KEY (gen_cod)
                             REFERENCES genero
);


CREATE TABLE diretor_filme (
       dir_cod              INTEGER NOT NULL,
       fil_cod              INTEGER NOT NULL,
       PRIMARY KEY (dir_cod, fil_cod), 
       FOREIGN KEY (fil_cod)
                             REFERENCES filme, 
       FOREIGN KEY (dir_cod)
                             REFERENCES diretor
);


CREATE TABLE ator_filme (
       ato_cod              INTEGER NOT NULL,
       fil_cod              INTEGER NOT NULL,
       PRIMARY KEY (ato_cod, fil_cod), 
       FOREIGN KEY (fil_cod)
                             REFERENCES filme, 
       FOREIGN KEY (ato_cod)
                             REFERENCES ator
);


CREATE TABLE avaliacao (
       fil_cod              INTEGER NOT NULL,
       cli_cpf              INTEGER NOT NULL,
       ava_nota             INTEGER NOT NULL,
       PRIMARY KEY (fil_cod, cli_cpf), 
       FOREIGN KEY (fil_cod)
                             REFERENCES filme, 
       FOREIGN KEY (cli_cpf)
                             REFERENCES cliente
);


CREATE TABLE produtos_Locacao (
       pro_cod              INTEGER NOT NULL,
       loc_cod              INTEGER NOT NULL,
       PRIMARY KEY (pro_cod, loc_cod), 
       FOREIGN KEY (loc_cod)
                             REFERENCES locacao, 
       FOREIGN KEY (pro_cod)
                             REFERENCES produtos
);



