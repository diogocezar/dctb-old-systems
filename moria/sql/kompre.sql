
CREATE TABLE kom_Administradores (
       adm_cod              INTEGER NOT NULL,
       adm_nome             VARCHAR(50) NOT NULL,
       adm_email            VARCHAR(50) NOT NULL,
       adm_login            VARCHAR(15) NOT NULL,
       adm_senha            VARCHAR(15) NOT NULL,
       PRIMARY KEY (adm_cod)
);


CREATE TABLE kom_Categorias (
       cat_cod              INTEGER NOT NULL,
       cat_nome             VARCHAR(150) NOT NULL,
       cat_descricao        TEXT NOT NULL,
       PRIMARY KEY (cat_cod)
);


CREATE TABLE kom_Fabricantes (
       fab_cod              INTEGER NOT NULL,
       fab_nome             VARCHAR(150) NOT NULL,
       fab_telefone         VARCHAR(15) NULL,
       fab_website          VARCHAR(150) NULL,
       PRIMARY KEY (fab_cod)
);


CREATE TABLE kom_Produtos (
       pro_cod              INTEGER NOT NULL,
       pro_nome             VARCHAR(150) NOT NULL,
       pro_peso             FLOAT NOT NULL,
       pro_preco            FLOAT NOT NULL,
       pro_qtd              INTEGER NOT NULL,
       pro_disponibilidade  VARCHAR(50) NOT NULL,
       pro_classificacao    VARCHAR(50) NOT NULL,
       pro_promocao         VARCHAR(20) NOT NULL,
       pro_descricao        TEXT NOT NULL,
       pro_especificacao    TEXT NULL,
       pro_dados_tecnicos   TEXT NULL,
       pro_itens_inclusos   TEXT NULL,
       pro_garantia         VARCHAR(250) NULL,
       pro_quando           TIMESTAMP NOT NULL,
       cat_cod              INTEGER NOT NULL,
       fab_cod              INTEGER NOT NULL,
       PRIMARY KEY (pro_cod), 
       FOREIGN KEY (fab_cod)
                             REFERENCES kom_Fabricantes, 
       FOREIGN KEY (cat_cod)
                             REFERENCES kom_Categorias
);


CREATE TABLE kom_Fotos (
       fot_cod              INTEGER NOT NULL,
       fot_url              VARCHAR(150) NOT NULL,
       PRIMARY KEY (fot_cod)
);


CREATE TABLE kom_Produtos_Fotos (
       pro_cod              INTEGER NOT NULL,
       fot_cod              INTEGER NOT NULL,
       pro_fot_principal    CHAR(18) NULL,
       PRIMARY KEY (pro_cod, fot_cod), 
       FOREIGN KEY (fot_cod)
                             REFERENCES kom_Fotos, 
       FOREIGN KEY (pro_cod)
                             REFERENCES kom_Produtos
);



