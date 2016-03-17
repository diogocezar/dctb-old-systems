
CREATE TABLE ADMINISTRADORES (
       adm_id               INTEGER NOT NULL,
       adm_nome             VARCHAR(250) NOT NULL,
       adm_email            VARCHAR(50) NOT NULL,
       adm_login            VARCHAR(10) NOT NULL,
       adm_senha            VARCHAR(10) NOT NULL,
       PRIMARY KEY (adm_id)
);


CREATE TABLE PARCEIROS (
       par_id               INTEGER NOT NULL,
       par_link             VARCHAR(100) NOT NULL,
       par_descricao        LONGTEXT NOT NULL,
       adm_id               INTEGER NOT NULL,
       PRIMARY KEY (par_id), 
       FOREIGN KEY (adm_id)
                             REFERENCES ADMINISTRADORES
);


CREATE TABLE NOTICIAS (
       not_id               INTEGER NOT NULL,
       not_titulo           VARCHAR(250) NOT NULL,
       not_fonte            VARCHAR(250) NULL,
       not_descricao        LONGTEXT NOT NULL,
       adm_id               INTEGER NULL,
       not_quando           TIMESTAMP NOT NULL,
       PRIMARY KEY (not_id), 
       FOREIGN KEY (adm_id)
                             REFERENCES ADMINISTRADORES
);



